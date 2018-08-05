<?php

/*
 * Eventful
 * api https://api.eventful.com
 * documentation https://api.eventful.com/docs/events/search
 * test http://api.eventful.com/rest/events/search?app_key=D5khrSnCGrQQrXf3&category=food&page_size=50
 *
 * 
 *  
 */


class Eventful {
    
    protected $api_token='mqNC3DgLpFk26frd';
    
    public $category = '';
    
    /* list all option, witch use on site */
    protected $option_list;
    
    /* array id of langs */
    protected $langs_id;
    
    /* default lang code */
    protected $default_lang_code;
    
    /* default lang id */
    protected $default_lang_id;
    
    /* options script*/
    private $options = array(
            'inline_file_types' => '/\.(jpe?g)$/i',
            'max_properties_import' => '20',
    );
    
    private $result = array();
    private $result_fatal_error = false;
    private $eventful_limit_events = 50;
    private $eventful_offset_events = 0;
    private $count_events = 0;

    
    /* for max_exec_time */
    private $time_start = '';
    private $max_exec_time = '';
    
    
    private $settings= '';

    public function __construct($params = null) {
        
        $this->max_exec_time  = 120;
        if(config_item('max_exec_time'))
            $this->max_exec_time = config_item ('max_exec_time');
        
        if($params !== NULL && isset($params['allowed_execution_time']))
            $this->max_exec_time = $params['allowed_execution_time'];
        
        
        /* add libraries and model */
        $this->CI = &get_instance();
        $this->CI->load->model('estate_m');
        $this->CI->load->model('option_m');
        $this->CI->load->model('file_m');
        $this->CI->load->model('language_m');
        $this->CI->load->model('repository_m');
        $this->CI->load->library('uploadHandler', array('initialize'=>FALSE));
        $this->CI->load->library('ghelper');
        $this->CI->load->model('ads_m');
        $this->CI->load->model('settings_m');
        
        $this->settings = $this->CI->settings_m->get_fields();
        
        /* class var */
        $this->option_list=$this->get_option_list();
        
        $this->langs_id=$this->CI->option_m->languages;
        
        $this->default_lang_code= $this->CI->language_m->get_default();
        $this->default_lang_id= $this->CI->language_m->get_default_id();
    }
    
     /*
     * Start Import
     * 
     * @param (int) $page_size, count of max events for import, max avaible 250, min 10
     * 
     * @param boolen $developer_mode ignore $overwrite param
     * 
     * return array with info aboutr result
     */
    
    public function start_import($overwrite = FALSE, $event_type='food', $category='', $activated = TRUE, $eventful_limit_page = 50, $eventful_offset_page=0, $max_images=1, $location='',  $developer_mode = FALSE) {
        
        if(empty($this->time_start))
            $this->time_start = microtime(true);
            
        /* reset varibles */
        $this->result_fatal_error = false;
        $this->result = array();
       
        /* check exec_time */
        $time_end = microtime(true);
        $execution_time = $time_end - $this->time_start;
        if($execution_time>=$this->max_exec_time)
            return $this->result;
        
        set_time_limit(0);
        
        /* change to page limit to events limit */
        $this->eventful_limit_events = $eventful_limit_page;
        $eventful_limit_page = 250;
        /* end change to page limit to events limit */
        
        /* change to page limit to events limit */
        $this->eventful_offset_events = $eventful_offset_page;
        $eventful_offset_page = 0;
        /* end change to page limit to events limit */
                
        $eventful_offset_page ;
        
        for($page_number = $eventful_offset_page+1, $page_count = 1; $page_count<=$eventful_limit_page; $page_number++,$page_count++) {
            if($this->result_fatal_error) break;
             
            $this->import($overwrite, $event_type, $category, $activated, 250, $page_number, $max_images,$location, $developer_mode);
            
        }
        
        return $this->result;
    }
    
    
    
