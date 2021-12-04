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


class Eventbrite {
    
    protected $api_token='ACXIMMLLHLNA4EKC6RNB';
    public $category = '';
    
    
    public $event_categories = array(
        '103'=>'Music',
        '101'=>'Business & Professional',
        '110'=>'Food & Drink',
        '113'=>'Community & Culture',
        '104'=>'Film, Media & Entertainment',
        '108'=>'Sports & Fitness',
        '107'=>'Health & Wellness',
        '102'=>'Science & Technology',
        '109'=>'Travel & Outdoor',
        '111'=>'Charity & Causes',
        '114'=>'Religion & Spirituality',
        '115'=>'Family & Education',
        '116'=>'Seasonal & Holiday',
        '112'=>'Government & Politics',
        '106'=>'Fashion & Beauty',
        '117'=>'Home & Lifestyle',
        '118'=>'Auto, Boat & Air',
        '119'=>'Hobbies & Special Interest',
        '120'=>'School Activities',
        '199'=>'Other',
    );
    
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
    
    public function start_import($overwrite = FALSE, $event_keyword='', $category='', $activated = TRUE, $eventful_limit_page = 1, $eventful_offset_page=0, $location='', $date_start='', $date_end='', $developer_mode = FALSE) {
        
        
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
        /* end change to page limit to events limit */
        
        /* change to page limit to events limit */
        $this->eventful_offset_events = $eventful_offset_page;
        /* end change to page limit to events limit */
                
        for($page_number = $eventful_offset_page+1, $page_count = 1; $page_count<=$eventful_limit_page; $page_number++,$page_count++) {
            if($this->result_fatal_error) break;
            $this->import($overwrite, $event_keyword, $category, $activated, $page_number, $location, $date_start, $date_end, $developer_mode);
        }
        return $this->result;
    }
    
