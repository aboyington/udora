<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/*
 * 
 *  Address from gps for export was commented. If need address, plese uncomment "Address from gps" Line 659/*
 * 
 */


class Xml2u {
    
    /* list all option, witch use on site */
    protected $option_list;
    
    /* array id of langs, witchuse on sile */
    protected $langs_id;
    
    /* default lang code */
    protected $default_lang_code;
    
    /* options script*/
    private $options = array(
            'inline_file_types' => '/\.(gif|jpe?g|png)$/i',
            'max_properties_import' => '20',
    );
    
    private $dom;


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
        $this->option_list=$this->get_option_list();
        
        $this->langs_id=$this->CI->option_m->languages;
        
        $this->default_lang_code=$this->CI->language_m->get_default();
    }
    
    
    /*
     * Start Import
     * 
     * @param string $file path and file name with csv
     * @param (string, int) $max_images, count of max images per property for import
     * 
     * @param boolen $developer_mode ignore $overwrite param
     * 
     * return array with id of new estate => address
     */
    public function import($filename=null, $overwrite = FALSE, $activated = TRUE, $google_gps = TRUE, $max_images=1, $developer_mode = FALSE) {
        $time_start = microtime(true);
        $max_exec_time = 120;
        if(config_item('max_exec_time'))
            $max_exec_time = config_item ('max_exec_time');

        //ini_set('max_execution_time', $max_exec_time);

        if(empty($filename)) {
            return false;
        }
        
        $this->dom=new DOMDocument();
        $this->dom->load($filename);
        $xml_properties= $this->dom->getElementsByTagName('properties')->item(0);
        
        if(!$xml_properties || !$xml_properties->hasChildNodes()) {
            $this->CI->session->set_flashdata('error', 
                    lang_check('XML is empty'));
            redirect('admin/estate/import_xml2u');
            exit();
        }
        
        $_count=0;
        $_count_skip=0;
        $_count_exists=0;
        $_count_exists_overwrite=0;
        /* start add new estate */
        
        $info=array();
        foreach ($xml_properties->getElementsByTagName('Property') as $key => $xml_property) {
            //sleep(7);
            $is_exists = false;
            
            $time_end = microtime(true);
            $execution_time = $time_end - $time_start;
            if($execution_time>=$max_exec_time){
                // break import
                return array(
                    'info'=> $info,
                    'count_skip' => $_count_skip,
                    'count_exists_overwrite' => $_count_exists_overwrite,
                    'count_exists' => $_count_exists,
                    'message' => lang_check('max_exec_time reached, you can import again')
                );
            }
            
            $id=NULL;
            // skip
            if(!$xml_property)
                continue;
            
            // if this estate exists
            
            if(!$developer_mode){
                if(!$overwrite){
                $id_transitions=trim(str_replace('-','', $this->get_XmlValue($xml_property, 'propertyid', '')));
                $query = $this->CI->db->get_where('property', array('id_transitions' =>$id_transitions));
                    if($query->row()) {
                        $result= $query->result()[0];
                        $_count_skip++;
                        $_count_exists++;
                        $info[]=array(
                            'address'=> '<p class="label label-info validation">'.lang_check('Property exists').'</p>',
                            'id'=> $this->get_XmlValue($xml_property, 'propertyid', ''),
                            'preview_id'=> $result->id
                        );
                        continue;
                    }
                }

                // if overwright
                if($overwrite){
                    $id_transitions=trim(str_replace('-','', $this->get_XmlValue($xml_property, 'propertyid', '')));
                    $query = $this->CI->db->get_where('property', array('id_transitions' =>$id_transitions));
                     if($query->row()) {
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
            
            // address
            $address= '';
            
            $xml_address = $xml_property->getElementsByTagName('Address')->item(0);
            
            if($xml_address){
                if($this->get_XmlValue($xml_address,'street'))
                    $address.= $this->get_XmlValue($xml_address,'street');
                
                if($this->get_XmlValue($xml_address,'number'))
                    $address.= $this->get_XmlValue($xml_address,'number');

                if($this->get_XmlValue($xml_address,'location'))
                    $address.= ', '.$this->get_XmlValue($xml_address,'location');
                if($this->get_XmlValue($xml_address,'region'))
                    $address.= ', '.$this->get_XmlValue($xml_address,'region');

                if($this->get_XmlValue($xml_address,'country'))
                    $address.= ', '.$this->get_XmlValue($xml_address,'country');
            }
            $address = trim($address, ',');
            
            /* address by Google API
            if(empty($address)) {
                $lat= $this->get_XmlValue($xml_address,'latitude');
                $lng= $this->get_XmlValue($xml_address,'longitude');
                if(!empty($lat) && !empty($lng)) {
                    if(@$json = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.$lat.','.$lng)) {
                        $json= json_decode($json);
                        if(isset($json->results[0]) and isset($json->results[0]->formatted_address))
                        $address = $json->results[0]->formatted_address;
                    }
                    sleep(1);
                }
            }*/
            
            $data["address"]=$address;                 
            
            $latitude = $this->get_XmlValue($xml_address,'latitude');
            $longitude =  $this->get_XmlValue($xml_address,'longitude');

            if(!empty($latitude) and !empty($longitude)) {
                $data["gps"]=$latitude.", ".$longitude;
            } else {
                if($google_gps){
                    // gps 
                    $gps = $this->CI->ghelper->getCoordinates($data["address"]);
                    $data["gps"]=$gps['lat'].", ".$gps['lng'];
                }
            }
            
            $data["is_featured"]= 0;
            
            
            $data["is_activated"]=($activated) ? '1' : '0';
            
            
            $data["id_transitions"]= str_replace('-','', $this->get_XmlValue($xml_property, 'propertyid', '')); 
            
            if($is_exists)
                $data["date_modified"]= date('Y-m-d H:i:s');
            
            //$data["date_activated"]= $data["date"];
            $data["type"]=NULL;
            
            $data['activation_paid_date']=NULL;
            $data['featured_paid_date']=NULL;

            /* end main param */ 
            
            // add options for property
            
            // dinamic option 
            $options_data= array();
            $options_data = $this->get_option($xml_property);
            $options_data['agent']=$this->CI->session->userdata('id');
            
            /* skip */
            
            if(isset($options_data['field_error'])) {
                $_count_skip++;
                $info[]=array(
                    'address'=> $options_data['field_error'],
                    'id'=> $this->get_XmlValue($xml_property, 'propertyid', '')
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
                $this->CI->session->set_flashdata('error', 
                        lang_check('Not created json_object in property id = "'.$result->row()->property_id.'" '));
                redirect('admin/estate/import_xml2u');
                exit();
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
            
            $xml_images = $xml_property->getElementsByTagName('images')->item(0);
           
            if(!empty($xml_images->hasChildNodes())) {
                $xml_images = $xml_images->childNodes;
                $next_order=0;
                foreach ($xml_images as $key => $xml_image) {
                    if($next_order >= $max_images) break;
                    $image_link = $this->get_XmlValue($xml_image, 'image');
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
            if(empty($info_address) && isset($options_data['option10_'.$this->CI->language_m->get_default_id()]))
                $info_address = $options_data['option10_'.$this->CI->language_m->get_default_id()];
            $info[]=array(
                'address'=> $info_address,
                'id'=> $this->get_XmlValue($xml_property, 'propertyid', ''),
                'preview_id'=> $insert_id
            );
        }
        
        /* end start add new estate */
        return array(
            'info'=> $info,
            'count_skip' => $_count_skip,
            'count_exists_overwrite' => $_count_exists_overwrite,
            'count_exists' => $_count_exists
        );
    }
    
    
    
    /*
     * Filter and add options with lang id
     * 
     * @param $options array array with options array(optin10=>value);
     * @return array current for all lang options;
     * 
     * for other lang just copy
     */    
    protected function get_option($xml_property){
        
        $options_data = $this->get_dynamicFields($xml_property);
        $options_prepared = array();
        
            foreach($this->option_list as $key=>$option) {
                $option_name=mb_strtolower(trim($option['option']));
                
                /* only one lang 
                if($this->CI->language_m->get_default_id() !== $option["language_id"] ) continue;
                */
                
                $index_option='option'.$option["id"].'_'.$option["language_id"];
                
                /* check if value missing in dropdown */
                
                if($this->CI->language_m->get_default_id() == $option["language_id"])
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
                    if($option['type'] == 'TEXTAREA')
                        $options_prepared[$index_option]=$val;
                    else {
                        $options_prepared[$index_option]= strip_tags($val);
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
     * @param object $xml_property node <Property> from xml 
     * 
     * return fields with index from db
     */
    
    
    protected function get_dynamicFields($xml_property) {
        $options_data = array();
        
            // price
            $xml_price = $xml_property->getElementsByTagName('Price')->item(0);
            $options_data['option36']= $this->get_XmlValue($xml_price,'price');
            
            $xml_description =  $xml_property->getElementsByTagName('Description')->item(0);
            
            //category
            $options_data['option4'] = $this->get_XmlValue($xml_property,'category');
            
            //propertyType
            $options_data['option2'] = $this->get_XmlValue($xml_description,'propertyType');
            
            //bedrooms
            $options_data['option20'] = $this->get_XmlValue($xml_description,'bedrooms');
            
            //fullBathrooms
            $options_data['option19'] = $this->get_XmlValue($xml_description,'fullBathrooms');
            
            //rooms
            $options_data['option58'] = $this->get_XmlValue($xml_description,'rooms');
            
            //title
            $options_data['option10'] = $this->get_XmlValue($xml_description,'title');
            
            //shortDescription
            $options_data['option8'] = $this->get_XmlValue($xml_description,'shortDescription');
            
            //description
            $options_data['option17'] = $this->get_XmlValue($xml_description,'description');
            
            //floorNumber
            $options_data['option53'] = $this->get_XmlValue($xml_description,'floorNumber');
            
            //heating
            $heating = $this->get_XmlValue($xml_description,'heating');
            $options_data['option28'] = ($heating && $heating=='Yes') ? true : false;
            
            //elevator
            $balcony = $this->get_XmlValue($xml_description,'balcony');
            $options_data['option11'] = ($balcony && $balcony=='Yes') ? true : false;
            
            //swimmingPool
            $swimmingPool = $this->get_XmlValue($xml_description,'swimmingPool');
            $options_data['option33'] = ($swimmingPool && $swimmingPool=='Yes') ? true : false;
           
            //offRoadParking
            $offRoadParking = $this->get_XmlValue($xml_description, 'offRoadParking');
            $options_data['option32'] = ($offRoadParking && $offRoadParking=='Yes' || $offRoadParking >0 ) ? true : false;
            
            
            //FloorSize
            if($xml_description) {
                $xml_floorSize = $xml_description->getElementsByTagName('FloorSize')->item(0);
                $options_data['option57'] = $this->get_XmlValue($xml_floorSize,'floorSize');
            }
            
            /* Start Company */
            $xml_ListingContact = $xml_property->getElementsByTagName('ListingContact')->item(0);
            
            //companyName
            $options_data['option67'] = $this->get_XmlValue($xml_ListingContact,'companyName');
            
            //companyWebsite
            $options_data['option69'] = $this->get_XmlValue($xml_ListingContact,'companyWebsite');
            
            //agent1Phone
            $options_data['option68'] = $this->get_XmlValue($xml_ListingContact,'agent1Phone');
            
            //Company_descrioption
            
            $company_description= '';
            if($this->get_XmlValue($xml_ListingContact,'agent1FirstName'))
                $company_description.= 'Agent: '.$this->get_XmlValue($xml_ListingContact,'agent1FirstName').' '.$this->get_XmlValue($xml_ListingContact,'agent1LastName').'<br/>';
           
            if($this->get_XmlValue($xml_ListingContact,'agent1Email'))
                $company_description.= 'Email: '.$this->get_XmlValue($xml_ListingContact,'agent1Email').'<br/>';
            
            $company_description.= 'Address: '.$this->get_XmlValue($xml_ListingContact,'companyBuildingNameNumber').' '
                                            .$this->get_XmlValue($xml_ListingContact,'companyStreet').' '
                                            .$this->get_XmlValue($xml_ListingContact,'companyTownCity').' '
                                            .$this->get_XmlValue($xml_ListingContact,'companyRegion').' '
                                            .$this->get_XmlValue($xml_ListingContact,'companyPostcode').' '
                                            .$this->get_XmlValue($xml_ListingContact,'companyCountry').' '
                                    .'<br/>';
            
            $options_data['option72'] = $company_description;
            /* End Company */
            
        return $options_data;
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
     * Upload image from link
     * 
     * @param string $file_link link with image
     * @return file name or false
     */
    protected function do_upload($file_link)
        {
            if(empty($file_link)) return false;
            
            $file_name=substr(strrchr($file_link, '/'), 1);
            $file_link=  str_replace($file_name, rawurlencode($file_name), $file_link);
            
            if(preg_match($this->options['inline_file_types'], $file_link) && @$file=file_get_contents($file_link)) {
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
            
        return (!empty($node_value)) ? trim($node_value) : $default ;
    }
    
    function export($lang_code = 'en', $limit_properties=NULL, $offset_properties=0) {
        
        $options = $this->optionDetails();
           
        // Fetch settings
        $this->CI->load->model('settings_m');
        $settings = $this->CI->settings_m->get_fields();
        
        $lang_id = $this->CI->language_m->get_id($lang_code);
        $lang_name = $this->CI->language_m->get_name($lang_id);
        $this->CI->lang->load('frontend_template', $lang_name, FALSE, TRUE, FCPATH.'templates/'.$settings['template'].'/');
        
        
        $this->dom = new domDocument("1.0", "utf-8");
        $root = $this->dom->createElement("document");
        $this->dom->appendChild($root);
                
        /*FileDetails*/
        $FileDetails=$this->create_child($root, 'FileDetails');
        
        //orderName
        $content_node= '';
        if(isset($settings['websitetitle']))
            $content_node = $settings['websitetitle'];
        $this->create_childContent($FileDetails, 'orderName', $content_node);
        
        //fileFormat
        $this->create_childContent($FileDetails, 'fileFormat', 'XML2U Default - © 2009-2015 XML2U.com. All rights reserved. This xml structure may not be reproduced, displayed, modified or distributed without the express prior written permission of the copyright holder. For permission, contact copyright@xml2u.com');
        
        //sourceURL
        $this->create_childContent($FileDetails, 'sourceURL', site_url());
        
        /* end FileDetails*/
        
        //Client
        $Client =  $this->create_child($root, 'Client');
        
        /*ClientDetails*/
        $ClientDetails =  $this->create_child($Client, 'ClientDetails');
        
        //clientName
        $content_node= '';
        if(isset($settings['websitetitle']))
            $content_node = $settings['websitetitle'];
        $this->create_childContent($ClientDetails, 'clientName', $content_node);
        
        //clientContact
        $content_node= '';
        if(isset($settings['phone']))
            $content_node = $settings['phone'];
        $this->create_childContent($ClientDetails, 'clientContact', $content_node);
        
        //clientContactEmail
        $content_node= '';
        if(isset($settings['email']))
            $content_node = $settings['email'];
        $this->create_childContent($ClientDetails, 'clientContactEmail', $content_node);
        
        //clientTelephone
        $content_node= '';
        if(isset($settings['phone']))
            $content_node = $settings['phone'];
        $this->create_childContent($ClientDetails, 'clientTelephone', $content_node);
        /* end ClientDetails*/
        
        /* properties */
        $properties = $this->create_child($Client, 'properties');
        
        // Property
        
        
        
        $where['language_id']  = $lang_id;
        $where['is_activated'] = 1;
        $allProperties = $this->CI->estate_m->get_by($where, false, $limit_properties, 'property.id DESC', $offset_properties, array(), NULL, FALSE, TRUE);
        
        //$allProperties= $this->get_allProperies();
        
        if(empty($allProperties)){
            exit('Missing Property for Export');
        } 
        
        foreach ($allProperties as $key => $value) {
            
            if(empty($value->json_object)) continue;
            
            /* special */
            $fields=json_decode($value->json_object);
            /* special */
            
            /* end special */
            
            //$properties root
            $property_root = $this->create_child($properties, 'Property');
            
            //propertyid
            $content_node= '';
            if(isset($value->id))
                $content_node = $value->id;
            $this->create_childContent($property_root, 'propertyid', $content_node);
            
            //lastUpdateDate
            $content_node= '';
            if(isset($value->date_modified))
                $content_node = $value->date_modified;
            $this->create_childContent($property_root, 'lastUpdateDate', $content_node);
            
            //category
            $content_node= '';
            if(isset($fields->field_4))
                $content_node = $fields->field_4;
            $this->create_childContent($property_root, 'category', $content_node);
            
            
                /* Address */
                $Address = $this->create_child($property_root, 'Address');
                
                /* Address from gps, uncomment if need parse address
                $maps_api_key = config_db_item('maps_api_key');
                $maps_api_key_prepare='';
                if(!empty($maps_api_key)){
                    $maps_api_key_prepare=$maps_api_key;
                }
                
                $lat = '';
                $lng = '';
                list($lat,$lng)=explode(',', $value->gps);
                
                if(!empty($lat) && !empty($lng)) {
                    if(@$json = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($lat).','.trim($lng).'&key='.$maps_api_key_prepare)) {
                        $json= json_decode($json);
                        if(isset($json->results[0]) and isset($json->results[0]->address_components)){
                            $address = $json->results[0]->address_components;

                            if(isset($address[0]->long_name))
                            $number = $address[0]->long_name;

                            if(isset($address[1]->long_name))
                            $street = $address[1]->long_name;

                            if(isset($address[5]->long_name))
                            $postcode = $address[5]->long_name;

                            if(isset($address[3]->long_name))
                            $location = $address[3]->long_name;

                            if(isset($address[2]->long_name))
                            $region = $address[2]->long_name;

                            if(isset($address[4]->long_name))
                            $country =$address[4]->long_name;
                        }
                    }
                   // sleep(1); // for google
                }*/
                
                //number
                $content_node= '';
                if(isset($number)){
                    $content_node= $number;
                }
                $this->create_childContent($Address, 'number', $content_node);

                //street
                $content_node= '';
                if(isset($street)){
                    $content_node= $street;
                }
                $this->create_childContent($Address, 'street', $content_node);

                //postcode
                $content_node= '';
                if(isset($postcode)){
                    $content_node= $postcode;
                }
                $this->create_childContent($Address, 'postcode', $content_node);

                //location
                $content_node= '';
                if(isset($location)){
                    $content_node= $location;
                }
                $this->create_childContent($Address, 'location', $content_node);

                //subRegion
                $content_node= '';
                if(isset($subRegion)){
                    $content_node= $subRegion;
                }
                $this->create_childContent($Address, 'subRegion', $content_node);

                //region
                $content_node= '';
                if(isset($region)){
                    $content_node= $region;
                }
                $this->create_childContent($Address, 'region', $content_node);

                //country
                $content_node= '';
                if(isset($country)){
                    $content_node= $country;
                }
                $this->create_childContent($Address, 'country', $content_node);

                //countryCodeISO3166-1-alpha2
                $content_node= '';
                $this->create_childContent($Address, 'countryCodeISO3166-1-alpha2', $content_node);

                //countryCodeISO3166-1-numeric
                $content_node= '';
                $this->create_childContent($Address, 'countryCodeISO3166-1-numeric', $content_node);

                //countryCodeISO3166-1-alpha3
                $content_node= '';
                $this->create_childContent($Address, 'countryCodeISO3166-1-alpha3', $content_node);

                //latitude
                $content_node= '';
                if(isset($value->lat))
                    $content_node = $value->lat;
                $this->create_childContent($Address, 'latitude', $content_node);
                
                //
                $content_node= '';
                if(isset($value->lng))
                    $content_node = $value->lng;
                $this->create_childContent($Address, 'longitude', $content_node);
                
            /* End Address */
            
            /* Price */
                $Price = $this->create_child($property_root, 'Price');
                
                //prefix
                $content_node= '';
                if(isset($options['options_prefix_36']))
                    $content_node = $options['options_prefix_36'];
                
                if(empty($content_node)) {
                    $content_node = $options['options_suffix_36'];
                }
                
                $this->create_childContent($Price, 'prefix', $content_node);
                
                //price
                
                $_price = '';
                if(!empty($fields->field_36)) 
                    $_price=$fields->field_36;
                if(!empty($fields->field_37)) 
                    $_price=$fields->field_37;
                
                $this->create_childContent($Price, 'price', $_price);
                
                //pricerange
                $content_node= '';
                $this->create_childContent($Price, 'pricerange', $content_node);
                
                //currency
                $content_node= '';
                $this->create_childContent($Price, 'currency', $content_node);
                
                //frequency
                $content_node= '';
                $this->create_childContent($Price, 'frequency', $content_node);
                
                //RentalBond
                $content_node= '';
                $this->create_childContent($Price, 'RentalBond', $content_node);
                
                //RentalAdminFee
                $content_node= '';
                $this->create_childContent($Price, 'RentalAdminFee', $content_node);
                
                //availableDate
                $content_node= '';
                $this->create_childContent($Price, 'availableDate', $content_node);
                
                //status
                $content_node= '';
                $this->create_childContent($Price, 'status', $content_node);
                
                //reference
                $content_node= '';
                $this->create_childContent($Price, 'reference', $content_node);
                
                //MlsId
                $content_node= '';
                $this->create_childContent($Price, 'MlsId', $content_node);
                
            /* End Price */
            
            /* Description */
                $Description = $this->create_child($property_root, 'Description');
                
                //propertyType
                $content_node= '';
                if(isset($fields->field_2))
                    $content_node = $fields->field_2;
                $this->create_childContent($Description, 'propertyType', $content_node);
                
                //Tenure
                $content_node= '';
                $this->create_childContent($Description, 'Tenure', $content_node);
                
                //tenanted
                $content_node= '';
                $this->create_childContent($Description, 'tenanted', $content_node);
                
                //bedrooms
                $content_node= '';
                if(isset($fields->field_20))
                    $content_node = $fields->field_20;
                $this->create_childContent($Description, 'bedrooms', $content_node);
                
                //bedroomRange
                $content_node= '';
                $this->create_childContent($Description, 'bedroomRange', $content_node);
                
                //sleeps
                $content_node= '';
                $this->create_childContent($Description, 'sleeps', $content_node);
                
                //fullBathrooms
                $content_node= '';
                if(isset($fields->field_19))
                    $content_node = $fields->field_19;
                $this->create_childContent($Description, 'fullBathrooms', $content_node);
                
                //halfBathrooms
                $content_node= '';
                $this->create_childContent($Description, 'halfBathrooms', $content_node);
                
                //rooms
                $content_node= '';
                if(isset($fields->field_58))
                    $content_node = $fields->field_58;
                $this->create_childContent($Description, 'rooms', $content_node);
                
                //receptionRooms
                $content_node= '';
                $this->create_childContent($Description, 'receptionRooms', $content_node);
                
                //furnishings
                $content_node= '';
                $this->create_childContent($Description, 'furnishings', $content_node);
                
                
                //title
                $content_node= '';
                if(isset($fields->field_10))
                    $content_node = $fields->field_10;
                $this->create_childContent($Description, 'title', $content_node);
                
                //shortDescription
                $content_node= '';
                if(isset($fields->field_8))
                    $content_node = $fields->field_8;
                
                $shortDescription = $this->create_childContent($Description, 'shortDescription');
                $shortDescription->appendChild($this->dom->createCDATASection($content_node)) ;
                
                //description
                $content_node= '';
                if(isset($fields->field_17))
                    $content_node = $fields->field_17;
                
                $fullDescription = $this->create_childContent($Description, 'description');
                $fullDescription->appendChild($this->dom->createCDATASection($content_node)) ;
                
                //newBuild
                $content_node= '';
                $this->create_childContent($Description, 'newBuild', $content_node);
                
                //yearBuilt
                $content_node= '';
                $this->create_childContent($Description, 'yearBuilt', $content_node);
                
                //numberOfFloors
                $content_node= '';
                $this->create_childContent($Description, 'numberOfFloors', $content_node);
                
                //floorNumber
                $content_node= '';
                if(isset($fields->field_53))
                    $content_node = $fields->field_53;
                $this->create_childContent($Description, 'floorNumber', $content_node);
                
                //condition
                $content_node= '';
                if(isset($fields->field_53))
                    $content_node = (!empty($fields->field_53)) ? 'Yes' : '';
                $this->create_childContent($Description, 'condition', $content_node);
                
                //heating 
                $content_node= '';
                if(isset($fields->field_53))
                    $content_node = (!empty($fields->field_53)) ? '1' : '';
                $this->create_childContent($Description, 'heating', $content_node);
                
                //elevator 
                $content_node= '';
                if(isset($fields->field_30))
                    $content_node = (!empty($fields->field_30)) ? 'Yes' : '';
                $this->create_childContent($Description, 'elevator', $content_node);
                
                //fittedKitchen
                $content_node= '';
                $this->create_childContent($Description, 'fittedKitchen', $content_node);
                
                //assistedLiving
                $content_node= '';
                $this->create_childContent($Description, 'assistedLiving', $content_node);
                
                //wheelchairFriendly
                $content_node= '';
                $this->create_childContent($Description, 'wheelchairFriendly', $content_node);
                
                //balcony 
                $content_node= '';
                if(isset($fields->field_11))
                    $content_node = (!empty($fields->field_11)) ? 'Yes' : '';
                $this->create_childContent($Description, 'balcony', $content_node);
                
                //terrace
                $content_node= '';
                $this->create_childContent($Description, 'terrace', $content_node);
                
                //swimmingPool 
                $content_node= '';
                if(isset($fields->field_33))
                    $content_node = (!empty($fields->field_33)) ? 'Yes' : '';
                $this->create_childContent($Description, 'swimmingPool', $content_node);
                
                //orientation
                $content_node= '';
                $this->create_childContent($Description, 'orientation', $content_node);
                
                //garages 
                $content_node= '';
                $this->create_childContent($Description, 'garages', $content_node);
                
                //offRoadParking 
                $content_node= '';
                if(isset($fields->field_32))
                    $content_node = (!empty($fields->field_32)) ? 'Yes' : '';
                $this->create_childContent($Description, 'offRoadParking', $content_node);
                
                //carports
                $content_node= '';
                $this->create_childContent($Description, 'carports', $content_node);
                
                //openhouses
                $content_node= '';
                $this->create_childContent($Description, 'openhouses', $content_node);
                
                //auctionTime
                $content_node= '';
                $this->create_childContent($Description, 'auctionTime', $content_node);
                
                //auctionPlace
                $content_node= '';
                $this->create_childContent($Description, 'auctionPlace', $content_node);
                
                //FloorSize
                $content_node= '';
                $_floorSize=$this->create_child($Description, 'FloorSize');
                
                
                    //floorSize
                    $content_node= '';
                    if(isset($fields->field_57))
                        $content_node = $fields->field_57;
                    $this->create_childContent($_floorSize, 'floorSize', $content_node);
                    
                    $content_node= '';
                    $this->create_childContent($_floorSize, 'floorSizeUnits', $content_node);
                    
                //plotSize
                $content_node= '';
                $PlotSize=$this->create_child($Description, 'PlotSize');
                
                    //floorSize
                    $content_node= '';
                    $this->create_childContent($PlotSize, 'plotSize', $content_node);

                    $content_node= '';
                    $this->create_childContent($PlotSize, 'plotSizeUnits', $content_node);
                    
                /* Features  */
                    
                $content_node= '';
                $Features=$this->create_child($Description, 'Features'); 

                    $content_node= '';
                    $this->create_childContent($Features, 'Feature1', $content_node);
                    
                /* end Features  */
                
                    
                /* IMAGES */
                    //images
                    $content_node= '';
                    $images_root=$this->create_child($property_root, 'images'); 

                    $images = json_decode($value->image_repository);
                    if(!empty($images)){
                        foreach ($images as $key => $img) {

                            // image
                            $image_node = $this->dom->createElement('image');
                            $image_node->setAttribute("number", $key);
                            $images_root->appendChild($image_node); 

                            // image link
                            $image_link = $this->dom->createElement('image',  base_url('files/'.$img));
                            $image_node->appendChild($image_link);
                        }
                    }
                /*  End IMAGES */
                
                /* link */
                
                //link
                    $link = $this->create_child($property_root, 'link');

                    //dataSource
                    $href= slug_url('property/'.$value->id.'/'.$lang_code.'/'.url_title_cro($fields->field_10, '-', TRUE), 'page_m');
                    $this->create_childContent($link, 'dataSource', $href);
                    
                    //map
                    $this->create_childContent($link, 'map', '');
                    
                    //localInfo
                    $this->create_childContent($link, 'localInfo');
                    
                    //video
                    $content_node= '';
                    if(isset($fields->field_42))
                        $content_node = $fields->field_42;
                    $this->create_childContent($link, 'video', $content_node);
                    
                    //map
                    $content_node= '';
                    $this->create_childContent($link, 'virtualTour', $content_node);
                    
                    //map
                    $pdf_link= '';
                    if(file_exists(APPPATH.'libraries/Pdf.php')) {
                        $pdf_link = slug_url('api/pdf_export/'.$value->id.'/'.$lang_code);
                    }
                    $this->create_childContent($link, 'pdf', $pdf_link);
                    
                /* End link */
                    
                /* spareFields skipp */    
                /* end spareFields skipp */    
                    
                /* ListingContact */
                 
                $ListingContact_root = $this->create_child($property_root, 'ListingContact');
                    
                    //companyName
                    $content_node= '';
                    if(isset($fields->field_67))
                        $content_node = $fields->field_67;
                    $this->create_childContent($ListingContact_root, 'companyName', $content_node);
                    
                    //companyWebsite
                    $content_node= '';
                    $this->create_childContent($ListingContact_root, 'companyOffice', $content_node);
                    
                    //companyBuildingNameNumber
                    $content_node= '';
                    $this->create_childContent($ListingContact_root, 'companyBuildingNameNumber', $content_node);
                    
                    //companyName
                    $content_node= '';
                    $this->create_childContent($ListingContact_root, 'companyStreet', $content_node);
                    
                    //companyName
                    $content_node= '';
                    $this->create_childContent($ListingContact_root, 'companyTownCity', $content_node);
                    
                    //companyName
                    $content_node= '';
                    $this->create_childContent($ListingContact_root, 'companyRegion', $content_node);
                    
                    //companyPostcode
                    $content_node= '';
                    $this->create_childContent($ListingContact_root, 'companyPostcode', $content_node);
                    
                    //companyCountry
                    $content_node= '';
                    $this->create_childContent($ListingContact_root, 'companyCountry', $content_node);
                    
                    //companyWebsite
                    $content_node= '';
                    if(isset($fields->field_69))
                        $content_node = $fields->field_69;
                    $this->create_childContent($ListingContact_root, 'companyWebsite', $content_node);
                    
                    //companyLogo
                    $content_node= '';
                    if(isset($fields->field_74))
                        $content_node = $fields->field_74;
                    $this->create_childContent($ListingContact_root, 'companyLogo', $content_node);
                    
                    //agent1FirstName
                    $content_node= '';
                    $this->create_childContent($ListingContact_root, 'agent1FirstName', $content_node);
                    
                    //agent1LastName
                    $content_node= '';
                    $this->create_childContent($ListingContact_root, 'agent1LastName', $content_node);
                    
                    //agent1Phone
                    $content_node= '';
                    if(isset($fields->field_68))
                        $content_node = $fields->field_68;
                    $this->create_childContent($ListingContact_root, 'agent1Phone', $content_node);
                    
                    //agent1Email
                    $content_node= '';
                    $this->create_childContent($ListingContact_root, 'agent1Email', $content_node);
               
                /* End ListingContact */
                
            /* EndDescription */
                    
           // break;
        }
        /* end properties */
        
        /* get the xml printed */
        
        return $this->dom->saveXML();
        
    }
    
    /*
     * get All properties + property_lang + language.code
     * return array
     */
    protected function get_allProperies ($lang_id =NULL) {
        if($lang_id ===NULL)
            $lang_id = $this->CI->language_m->get_default_id();
            
        $property=$this->CI->db->select('property.*, property_lang.*, language.code',FALSE);
        //$property=$this->CI->db->select('property.*, property_lang.*',FALSE);
        $this->CI->db->join('property_lang', 'property.id=property_lang.property_id');
        $this->CI->db->join('language', 'language.id=property_lang.language_id','left');
        $property=$this->CI->db->where('property_lang.language_id =', $lang_id);
        $this->CI->db->order_by('id', 'asc');
        $property=$property->get('property');
        
        return $property->result();
    }
    
    
    /*
     * createElement dom element
     * @param (object) $parent parent dom node
     * @param (string) $new_tag name tag
     * @param (string) $content content text
     * 
     * return( object) new dom Element
     * 
     */
    protected function create_childContent($parent, $new_tag, $content=NULL) {
        if($content===NULL) $content ='';
        $new_node = $this->dom->createElement($new_tag, htmlspecialchars($content));
        $parent->appendChild($new_node);
        return $new_node;
    }
    
    /*
     * createElement dom element without content
     * @param (object) $parent parent dom node
     * @param (string) $new_tag name tag
     * 
     * return( object) new dom Element
     */
    protected function create_child($parent, $new_tag) {
        
        $new_node = $this->dom->createElement($new_tag);
        $parent->appendChild($new_node);
        return $new_node;
    }
    
    
    function optionDetails () {
        $options_names = $this->CI->option_m->get_lang(NULL, FALSE, $this->CI->language_m->get_default_id() );
        
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
}