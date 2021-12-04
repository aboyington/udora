<?php
/*
 * 
 *  test link https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=-33.8670,151.1957&radius=500&types=food&name=cruise&key=
 */

class Import_google_places {
    protected $api_key='AIzaSyArqScnm2PDzRvEIAGXpULA4AOvVe8LtCY';
    public $caching_results =array();


    public function __construct() {
        
        /* add libraries and model */
        $this->CI = &get_instance();
        $this->CI->load->model('estate_m');
        $this->CI->load->model('option_m');
        $this->CI->load->model('file_m');
        $this->CI->load->model('language_m');
        $this->CI->load->model('repository_m');
        $this->CI->load->library('uploadHandler', array('initialize'=>FALSE));
        $this->CI->load->library('ghelper');
        
        
        /* class var */
    }
    
    private  function _caching_results($token = NULL, $gps_google = NULL,$radius= '500', $type= 'food', $name= '', $language = 'en') {
        
        if($token === NULL) {
            $url='https://maps.googleapis.com/maps/api/place/nearbysearch/json?location='.$gps_google.'&radius='.$radius.'&types='.$type.'&name='.$name.'&language='.$language.'&key='.$this->api_key;
        } else {
            $url='https://maps.googleapis.com/maps/api/place/nearbysearch/json?pagetoken='.$token.'&key='.$this->api_key;
        }
        
        $json=  file_get_contents($url);
        $json = json_decode($json);

        if($json->status=='INVALID_REQUEST') {
            return $this->caching_results;;
        }

        if($json->status!=='OK') {
            return $this->caching_results;
        }
        //print_r($json->results);

        $this->caching_results = array_merge ($this->caching_results, $json->results);

        if(isset($json->next_page_token) && !empty($json->next_page_token)) {
            $this->_caching_results($json->next_page_token);
        }
        
        return $this->caching_results;
    }