    function get_api($url = '', $file_name='') {
        
        if(false && !empty($file_name) && file_exists(FCPATH.'/files/'.$file_name)){
            $response = file_get_contents(FCPATH.'/files/'.$file_name);
        } else {   
            $ch = curl_init();
            //curl_setopt($ch, CURLOPT_URL, "https://www.eventbriteapi.com/v3/events/search/?q=teste&location.address=Colorado&categories=107&token=ACXIMMLLHLNA4EKC6RNB");
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            
            curl_setopt($handle, CURLOPT_FAILONERROR, true);  // this works
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($handle, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 3);

            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.15) Gecko/20080623 Firefox/2.0.0.15",
              "Authorization: Bearer ".$this->api_token." ",
            ));

            $response = curl_exec($ch);
            curl_close($ch);
            file_put_contents(FCPATH.'/files/'.$file_name, $response);
        }
        
        return json_decode($response);
        
    }
    
     /*
     * Start Import
     * 
     * @param (int) $page_size, count of max events for import, max avaible 250
     * 
     * @param boolen $developer_mode ignore $overwrite param
     * 
     */
    public function import($overwrite = FALSE, $event_keyword='', $category='', $activated = TRUE, $page_number=1, $location='', $date_start='', $date_end='', $developer_mode = FALSE) {

        $this->category = $category;
        if(!empty($date_start) && (bool) strtotime($date_start)) {
            $date_start = date('Y-m-d\TH:i:s',strtotime($date_start)).'Z';
        }
        if(!empty($date_end) && (bool) strtotime($date_end)) {
            $date_end = date('Y-m-d\TH:i:s',strtotime($date_end)).'Z';
        }
        
        $url = "https://www.eventbriteapi.com/v3/events/search/?price=free&expand=organizer,venue&q=".urlencode($event_keyword)."&categories=".urlencode($category)."&start_date.range_end=".urlencode($date_end)."&start_date.range_start=".urlencode($date_start)."&location.address=".urlencode($location)."&page=".$page_number;
        $file_name = urlencode(date('Y_m_H').'_'. $event_keyword.'_'. $category.'_'. $date_start.'_'. $date_end.'_'. $location.'_'.'.json');
        $eventbrite_array = $this->get_api($url, $file_name);
        // show link in console for devoloper_mode
        if($developer_mode)
            echo '<script type="text/javascript">console.log("'.$url.'");</script>';
       
        if(empty($eventbrite_array->events)) {
            if($developer_mode)
                echo '<script type="text/javascript">console.log("'. lang_check('XML is empty link: '.$url).'");</script>';
             
            $this->result_fatal_error = true;
            return false;
        }
        
        $events_array = $eventbrite_array->events;
        
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
        
        foreach ($events_array as $key => $event) {
            if(!empty($this->eventful_offset_events) && $this->eventful_offset_events > $this->count_events) {
                $this->count_events++;
                continue;
            }
            $this->count_events++;
            
            if((count($info) - $_count_skip) >= ($this->eventful_limit_events*50)) {
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
            if(empty($event))
                continue;
            
            // if this estate exists
            
            if(!$developer_mode){
                if(!$overwrite){
                $id_transitions= $event->venue_id;
                $id_transitions=trim($id_transitions);
                $query = $this->CI->db->get_where('property', array('id_trans_text' =>$id_transitions));
                    if($query && $query->row()) {
                        $result= $query->result()[0];
                        $_count_skip++;
                        $_count_exists++;
                        $info[]=array(
                            'address'=> '<p class="label label-info validation">'.lang_check('Event exists').'</p>',
                            'id'=> $event->venue_id,
                            'preview_id'=> $result->id
                        );
                        continue;
                    }
                }
                
                // if overwright
                if($overwrite){
                    $id_transitions= $event->venue_id;
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
            $address= _ch($event->venue->address->localized_address_display,'');
            
            $data["address"]=$address;                 
            
            $latitude = _ch($event->venue->address->latitude,'');
            $longitude =  _ch($event->venue->address->longitude,'');
            if(!empty($latitude) and !empty($longitude)) {
                $data["gps"]=$latitude.", ".$longitude;
            } else {
                // gps 
                $gps = $this->CI->ghelper->getCoordinates($data["address"]);
                $data["gps"]=$gps['lat'].", ".$gps['lng'];
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
            
            $id_transitions= $event->venue_id;
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
            $options_data = $this->get_option($event);
            
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
            if(isset($event->logo) && isset($event->logo->original)){
                $next_order=0;
                $image_link = $event->logo->original->url;
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
                'id'=> $event->venue_id,
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
    protected function get_option($event){
        $current_date = date('Y-m-d H:i:s');
        $options_data = $this->get_dynamicFields($event);
        $options_prepared = array();
            foreach($this->option_list as $key=>$option) {
                $option_name= strtolower(trim($option['option']));
                
                $index_option='option'.$option["id"].'_'.$option["language_id"];
                
                /* check if value missing in dropdown */
                if($this->default_lang_id == $option["language_id"])
                    if($option['type'] == 'DROPDOWN' && isset($options_data['option'.$option["id"]])) {
                        $val= trim($options_data['option'.$option["id"]]);
                        
                        if(!empty($val) && stripos($option['values'], $val)!==FALSE) {
                            $pos = stripos($option['values'], $val);
                            $options_prepared[$index_option] = substr($option['values'], $pos, strlen($val));
                       } else if(!empty($val) && strrpos($option['values'], $val)===FALSE) {
                            /* add new value in field */ 
                            $field_data = $this->CI->option_m->get_lang_array($option["id"]);
                            $f_data_lang = array();
                            $f_data_lang['values'] =$field_data->{'values_'.$option["language_id"]} .','.$val;
                            $this->CI->db->set($f_data_lang);
                            $this->CI->db->where('option_id', $option["id"]);
                            $this->CI->db->where('language_id', $option["language_id"]);
                            $this->CI->db->update($this->CI->option_m->get_table_name().'_lang');
                            $$options_prepared[$index_option] = $val;

                            /* update array by new values */
                            $field_data = $this->CI->option_m->get_lang_array($option["id"]);
                            $values =$field_data->{'values_'.$option["language_id"]};
                            $this->option_list[$key]['values'] = $values;
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
    protected function get_dynamicFields($event) {
        $options_data = array();
        
        //shortDescription
        $options_data['option8'] = $event->description->text;
        
        //date
        $options_data['option81'] = date('Y-m-d H:i:s', strtotime($event->start->utc));
        
        $options_data['option82'] = date('Y-m-d H:i:s', strtotime($event->end->utc));
        
        if(empty( $options_data['option82']) && !empty($options_data['option81'])) {
            $options_data['option82'] = date('Y-m-d H:i:s',strtotime($options_data['option81'].' +1 week'));
        }
        
        //description
        $options_data['option17'] = $event->description->text;

        //title
        $options_data['option10'] = $event->name->text;

        //url
        $options_data['option69'] = $event->url;

        //postal_code
        //$options_data['option40'] = $this->get_XmlValue($xml_property,'postal_code');

        //country  save in County
        $options_data['option5'] = _ch($event->venue->address->region,'');

        //city
        $options_data['option7'] = _ch($event->venue->address->city,'');

        //category
        $options_data['option79'] = $this->get_category_value_path($event->category_id, $event->subcategory_id);
            
        return $options_data;
    }
    
    function get_category_value_path ($category_id, $subcategory_id) {
         $value_path = '';
         if(isset($this->event_categories[$category_id]))
            $value_path = $this->event_categories[$category_id].' -';
                 
         return $value_path;
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
    protected function do_upload($file_link)
        {
            if(empty($file_link)) return false;
            
            //$file_name=substr(strrchr($file_link, '/'), 1);
            $file_name= time();
            //$file_link=  str_replace($file_name, rawurlencode($file_name), $file_link);

            if(!$this->url_exists($file_link)) return false;
            
            $file=$this->file_get_contents_curl($file_link);
            $data = getimagesizefromstring($file);
            
            if(empty($data['mime'])) return false;
            
            $mime_type = $data['mime']; // [] if you don't have exif you could use getImageSize() 
            $allowedTypes = array( 
                            'image/gif',  // [] gif 
                            'image/pjpeg',  // [] jpg 
                            'image/jpeg',  // [] jpg 
                            'image/png',  // [] png 
                            'image/bmp'   // [] bmp 
            ); 				
						
            if (!in_array($mime_type, $allowedTypes)) { 
                return false; 
            } 

            switch($mime_type) {
                case 'image/gif': $type ='gif'; break;
                case 'image/pjpeg': $type ='jpg'; break;
                case 'image/jpeg': $type ='jpg'; break;
                case 'image/png': $type ='png'; break;
                case 'image/bmp': $type ='bmp'; break;
            }
            
            $new_file_name=time().rand(000, 999).'.'.$type;
            file_put_contents(FCPATH.'/files/'.$new_file_name, $file);
            /* create thumbnail */
            $this->CI->uploadhandler->regenerate_versions($new_file_name);
            /* end create thumbnail */
            return $new_file_name;
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
    
    
    public function get_count_pages( $event_keyword='', $category='',$location='', $date_start='', $date_end=''){
        
        if(!empty($date_start) && (bool) strtotime($date_start)) {
            $date_start = date('Y-m-d\TH:i:s',strtotime($date_start)).'Z';
        }
        if(!empty($date_end) && (bool) strtotime($date_end)) {
            $date_end = date('Y-m-d\TH:i:s',strtotime($date_end)).'Z';
        }
        
        $url = "https://www.eventbriteapi.com/v3/events/search/?price=free&q=".urlencode($event_keyword)."&categories=".urlencode($category)."&start_date.range_end=".urlencode($date_end)."&start_date.range_start=".urlencode($date_start)."&token=ACXIMMLLHLNA4EKC6RNB&expand=organizer,venue&location.address=".urlencode($location);
        $file_name = urlencode(date('Y_m_H').'_'. $event_keyword.'_'. $category.'_'. $date_start.'_'. $date_end.'_'. $location.'_'.'.json');
        $eventbrite_array = $this->get_api($url, $file_name);
        if($eventbrite_array && isset($eventbrite_array->pagination->page_count))
            return $eventbrite_array->pagination->page_count;
        else 
            return false;
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
        
    private function get_var ($var=null, $default='') {
        return (!empty($var)) ? trim($var,'"') : $default ;
    }
    
    function nl2br2($string) { 
        $string = str_replace(array("\r\n", "\r", "\n"), " ", $string); 
        return $string; 
    } 
    
    /*
     * convert_charset
     * @param string $value - string for convert charset
     * return text after convert charset
     */
    private function convert_charset($value) {
        $value = iconv('UTF-8', 'Windows-1250', $value);
        return $value;
    }
    
    
    public function file_get_contents_curl($url) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set cURL to return the data instead of printing it to the browser.
        curl_setopt($ch, CURLOPT_URL, $url);

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }
    
    function url_exists($url) {
        $handle   = curl_init($url);
        if (false === $handle)
        {
                return false;
        }

        curl_setopt($handle, CURLOPT_HEADER, false);
        curl_setopt($handle, CURLOPT_FAILONERROR, true);  // this works
        curl_setopt($handle, CURLOPT_HTTPHEADER, Array("User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.15) Gecko/20080623 Firefox/2.0.0.15") ); // request as if Firefox
        curl_setopt($handle, CURLOPT_NOBODY, true);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, false);
        curl_setopt($handle, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 3);
        $connectable = curl_exec($handle);
        ##print $connectable;
        curl_close($handle);
        if($connectable){
            return true;
        }
        return false;
    }
    
}