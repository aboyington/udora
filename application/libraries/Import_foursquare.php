<?php

/*
 * Import Import_foursquare placces
 * api https://developer.foursquare.com
 * documentation https://developer.foursquare.com/docs/venues/explore
 * test https://api.foursquare.com/v2/venues/explore?ll=40.7,-74&oauth_token=G0EZ51NXVYDAXGHHYVKLCKJX5ZF4LPA4TIKLPQ3U1MSFXT33&v=20161024
 *
 * 
 *  
 */


class Import_foursquare {
    protected $api_token='HS525WXVSPY2K4CDSWHUAZMRUKH3M2Q2CGS3OXP1LJX0CWSB';
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
        
    }
    
    
    /*
     * Import places from https://api.foursquare.com
     * 
     * @param (string) $gps, google gps
     * @param (string) $radius, places radius around  $gps
     * @param (string) $type, set one type from https://developer.foursquare.com/docs/venues/explore
     * @param (string) $name,  false
     * @param (string) $preview, if only preview set TRUE, if import set FALSE
     * @param (array)  $where_id, with id places from api.foursquare.com for import
     * @param (string) $category, category into places are import
     * @param (string) $marker_category, marker into places are import
     * @param (string, int) $max_images, count of max images per property for import
     */
    
    public function import ($gps= NULL, $radius= '250', $type= 'food', $name= '', $preview = FALSE, $where_id=NULL, $category=NULL, $marker_category = NULL, $max_images = 1) {
                        if(empty($gps)) return false;
                        
                        $time_start = microtime(true);
                        $max_exec_time = 120;
                        if(config_item('max_exec_time'))
                            $max_exec_time = config_item ('max_exec_time');

                        //ini_set('max_execution_time', $max_exec_time);
                        
                        /* names options on all langs */
                        if(!$preview) {
                            $options_type = array();
                            foreach($this->CI->option_m->get() as $key=>$val)
                            {
                                $options_type[$val->id][$val->type] = 'true';
                            }

                            $options_name= array();
                            foreach ($this->CI->option_m->languages as $id=>$v){
                                foreach ($this->CI->option_m->get_field_list($id) as $key => $value) {
                                    $options_name[$key][$id]=$value->option;
                                }
                            }
                        }
                        /* end names options on all langs */
                        
                        $gps_google=  str_replace(' ', '', $gps);
                        $url = 'https://api.foursquare.com/v2/venues/explore?ll='.$gps_google.'&oauth_token='.$this->api_token.'&v=20160925&radius='.$radius.'&section='.$type.'';
                        
                        @$json = file_get_contents($url);
                        $json= json_decode($json);
                        
                        if($json->meta->code == '410') {
                            exit('Api error last link: '.$url);
                        }
                        
                        if(empty($json->response) ){
                            return array();
                        }
                        
                        /* import or preview start */
                        /* data */
                       
                        $preview_data= array(); 
                            foreach ($json->response->groups[0]->items as $key => $item) {
                                $time_end = microtime(true);
                                $execution_time = $time_end - $time_start;
                                if(!$preview && $execution_time>=$max_exec_time){
                                     return array('data'=>$preview_data,
                                                  'message'=>lang_check('max_exec_time reached, you can import again')
                                                );
                                }
                                
                                $property_exists = false;
                                $id = NULL;
                                if(!empty($where_id)) {
                                    if(in_array($item->venue->id, $where_id) == FALSE) continue;
                                }
                                
                                $data=array();
                                $data["date"]= date('Y-m-d H:i:s');

                                $data["is_featured"]= 0;
                                $data["is_activated"]=1;
                                $data["id_transitions"]=$this->ascii_to_dec_summ($item->venue->id); 
                                
                                //id_transitions continue if exists
                                $query = $this->CI->estate_m->get_by(array('id_transitions' =>$data["id_transitions"]));
                                    if($query) {
                                        $property_exists= true;
                                        //if not preview, continue
                                        if(!$preview) {
                                            continue;
                                        }
                                    }

                                //if gps exists    
                                $data['gps']=$item->venue->location->lat.', '.$item->venue->location->lng;
                                $query = $this->CI->estate_m->get_by(array('gps' =>$data["gps"]));
                                if($query) {
                                    $property_exists= true;
                                    //if not preview, continue
                                    if(!$preview) {
                                        continue;
                                    }
                                }
                                
                                $data["type"]=$category;
                                $data['activation_paid_date']=NULL;
                                $data['featured_paid_date']=NULL;
                               
                                //Address by json or if missing by gps ith google API
                                if(isset($item->venue->location->formattedAddress) && !empty($item->venue->location->formattedAddress))
                                    $data['address']= implode($item->venue->location->formattedAddress);
                                else
                                    $data['address']=  $this->getAddress($data['gps']);
                                
                                $options_data=array();
                                foreach ($this->CI->option_m->languages as $id_lang => $value) {
                               
                                    $options_data['option10_'.$id_lang]= _ch($item->venue->name, '');
                                    $options_data['option8_'.$id_lang]= _ch($item->tips[0]->text, '');
                                    $options_data['option17_'.$id_lang]= _ch($item->tips[0]->text, '');
                                    $options_data['option78_'.$id_lang]= _ch($item->categories->name, '');
                                    $options_data['option78_'.$id_lang]= strtolower($options_data['option78_'.$id_lang]);
                                    
                                    if(!empty($category)){
                                        $options_data['option2_'.$id_lang]= $category;
                                    }
                                    
                                    if(!empty($marker_category)){
                                        $options_data['option6_'.$id_lang]= $marker_category;
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
                                        if(!empty($item->tips[0]->photourl)) {
                                            $next_order = 0;
                                            foreach ($item->tips as $tips ){
                                            if($next_order >= $max_images) break;
                                            $image = _ch($tips->photourl, '');
                                             if($file_name = $this->do_upload(trim($image))){
                                                 
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

                                        /* search values */ 
                                        $update_data = array();
                                        $update_data['search_values'] ='id: '.$insert_id;
                                        $update_data['search_values'] .= ' '.$data['address'];
                                        
                                        foreach($options_data as $key=>$val)
                                        {
                                            $pos = strpos($key, '_');
                                            $option_id = substr($key, 6, $pos-6);
                                            $language_id = substr($key, $pos+1);

                                            if(!isset($options_type[$option_id]['TEXTAREA']) && !isset($options_type[$option_id]['CHECKBOX'])){
                                               $update_data['search_values'].=' '.$val;
                                            }

                                            //  values for each language for selected checkbox
                                            if(isset($options_type[$option_id]['CHECKBOX'])){
                                                if(!empty($val))
                                                {
                                                    $update_data['search_values'].=' true'.$options_name[$option_id][$language_id];
                                                }
                                            }
                                        }

                                        /* end search values */
                                        $this->CI->estate_m->save($update_data, $insert_id);  
                                        /* end create  image_repository and image_filename */
                                        
                               }
                               
                            $data['id']= $item->venue->id;
                            if(isset($insert_id))
                                $data['preview_id']= $insert_id;
                            
                            $data['name']= _ch($item->venue->name, '');
                            $data['types_google']=_ch($item->categories->name, '');
                            $data['exists']= false;
                            if($property_exists) {
                                $data['exists'] = true;
                            }
                            
                            $preview_data[]=$data;
                            }
                        /* end data */
                        
            if(!empty($preview_data))
                return array('data'=>$preview_data);
            
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
    
    public function getAddress ($gps) {
        if(empty($gps)) return false;
        
        $gps_google=  str_replace(' ', '', $gps);
        $url='http://maps.googleapis.com/maps/api/geocode/json?latlng='.$gps_google.'&sensor=true';
        $json=  file_get_contents($url);
        $json= json_decode($json);
        
        if($json->status=='OK') {
            if(!empty($json->results[0]->formatted_address))
                return $json->results[0]->formatted_address;
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
            
            $url_image=$photo_reference;
            
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