    public function import ($gps = NULL, $radius= '500', $type= 'food', $name= '', $preview = FALSE, $language = 'en', $where_id=NULL, $category=NULL, $marker_category = NULL, $max_images=1, $geocode = false) {
                        if(empty($gps)) return false;
        
                        
                        $id_lang_definded = $this->CI->language_m->get_id($language);
                        
                        $id = null;
                        $time_start = microtime(true);
                        $max_exec_time = 120;
                        if(config_item('max_exec_time'))
                            $max_exec_time = config_item ('max_exec_time');
                        
                        $gps_google=  str_replace(' ', '', $gps);
                        
                        if(empty($this->caching_results))
                            $this->_caching_results(NULL, $gps_google, $radius, $type, $name, $language);
                        
                        /* import or preview start */
                        /* data */
                        $preview_data= array(); 
                        if(!empty($this->caching_results))
                            foreach ($this->caching_results as $key => $item) {
                                //sleep(7);
                                $id = NULL;
                                $time_end = microtime(true);
                                $execution_time = $time_end - $time_start;
                                if(!$preview && $execution_time>=$max_exec_time){
                                    // break import
                                    return array(
                                        'preview_data'=> $preview_data,
                                        'message' => lang_check('max_exec_time reached, you can import again')
                                    );
                                } 
                                
                                
                                $property_exists = false;
                                if(!empty($where_id)) {
                                    if(in_array($item->id, $where_id) == FALSE) continue;
                                }
                                
                                $data=array();
                                $data["date"]= date('Y-m-d H:i:s');

                                $data["is_featured"]= 0;
                                $data["is_activated"]=1;
                                $data["id_transitions"]=$this->ascii_to_dec_summ($item->id); 
                                
                                //id_transitions continue if exists
                                $query = $this->CI->estate_m->get_by(array('id_transitions' =>$data["id_transitions"]));
                                    if($query) {
                                        $property_exists= true;
                                        $id=$query[0]->id;
                                        $dynamic_array = $this->CI->estate_m->get_dynamic_array($id);
                                        //if not preview, continue
                                        if(!$preview) {
                                            //continue;
                                        }
                                    }
                                
                                //if gps exists    
                                $data['gps']=$item->geometry->location->lat.', '.$item->geometry->location->lng;
                                $query = $this->CI->estate_m->get_by(array('gps' =>$data["gps"]));
                                if($query) {
                                    $property_exists= true;
                                    $id=$query[0]->id;
                                    $dynamic_array = $this->CI->estate_m->get_dynamic_array($id);
                                    //if not preview, continue
                                    if(!$preview) {
                                        //continue;
                                    }
                                }
                                
                                $data["type"]=$type;
                                $data['activation_paid_date']=NULL;
                                $data['featured_paid_date']=NULL;
                               
                                $data['address']=  $item->vicinity;
                                
                                $geocode_country ='';
                                $geocode_city ='';
                                $geocode_address ='';
                                if($geocode && !$preview){
                                    $geocode_data = $this->getGeocode($data['gps'],$language);
                                    if(!empty($geocode_data)){
                                        foreach ($geocode_data->address_components as $address_component) {
                                            foreach ($address_component->types as $key => $address_component_type) {
                                                if($address_component_type=='country') {
                                                    $geocode_country = $address_component->long_name;
                                                }
                                                if($address_component_type=='locality') {
                                                    $geocode_city = $address_component->long_name;
                                                }
                                            }
                                        }
                                        if(isset($geocode_data->formatted_address))
                                            $geocode_address = $geocode_data->formatted_address;

                                        if(!empty($geocode_address))
                                            $data['address'] = $geocode_address;
                                    }
                                }
                                
                                $options_data=array();
                                foreach ($this->CI->option_m->languages as $id_lang => $value) {
                                    if(!$property_exists || ($property_exists  &&  $id_lang == $id_lang_definded)) {
                                        $options_data['option10_'.$id_lang]= $item->name;
                                        $options_data['option8_'.$id_lang]= $item->vicinity;
                                        $options_data['option17_'.$id_lang]= $item->vicinity;
                                        $options_data['option78_'.$id_lang]=  implode(',', $item->types);
                                    } 
                                    else {
                                        $options_data['option10_'.$id_lang]= $dynamic_array['option10_'.$id_lang];
                                        $options_data['option8_'.$id_lang]= $dynamic_array['option8_'.$id_lang];
                                        $options_data['option17_'.$id_lang]= $dynamic_array['option17_'.$id_lang];
                                        $options_data['option78_'.$id_lang]= $dynamic_array['option78_'.$id_lang];
                                    }
                                    
                                    if(!empty($category)){
                                        $options_data['option2_'.$id_lang]= $category;
                                    }

                                    if(!empty($marker_category)){
                                        $options_data['option6_'.$id_lang]= $marker_category;
                                    }
                                    
                                    if($geocode && !$preview){
                                        $options_data['option5_'.$id_lang]= $geocode_country;
                                        $options_data['option7_'.$id_lang]= $geocode_city;
                                    }
                                }
                               
                                 if(!$preview) {
                                    $options_data['agent']=$this->CI->session->userdata('id');

                                    // create new property or update
                                    $insert_id = $this->CI->estate_m->save($data, $id);  
                                    if(empty($insert_id))
                                    {
                                        echo 'QUERY: '.$this->CI->db->last_query();
                                        echo '<br />';
                                        echo 'ERROR: '.$this->CI->db->_error_message();
                                        exit();
                                    }
                                    // add options for property
                                    $this->CI->estate_m->save_dynamic($options_data, $insert_id);
                                    
                                       /* create repositiry */
                                        
                                    if(!$property_exists){
                                        $estate=$this->CI->estate_m->get_dynamic($insert_id);
                                        // Fetch file repository
                                        $repository_id = $estate->repository_id;
                                        if(empty($repository_id))
                                        {
                                            // Create repository
                                            $repository_id = $this->CI->repository_m->save(array('name'=>'estate_m'));

                                            // Update estate object with new repository_id
                                            $this->CI->estate_m->save(array('repository_id'=>$repository_id), $estate->id);
                                        }

                                        /* end create repositiry */
                                        /* Add file to repository */
                                        // upload foto;
                                        $next_order = 0;
                                        if(!empty($item->photos)) {
                                        foreach ($item->photos as $key => $photos) {
                                            if($next_order>=$max_images) break;
                                            
                                             if($file_name = $this->do_upload(trim($photos->photo_reference))){
                                                 $file_id = $this->CI->file_m->save(array(
                                                 'repository_id' => $repository_id,
                                                 'order' => $next_order,
                                                 'filename' => $file_name,
                                                 'filetype' => 'image/jpeg'
                                                 )); 
                                                 $next_order++;
                                            } 
                                         }  
                                        }
                                        /* create  image_repository and image_filename */

                                       // $repository_id
                                        $update_data = array();
                                       // $update_data['search_values'] = $data['search_values'];
                                        $update_data['search_values'] = '';
                                        
                                        $this->CI->estate_m->save($update_data, $insert_id);  
                                        /* end create  image_repository and image_filename */
                                    }
                                        
                                    
                               }
                               
                            $data['id']= $item->id;
                            if(isset($insert_id))
                                $data['preview_id']= $insert_id;
                            
                            $data['name']= $item->name;
                            $data['types_google']= $item->types;
                            $data['exists']= false;
                            if($property_exists) {
                                $data['exists'] = true;
                            }
                            
                            $preview_data[]=$data;
                            }
                        /* end data */
                        
            if(!empty($preview_data))
                return array(
                        'preview_data'=> $preview_data
                    );
            
         return false;
        
    }
   