     /*
     * Start Import
     * 
     * @param (int) $page_size, count of max events for import, max avaible 250
     * 
     * @param boolen $developer_mode ignore $overwrite param
     * 
     */
    private function import($overwrite = FALSE, $event_type='food', $category='', $activated = TRUE, $page_size=250, $page_number=1, $max_images=1, $location='', $developer_mode = FALSE) {

        $this->category = $category;
        
        $url= "http://api.eventful.com/rest/events/search?date=future&location=".urlencode($location)."&app_key=".$this->api_token."&category=".$event_type."&image_sizes=whiteborder500&page_size=".$page_size.'&=page_number='.$page_number;
        
        // show link in console for devoloper_mode
        if($developer_mode)
            echo '<script type="text/javascript">console.log("'.$url.'");</script>';
       
        @$xml = file_get_contents($url);
        
        $this->dom=new DOMDocument();
        $this->dom->loadXML($xml);
        
        $xml_properties= $this->dom->getElementsByTagName('search')->item(0);
        
        if(!$xml_properties || !$xml_properties->hasChildNodes()) {
            if($developer_mode)
                echo '<script type="text/javascript">console.log("'. lang_check('XML is empty link: '.$url).'");</script>';
             
            $this->result_fatal_error = true;
            return false;
        }
        
        $xml_events = $xml_properties->getElementsByTagName('events')->item(0);
        
        $_count=0;
        $_count_skip= 0;
        $_count_exists=0;
        $_count_exists_overwrite=0;
        $info=array();
        
        if(!empty($this->result)) {
            if(isset($this->result['count_skip']))
                $_count_skip= $this->result['count_skip'];
            if(isset($this->result['count_exists']))
                $_count_exists= $this->result['count_exists'];
            if(isset($this->result['count_exists_overwrite']))
                $_count_exists_overwrite= $this->result['count_exists_overwrite'];
            if(isset($this->result['info']))
                $info= $this->result['info'];
        }
        /* start add new estate */

        foreach ($xml_events->getElementsByTagName('event') as $key => $xml_event) {
            
            if(!empty($this->eventful_offset_events) && $this->eventful_offset_events > $this->count_events) {
                $this->count_events++;
                continue;
            }
            $this->count_events++;
            
            if((count($info) - $_count_skip) >= $this->eventful_limit_events) {
                $this->result = array(
                    'info'=> $info,
                    'count_skip' => $_count_skip,
                    'count_exists_overwrite' => $_count_exists_overwrite,
                    'count_exists' => $_count_exists,
                    'message' => lang_check('limit expired')
                );
                $this->result_fatal_error = true;
                return false;
            }
            
            
            $is_exists = false;
            
            $time_end = microtime(true);
            $execution_time = $time_end - $this->time_start;
            if($execution_time>=$this->max_exec_time){
                // break import
                $this->result = array(
                    'info'=> $info,
                    'count_skip' => $_count_skip,
                    'count_exists_overwrite' => $_count_exists_overwrite,
                    'count_exists' => $_count_exists,
                    'message' => lang_check('max_exec_time reached, you can import again')
                );
                $this->result_fatal_error = true;
                return false;
            }
            
            $id=NULL;
            // skip
            if(!$xml_event)
                continue;
            
            // if this estate exists
            
            if(!$developer_mode){
                if(!$overwrite){
                $id_transitions=$xml_event->getAttribute('id');
                $id_transitions=trim($id_transitions);
                $query = $this->CI->db->get_where('property', array('id_trans_text' =>$id_transitions));
                    if($query && $query->row()) {
                        $result= $query->result()[0];
                        $_count_skip++;
                        $_count_exists++;
                        $info[]=array(
                            'address'=> '<p class="label label-info validation">'.lang_check('Event exists').'</p>',
                            'id'=> $xml_event->getAttribute('id'),
                            'preview_id'=> $result->id
                        );
                        continue;
                    }
                }
                
                // if overwright
                if($overwrite){
                    $id_transitions=$xml_event->getAttribute('id');
                    $id_transitions=trim($id_transitions);
                    $query = $this->CI->db->get_where('property', array('id_trans_text' =>$id_transitions));
                     if($query && $query->row()) {
                        $id=$query->row()->id;
                        $_count_exists_overwrite++;
                        $is_exists= true;
                     }
                }
            }
            /* main param */
            $data=array();
            
            if(!$is_exists)
                $data["date"]= date('Y-m-d H:i:s');
            
            //address
            $address= '';
            
            $address.= $this->get_XmlValue($xml_event,'venue_address','');
            $comma = '';
            
            if(!empty($address)){
                $comma = ',';
            }
            
            if( $this->get_XmlValue($xml_event,'city_name')){
                $address.= $comma.' '.$this->get_XmlValue($xml_event,'city_name','');
                $comma = ',';
            }
            
            if( $this->get_XmlValue($xml_event,'region_name')){
                $address.= $comma.' '.$this->get_XmlValue($xml_event,'region_name','');
                $comma = ',';
            }
            
            $address = str_replace(", Room number will be emailed to you after registration", '', $address); 
            
            $data["address"]=$address;                 
            
            $latitude = $this->get_XmlValue($xml_event,'latitude');
            $longitude =  $this->get_XmlValue($xml_event,'longitude');

            if(!empty($latitude) and !empty($longitude)) {
                $data["gps"]=$latitude.", ".$longitude;
            } else {
                if($google_gps){
                    // gps 
                    $gps = $this->CI->ghelper->getCoordinates($data["address"]);
                    $data["gps"]=$gps['lat'].", ".$gps['lng'];
                }
            }
            /* [Auto move gps coordinates few meters away if same exists in database] */
            $estate_same_coordinates = $this->CI->estate_m->get_by(array('gps'=>$data['gps']), TRUE);

            if(!empty($estate_same_coordinates))
            {
                $same_gps = explode(', ', $data['gps']);
                // $same_gps[0] && $same_gps[1] available
                $rand_lat = rand(1, 9);
                $rand_lan = rand(1, 9);
                
                $data['gps'] = ($same_gps[0]+0.00001*$rand_lat).', '.($same_gps[1]+0.00001*$rand_lan);
            }
            /* [/Auto move gps coordinates few meters away if same exists in database] */
            
            $data["is_featured"]= 0;
            
            
            $data["is_activated"]=($activated) ? '1' : '0';
            
            $id_transitions=$xml_event->getAttribute('id');
            $id_transitions=trim($id_transitions);
            $data["id_trans_text"]= $id_transitions; 
            
            $data["date_modified"]= date('Y-m-d H:i:s');
            
            //$data["date_activated"]= $data["date"];
            $data["type"]=NULL;
            
            $data['activation_paid_date']=NULL;
            $data['featured_paid_date']=NULL;

            /* end main param */ 
            
            // add options for property
            
            // dinamic option 
            $options_data= array();
            $options_data = $this->get_option($xml_event);
            
            if($this->CI->session && $this->CI->session->userdata('id'))
                $options_data['agent']=$this->CI->session->userdata('id');
            else 
                $options_data['agent']=1;
            /* skip */
            
            if(isset($options_data['field_error'])) {
                $_count_skip++;
                $info[]=array(
                    'address'=> $options_data['field_error'],
                    'id'=> $id_transitions
                );
                continue;
            }
            
            /* end skip */
            
            /* added new property */
            
            $insert_id = $this->CI->estate_m->save($data, $id);  
            if(empty($insert_id))
            {
                echo 'QUERY: '.$this->CI->db->last_query();
                echo '<br />';
                echo 'ERROR: '.$this->CI->db->_error_message();
                exit();
            }
            
            $this->CI->estate_m->save_dynamic($options_data, $insert_id);
            
            
            /* end added new property */
            
            /* hot fix json_object = 0 */
            $result = $this->CI->db->get_where('property_lang', array('json_object' =>'0', 'property_id'=>$insert_id));
            if($result->row()){
              
                $_count_skip++;
                $info[]=array(
                    'address'=> '<p class="label label-important validation">Skipped, can`t created json_object</p>',
                    'id'=> $xml_event->getAttribute('id'),
                    'preview_id'=> ''
                );
                
                $this->CI->estate_m->delete($insert_id);
                continue;
            }
            /* hot fix json_object = 0 */
            
            if(!$is_exists)
                $this->add_individual_ads($xml_event, $insert_id);
            
            /* search values */ 
            $data['search_values'] ='id: '.$insert_id;
            $data['search_values'] .= ' '.$data['address'];
            foreach($options_data as $key=>$val)
            {
                $pos = strpos($key, '_');
                $option_id = substr($key, 6, $pos-6);
                $language_id = substr($key, $pos+1);
                
                if(!isset($options_type[$option_id]['TEXTAREA']) && !isset($options_type[$option_id]['CHECKBOX'])){
                   $data['search_values'].=' '.$val;
                }
                
                //  values for each language for selected checkbox
                if(isset($options_type[$option_id]['CHECKBOX'])){
                    if(!empty($val))
                    {
                        $data['search_values'].=' true'.$options_name[$option_id][$language_id];
                    }
                }
            }

            /* end search values */
                    
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
             
            if($xml_event->getElementsByTagName('image'))
                $xml_images = $xml_event->getElementsByTagName('image')->item(0);
           
            if(isset($xml_images) && !empty($xml_images->hasChildNodes())) {
                
                if($xml_images->getElementsByTagName('whiteborder500'))
                    $xml_images = $xml_images->getElementsByTagName('whiteborder500')->item(0);
                
                $image_link = $this->get_XmlValue($xml_images, 'url');
                
                $next_order=0;
                if($max_images>$next_order){
                    $image_link = str_replace('/whiteborder500/', '/perspectivecrop290by250/', $image_link);
                    if(!empty($image_link) && $file_name = $this->do_upload(trim($image_link))){
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
            $update_data['search_values'] = $data['search_values'];
            $this->CI->estate_m->save($update_data, $insert_id);  
            // add options for property
            
            /* end create  image_repository and image_filename */
            
            /* end Add file to repository */
            $_count++;
            
            $info_address = $data["address"];
            if(empty($info_address) && isset($options_data['option10_'.$this->default_lang_id]))
                $info_address = $options_data['option10_'.$this->default_lang_id];
            $info[]=array(
                'address'=> $info_address,
                'id'=> $xml_event->getAttribute('id'),
                'preview_id'=> $insert_id
            );
        }
        
        /* end start add new estate */
        $this->result = array(
            'info'=> $info,
            'count_skip' => $_count_skip,
            'count_exists_overwrite' => $_count_exists_overwrite,
            'count_exists' => $_count_exists
        );
    }
    
    /*
     * Filter and add options with lang id
     * 
     * @param $xml_property array array with options array(optin10=>value);
     * @return array current for all lang options;
     * 
     * for other lang just copy
     */    
    protected function get_option($xml_property){
        $current_date = date('Y-m-d H:i:s');
        $options_data = $this->get_dynamicFields($xml_property);
        $options_prepared = array();
        
            foreach($this->option_list as $key=>$option) {
                $option_name=mb_strtolower(trim($option['option']));
                
                /* only one lang 
                if($this->default_lang_id !== $option["language_id"] ) continue;
                */
                
                $index_option='option'.$option["id"].'_'.$option["language_id"];
                
                /* check if start date */
                    if('option'.$option["id"] =='option81') {
                        $val= trim($options_data['option'.$option["id"]]);

                        if(empty($val)) {
                            $options_prepared['field_error'] = '<p class="label label-important validation">'
                                                            .lang_check("Misssing start date")
                                                            .'</p>';
                        } elseif(!empty($val) && $val<$current_date) {
                            $options_prepared['field_error'] = '<p class="label label-important validation">'
                                                            .lang_check("Start Date already started")
                                                            .'</p>';
                        }
                    }
                
                /* end check if start date */
                
                /* check if empty stop date */
                    if('option'.$option["id"] =='option82') {
                        $val= trim($options_data['option'.$option["id"]]);

                        if(empty($val)) {
                            
                            $data['enddate'] = date('Y-m-d H:i:s', $data['enddate']);
                            
                            $options_prepared['field_error'] = '<p class="label label-important validation">'
                                                            .lang_check("Misssing stop date")
                                                            .'</p>';
                        } 
                    }
                
                /* end check if start date */
                    
                /* check if value missing in dropdown */
                
                if($this->default_lang_id == $option["language_id"])
                    if($option['type'] == 'DROPDOWN' && isset($options_data['option'.$option["id"]])) {
                        $val= trim($options_data['option'.$option["id"]]);

                        if(!empty($val) && strrpos($option['values'], $val)===FALSE) {
                            /*text for translate */
                            $options_prepared['field_error'] = '<p class="label label-important validation">'
                                                            .lang_check("In values for field_id").'="'.$option['id'].'"'
                                                            .lang_check("and lang code").'  "'.$option['code'].'" '
                                                            .lang_check("missing value"). ' "'.$val.'". '
                                                            .lang_check("Please add new value for field and continue import")
                                                            .' #<a href="'.site_url("admin/estate/edit_option/".$option['id']).'" style="color: #FFFFFF;font-weight: 600;">'.lang_check("Edit field").'</a>'
                                                            .'</p>';
                            //return $options_prepared; //stop methood
                            /*
                            echo $option['values'];
                            echo '<br>'.PHP_EOL;
                            echo $val;
                            var_dump(strrpos($option['values'], $val));
                            exit();*/
                        }
                    }
                
                /* end check if value missing in dropdown */
                
                if(isset($options_data['option'.$option["id"]]))
                {
                    // php 5.3
                    $val = trim($options_data['option'.$option["id"]]);
                    $val = htmlspecialchars($val);
                    
                    if($option['type'] == 'TEXTAREA')
                        $options_prepared[$index_option] = $val;
                    else {
                        $options_prepared[$index_option] = strip_tags($val);
                    }
                  }
                else {
                    $options_prepared[$index_option]='';
                }
                
            }
        if(!empty($options_prepared)) {
            return $options_prepared;
        } else {
            return false;
        }
    }
    
    /*
     * parser Dynamic fields from xml property node
     * 
     * @param object $xml_property node from xml 
     * 
     * return fields with index from db
     */
    protected function get_dynamicFields($xml_property) {
        $options_data = array();
        
        //shortDescription
        $options_data['option8'] = $this->get_XmlValue($xml_property,'description');
        
        //date
        $options_data['option81'] = $this->get_XmlValue($xml_property,'start_time');
        
        $options_data['option82'] = $this->get_XmlValue($xml_property,'stop_time');
        
        if(empty( $options_data['option82']) && !empty($options_data['option81'])) {
            $options_data['option82'] = date('Y-m-d H:i:s',strtotime($options_data['option81'].' +1 week'));
        }
        
        //description
        $options_data['option17'] = $this->get_XmlValue($xml_property,'description');

        //title
        $options_data['option10'] = $this->get_XmlValue($xml_property,'title');

        //url
        $options_data['option69'] = $this->get_XmlValue($xml_property,'venue_url');

        //postal_code
        $options_data['option40'] = $this->get_XmlValue($xml_property,'postal_code');

        //country  save in County
        $options_data['option5'] = $this->get_XmlValue($xml_property,'country_name');

        //country
        $options_data['option7'] = $this->get_XmlValue($xml_property,'city_name');

        //category
        $options_data['option79'] = $this->category;
            
        return $options_data;
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
            
            if(preg_match($this->options['inline_file_types'], $url_image) && @$file=file_get_contents($url_image)) {
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
        
    /*
     * Return array with categories from http://api.eventful.com/rest/categories/list
     * 
     */
    public function get_categories(){
        $url = "http://api.eventful.com/rest/categories/list?app_key=".$this->api_token;
        @$xml = file_get_contents($url);
        
        $this->dom=new DOMDocument();
        $this->dom->loadXML($xml);
        
        if($this->dom->getElementsByTagName('categories')->item(0))
            $categories= $this->dom->getElementsByTagName('categories')->item(0);
        
        $categories = $this->dom->getElementsByTagName('category');
        $_categories = array();
        foreach ($categories as $key => $category) {
            $id = $this->get_XmlValue($category, 'id');
            $name = $this->get_XmlValue($category, 'name');
            $_categories[$id] = str_replace('&amp;', '&', $name);
        }
        
        return $_categories;
        
    }  
    
    /*
     * Return array with categories from http://api.eventful.com/rest/categories/list
     * 
     */
    public function get_count_pages($event_type='music', $page_size=250, $location=''){
        
        $url= "http://api.eventful.com/rest/events/search?date=future&location=".urlencode($location)."&app_key=".$this->api_token."&category=".$event_type."&image_sizes=whiteborder500&page_size=".$page_size;
        
        @$xml = file_get_contents($url);
        $this->dom=new DOMDocument();
        $this->dom->loadXML($xml);
        
        $xml_root= $this->dom->getElementsByTagName('search')->item(0);
        
        if(!$xml_root || !$xml_root->hasChildNodes()) {
            return false;
        }
        $page_count = $this->get_XmlValue($xml_root, 'total_items', false);
        
        return $page_count;
        
    }  
    
    /*
     * get Value from XML for name node
     * @parem $start_node object node xml where need searsh
     * @param $name_node string  name node where need get Value
     * 
     * @return string nodeValue or empty string
     */
    protected function get_XmlValue($start_node, $name_node, $default=FALSE){
        $node_value='';
        
        if($start_node && $start_node->getElementsByTagName($name_node)->item(0) && !empty($start_node->getElementsByTagName($name_node)->item(0)->nodeValue))
            $node_value=trim($start_node->getElementsByTagName($name_node)->item(0)->nodeValue);
            
        if(!empty($node_value)) {
            $node_value = strip_tags($node_value);
            $node_value = htmlspecialchars($node_value);
            return $node_value; 
        } else {
            return $default ;
        }
    }
    
    function optionDetails () {
        $options_names = $this->CI->option_m->get_lang(NULL, FALSE, $this->default_lang_id );
        
        $options = array();
        
        foreach($options_names as $key=>$row)
        {
            $options['options_name_'.$row->option_id] = $row->option;
            $options['options_suffix_'.$row->option_id] = $row->suffix;
            $options['options_prefix_'.$row->option_id] = $row->prefix;
            $options['options_values_'.$row->option_id] = $row->values;
            $options['options_type_'.$row->option_id] = $row->type;
        }
        
        return $options;
    }
    
    protected function get_option_list () {
        /* table names */
        $_table_name = 'option';

        $this->CI->db->select($_table_name.'.*, '.$_table_name.'_lang.*, language.code');
        $this->CI->db->from($_table_name);
        $this->CI->db->join($_table_name.'_lang', $_table_name.'.id = '.$_table_name.'_lang.option_id');
        $this->CI->db->join('language', 'language.id = option_lang.language_id');
        $this->CI->db->order_by($_table_name.'.id');
        $array = $this->CI->db->get()->result_array();

        return $array;

    }
    
    /*
     * add ads for event
     * @param (object dom xml) xml object from https://api.eventful.com
     * @param (int) id listing page for ads
     * 
     */
    protected function add_individual_ads ($xml_property, $id_preview){
        
        $data = array();
        
        $data['title']= $this->get_XmlValue($xml_property,'title');
        $data['type']= 1;
        $data['description']= $this->get_XmlValue($xml_property,'description');
        $data['link']= slug_url('property/'.$id_preview.'/'.$this->default_lang_code.'/'.url_title_cro($data['title'], '-', TRUE), 'page_m');
        $data['is_activated']=1;
        
        $start_time = $this->get_XmlValue($xml_property,'start_time');
        if(empty($start_time)){
            $start_time = date('Y-m-d H:i:s');
        }
        
        $data['enddate']=$this->get_XmlValue($xml_property,'stop_time','');
        
        // if empy in xml (stop_data), get from admin->setting
        if(empty($data['enddate'])){
            $data['enddate'] = strtotime($start_time)+$this->settings['listing_expiry_days']*86400;
            $data['enddate'] = date('Y-m-d H:i:s', $data['enddate']);
        }
        
        $data['is_activated']=1;
        
        $insert_id = $this->CI->ads_m->save($data, NULL);
        
        /* create repositiry */

        $ads=$this->CI->ads_m->get($insert_id);
        // Fetch file repository
        $repository_id = $ads->repository_id;
        if(empty($repository_id))
        {
            // Create repository
            $repository_id = $this->CI->repository_m->save(array('name'=>'ads_m'));

            // Update estate object with new repository_id
            $this->CI->ads_m->save(array('repository_id'=>$repository_id), $ads->id);
        }

        /* end create repositiry */
        /* Add file to repository */
        // upload foto;

        if($xml_property->getElementsByTagName('image'))
            $xml_images = $xml_property->getElementsByTagName('image')->item(0);

        if(isset($xml_images) && !empty($xml_images->hasChildNodes())) {

            if($xml_images->getElementsByTagName('whiteborder500'))
                $xml_images = $xml_images->getElementsByTagName('whiteborder500')->item(0);

            $image_link = $this->get_XmlValue($xml_images, 'url');

            $next_order=0;
            if(!empty($image_link) && $file_name = $this->do_upload(trim($image_link))){
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
    
    /*
     * Delete events
     */
    public function delete_events_by_ads($where=array()) {
        
        $expire_ads=$this->CI->ads_m->get_by($where);
        foreach ($expire_ads as $key => $ads) {
            $ads_link = $ads->link;
            $ads_id = $ads->id;
            $property_id = '';
            
            // if have link to listing
            if(strripos ($ads_link, 'property/') !== FALSE) { 
                $site_url = site_url();
                $property_page_link =  str_replace($site_url, '', $ads_link);
                $property_page_p = substr($property_page_link, strripos ($property_page_link,'property/')+strlen('property/'));
                $property_page_p = explode('/', $property_page_p);
                $property_id = $property_page_p[0];

                //remove property
                $this->CI->estate_m->delete($property_id);
                // remove ads 
                $this->CI->ads_m->delete($ads_id);
                
            }
        }
    }
    
    /*
     * Delete expired events by ads,
     */
    public function delete_expiredevents_by_ads($id = NULL) {
        
        $where = array();
        $where['enddate <'] = date('Y-m-d H:i:s');
        if($id !== NULL)
            $where['id'] = $id;
        
        $this->delete_events_by_ads($where);
    }
    
    /*
     * Delete expired events search in listing by category
     * 
     * @param (string) $category, category from field 79
     * 
     */
    public function delete_expiredevents_by_category($category = NULL) {
        if(empty($category)) return false;
        
        $listings=$this->CI->estate_m->get_by(array('json_object LIKE'=>"%\"field_79\":\"$category\"%"));
        
       // print_r($listings);
        foreach ($listings as $key => $listing) {
            $expire_ads=$this->CI->ads_m->get_by(array('link LIKE'=>"%property/".$listing->id."%",'enddate <'=>date('Y-m-d H:i:s')));
            
            if($expire_ads){
                //remove property
                $this->CI->estate_m->delete($listing->id);
                // remove ads 
                $this->CI->ads_m->delete($expire_ads[0]->id); 
            }
        }
    }
    
}