    /*
     * Conver ASCII to number and return summ
     * 
     * @param $str (string) ASCII string
     * return summ
     * 
     */
    public function ascii_to_dec_summ($str)
        {
          $summ=0;
          for ($i = 0, $j = strlen($str); $i < $j; $i++) {
            //$dec_array[] = ord($str{$i});
              $summ+= ord($str{$i});
          }
          
          return $summ;
        }
    
    public function getAddress ($gps, $lang='en') {
        if(empty($gps)) return false;
        
        $gps_google=  str_replace(' ', '', $gps);
        $url='http://maps.googleapis.com/maps/api/geocode/json?latlng='.$gps_google.'&sensor=true&language='.$lang;
        $json=  file_get_contents($url);
        $json= json_decode($json);
        
        if($json->status=='OK') {
            if(!empty($json->results[0]->formatted_address))
                return $json->results[0]->formatted_address;
        }
        
        return false;
        
    }
    
    public function getGeocode ($gps, $lang='en') {
        if(empty($gps)) return false;
        
        $gps_google=  str_replace(' ', '', $gps);
        $url='http://maps.googleapis.com/maps/api/geocode/json?latlng='.$gps_google.'&sensor=true&language='.$lang;
        $json=  file_get_contents($url);
        $json= json_decode($json);
        
        if($json->status=='OK') {
            if(!empty($json->results[0]))
                return $json->results[0];
        }
        
        return false;
        
    }
    
    /*
     * Upload image from link
     * 
     * @param string $file_link link with image
     * @return file name or false
     */
    protected function do_upload($photo_reference)
        {
            if(empty($photo_reference)) return false;
            
            $url_image='https://maps.googleapis.com/maps/api/place/photo?maxwidth=1400&photoreference='.$photo_reference.'&key='.$this->api_key;
            
            if(@$file=file_get_contents($url_image)) {
                $new_file_name=time().rand(000, 999).'.jpg';
                file_put_contents(FCPATH.'/files/'.$new_file_name, $file);
                /* create thumbnail */
                $this->CI->uploadhandler->regenerate_versions($new_file_name);
                /* end create thumbnail */
                return $new_file_name;
            } else {
                return false;
            }
        }
}