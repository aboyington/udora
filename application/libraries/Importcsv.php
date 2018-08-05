<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 


class Importcsv {
    
        protected $filename; 
	protected $delim=','; 		
	protected $enclosed='"';	 
	protected $escaped='\\';	 	
	protected $lineend='\\r\\n';  	
    
    /* list all option, witch use on site */
    protected $option_list;
    
    /* array id of langs, witchuse on sile */
    protected $langs_id;
    
    /* options script*/
    private $options = array(
            'inline_file_types' => '/\.(gif|jpe?g|png)$/i',
            'max_properties_import' => '20',
    );
    
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
        
    }
    
    public function get_csv() {
        $file=$this->startExport();
        
        if(!empty($file)){
           // $file="\xEF\xBB\xBF".$file;
            return $file;
        } else {
            return false;
        }
        //return $this->startExport();
    }
    
    
    
    /*
     *  get_csv(); 
     */
    public function startExport() {
              
        $csv='';
        /* special field */
        $csv_header['InternalID']='InternalID';
        $csv_header['ExternalID']='ExternalID';
        $csv_header['is_featured']='is_featured';
        $csv_header['is_activated']='is_activated';
        $csv_header['gps']='GPS';
        
        
        $csv_header['address']='Address';
        $csv_header['IMAGES']='IMAGES';
        /* end special field */
        
        
        $csv_header+=$this->get_optionsNames();
        
        $csv_t=array();
       // $csv_t[]=implode(';', $csv_header);
        $csv_t=array();
        foreach ($this->get_allProperies() as $key => $value) {
            if(empty($value->json_object)) continue;
            //  print_r($value->is_featured)  ;
            /* special */
            
            $fields=json_decode($value->json_object);
            
            /* special */
            $csv_t[$value->property_id]['is_featured'] =  '"'.$value->is_featured.'"';
            $csv_t[$value->property_id]['is_activated'] =  '"'.$value->is_activated.'"';
            $csv_t[$value->property_id]['gps'] =  '"'.$value->gps.'"';
            $csv_t[$value->property_id]['ExternalID'] =  '"'.$value->id.'"';
            $csv_t[$value->property_id]['IMAGES'] = '';
            $img=$value->image_repository;
            $img=  str_replace('[', '', $img);
            $img=  str_replace(']', '', $img);
            $img=  str_replace('"', '', $img);
            $imgs=array();
            if(!empty($img)){
                foreach (explode(',', $img) as $key => $im) {
                    $im= str_replace('"', '', $im);
                    $imgs[]= base_url('files/'.$im);
                }
            }
            $csv_t[$value->id]['IMAGES'] = '"'.implode(',', $imgs).'"';
            
            $csv_t[$value->property_id]['address'] = '"'.$value->address.'"';
            
            /* end special */
            foreach ($this->get_optionsNames() as $colm_name => $field) {
                $colm_name = substr($colm_name, 0,  strripos($colm_name, '_'));
               // print_r($colm_name);
                if(!empty($fields->$colm_name)) {
                    $csv_t[$value->property_id][$colm_name.'_'.$value->language_id]= '"'. str_replace(';', ' ', $this->nl2br2(''.$fields->$colm_name.'')).'"';
                
                    if(ctype_digit($fields->$colm_name)) {
                        $csv_t[$value->property_id][$colm_name.'_'.$value->language_id]='"'.$fields->$colm_name.'"'; 
                    }
                } 
                else {
                     $csv_t[$value->property_id][$colm_name.'_'.$value->language_id]='""'; 
                }
            }
            
           
        }
        
        // create csv file, and skip not use feilds from bd
        $fieldId=1;
        foreach ($csv_t as $row) {
            $row['InternalID']='"'.$fieldId.'"';
            $row_t=$csv_header;
            foreach ($csv_header as $key => $value) {
               if(isset($row[$key]))
                $row_t[$key]=$row[$key];
            }
            $csv[]= implode(';',  $row_t);
            $fieldId++;
        }
        
        array_unshift($csv, implode(';', $csv_header));
        $csv=implode(PHP_EOL, $csv);
        return $csv;
        // file_put_contents('text.csv',$csv);
        
        /* save */
    }
    
    /*
     * get options Names
     * 
     * @param int $lang lang id
     * return array  ['field_'.$value->option_id]=$value->option
     */
    protected function get_optionsNames ($lang=1) {
        
        $options=$this->CI->db->select('option.*, option_lang.*, language.code');
        $options=$this->CI->db->join('option_lang', 'option.id=option_lang.option_id');
        $options=$this->CI->db->join('language', 'language.id=option_lang.language_id');
        $options=$this->CI->db->where('option.type !=', 'CATEGORY');
        $options=$this->CI->db->where('option.type !=', 'UPLOAD');
        $options=$this->CI->db->where('option.type !=', 'TABLE');
        $options=$this->CI->db->where('option.type !=', 'HTMLTABLE');
        $options=$this->CI->db->where('option.type !=', 'PEDIGREE');
        $options=$this->CI->db->order_by('option_lang.option_id', 'asc');
        
        $options=$this->CI->db->get('option');
        
        $fieldNames=array();
        foreach ($options->result() as $key => $value) {
            $fieldNames['field_'.$value->option_id.'_'.$value->language_id]='['.$value->option_id.']['.$value->code.']'.$value->option.'';
        }
        if(!empty($fieldNames)){
            return $fieldNames;
        } else {
            return false;
        }
    }
    
    /*
     * get All properties + property_lang + language.code
     * return array
     */
    protected function get_allProperies () {
        $property=$this->CI->db->select('property.*, property_lang.*, language.code',FALSE);
        //$property=$this->CI->db->select('property.*, property_lang.*',FALSE);
        $this->CI->db->join('property_lang', 'property.id=property_lang.property_id');
        $this->CI->db->join('language', 'language.id=property_lang.language_id','left');
        //$property=$this->CI->db->where('property_lang.language_id =', '1');
        $this->CI->db->order_by('id', 'asc');
        $property=$property->get('property');
        
        return $property->result();
    }
    
    
    
    /*
     * Function for public for start import csv
     * 
     * @param string $file path and file name with csv
     * return array with id of new estate => address
     */
    public function start_import($file, $overwrite = FALSE, $max_images = 1, $google_gps = FALSE) {
        
        return $this->import($file, $overwrite, $max_images,  $google_gps);
        
    }
    
    
    /*
     * Start Import
     * 
     * @param string $file path and file name with csv
     * return array with id of new estate => address
     */
    protected function import($file=null, $overwrite = FALSE, $max_images = 1, $google_gps = FALSE) {
        $time_start = microtime(true);
        $max_exec_time = 120;
        if(config_item('max_exec_time'))
            $max_exec_time = config_item ('max_exec_time');
        
        $this->CI->load->model('estate_m');
        $this->CI->load->model('option_m');
        $this->CI->load->model('file_m');
        $this->CI->load->model('language_m');
        $this->CI->load->model('repository_m');
        $this->CI->load->library('uploadHandler', array('initialize'=>FALSE));
        $this->CI->load->library('ghelper');
        
        if(empty($file)) {
            return false;
        }
        
        /* names options on all langs */
        $options_type = array();
        foreach($this->CI->option_m->get() as $key=>$val)
        {
            $options_type[$val->id][$val->type] = 'true';
        }
        
        $options_name= array();
        foreach ($this->langs_id as $id=>$v){
            foreach ($this->CI->option_m->get_field_list($id) as $key => $value) {
                $options_name[$key][$id]=$value->option;
            }
        }
        /* end names options on all langs */
        
        $csv = file($file);
        
        /* header csv */
        $header=array();
        $_header=str_getcsv(array_shift($csv),';');;
        foreach ($_header  as $key => $value) {
          $header[]=mb_strtolower(trim($value));
        }
        /* deprecated
         * $csv_h= explode(';', array_shift($csv));
        foreach ($csv_h  as $key => $line) {
          $header[]=$line;
        }  */
        /* end header csv */
        
        $csv_t=array();
        foreach ($csv as $key => $line) {
            /* deprecated
             * $line_p= explode(';', $line);
            foreach ($line_p as $k => $value) {
                $csv_t[$key][mb_strtolower(trim($header[$k]))]=$value;
            }*/
            $csv_line_array =  str_getcsv($line,';');
            if(count($csv_line_array)< 5) {
                    $this->CI->session->set_flashdata('error', 
                            lang_check('Supported only semicolon format'));
                    redirect('admin/estate/import_csv');
                    exit();
            }
            
            if(count($csv_line_array)!= count($header)) {
                   continue;
            }
            
            $csv_t[$key] = array_combine($header, $csv_line_array);
            
          //  break; 
        }
        
        $_count=0;
        $_count_skip=0;
        
        /* start add new estate */
        $info=array();
        foreach ($csv_t as $key => $value) {
            $id=NULL;
            $is_exists = false;
            
            $time_end = microtime(true);
            $execution_time = $time_end - $time_start;
            
            if($execution_time>=$max_exec_time){
                // break import
                return array(
                    'info'=> $info,
                    'count_skip' => $_count_skip,
                    'message' => lang_check('max_exec_time reached, you can import again')
                    );
            }
            
            // skip
            if(empty($value['address']))
                continue;
            
            // if this estate exists
            if(!$overwrite){
            $id_transitions=trim($value['externalid']);
            $query = $this->CI->db->get_where('property', array('id_transitions' =>$id_transitions));
                if($query->row()) {
                    $_count_skip++;
                    continue;
                }
            }
            
            // if overwright
            if($overwrite){
                $id_transitions=trim($value['externalid']);
                $query = $this->CI->db->get_where('property', array('id_transitions' =>$id_transitions));
                 if($query->row()){
                    $id=$query->row()->id;
                    $is_exists = true;
                 }
            }
            
            /* main param */
            $data=array();
            if(!$is_exists)
                $data["date"]= date('Y-m-d H:i:s');
            $data["address"]=$this->get_var($value['address']);

            // gps 
            $data["gps"] =$this->get_var($value['gps']);
            
            if(empty($value["gps"])) {
                if($google_gps){
                    $gps = $this->CI->ghelper->getCoordinates( $data["address"]);
                    $data["gps"]=$gps['lat'].", ".$gps['lng'];
                }
            } else {
                $gps='';
                list($gps['lat'],$gps['lng'])=explode(',', $data["gps"]);
                $data["gps"]=trim($gps['lat']).", ".trim($gps['lng']);
            }

            $data["is_featured"]= $this->get_var($value['is_featured'], '0');
            $data["is_activated"]=$this->get_var($value['is_activated'], '0');
            /* test */
            $data["id_transitions"]=$this->get_var($value['externalid']); 
            /* end test */
            //$data["date_modified"]= $data["date"];
            //$data["date_activated"]= $data["date"];
            $data["type"]=NULL;
            //$data["type"]= $this->get_var($value['[2][en]type']); 
            
            $data['activation_paid_date']=NULL;
            $data['featured_paid_date']=NULL;

            //$data['agent']=9;
            /* end main param */ 
            
            /* check and filters options */
            $options_data=$this->get_option($value);
            $options_data['agent']=$this->CI->session->userdata('id');
            /* end check and filters options */
            
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
            
            /* hot fix json_object = 0 */
            $result = $this->CI->db->get_where('property_lang', array('json_object' =>'0', 'property_id'=>$insert_id));
            if($result->row()){
                $this->CI->session->set_flashdata('error', 
                        lang_check('Not created json_object in property id = "'.$result->row()->property_id.'" '));
                redirect('admin/estate/import_csv');
                exit();
            }
            /* hot fix json_object = 0 */
            
            /* search values */ //test
            ///*
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
                    if(!empty($val) && $val=='true')
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
            if(!empty($value['images'])) {
            $next_order=0;
            $images= str_replace('"', '', $value['images']);
            $images = explode(',', $images);
           
            foreach ($images as $key => $image_link) {
                if($next_order>=$max_images) break;
                
                if($file_name = $this->do_upload(trim($image_link))){
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
            //$data['image_repository']=615;
            $this->CI->estate_m->save($update_data, $insert_id);  
            // add options for property
            
            /* end create  image_repository and image_filename */
            
            /* end Add file to repository */
            $_count++;
            
            if(empty($value['internalid']))
                $value['internalid'] = '-';
            
            $info[]=array(
                'address'=> $data["address"],
                'id'=> $value["internalid"],
                'preview_id'=> $insert_id
                
            );
        }
        /* end start add new estate */
        return array(
                    'info'=> $info,
                    'count_skip' => $_count_skip,
                    );
    }
    
    
        /*
     * Filter and add options with lang id
     * 
     * @param $options array array with options array(optin10=>value);
     * @return array current for all lang options;
     */    
    protected function get_option($data_lang){
        $options_data = array();
        $row = array();
            foreach($this->option_list as $key=>$option) {
                $option_name=mb_strtolower(trim($option['option']));
                $index_m='option'.$option["id"].'_'.$option["language_id"];
                
                /* check if value missing in dropdown */
                if($option['type'] == 'DROPDOWN' && isset($data_lang['['.$option["id"].']'.'['.$option["code"].']'.$option_name])) {
                    $val= $this->get_var($data_lang['['.$option["id"].']'.'['.$option["code"].']'.$option_name]);
                    
                    if(!empty($val) && strrpos($option['values'], $val)===FALSE) {
                        
                        $this->CI->session->set_flashdata('error', 
                                lang_check('In values for field_id="'.$option['id'].'" and lang code "'.$option['code'].'" missing value "'.$val.'". Please add new value for field and continue import'));
                        redirect('admin/estate/import_csv');
                        exit();
                        
                    }
                    
                }
                
                /* end check if value missing in dropdown */
                
                if(isset($data_lang['['.$option["id"].']'.'['.$option["code"].']'.$option_name]))
                {
                    // php 5.3
                    $val= $this->get_var($data_lang['['.$option["id"].']'.'['.$option["code"].']'.$option_name]); 
                    $row[$index_m]=htmlspecialchars($val);
                  }
                else {
                    $row[$index_m]='';
                }
                /*
                if(!empty($data_lang['['.$option["id"].']'.'['.$option["code"].']'.$option_name])) {
                    $row[$index_m]=trim($data_lang['['.$option["id"].']'.'['.$option["code"].']'.$option_name]);
                } else {
                    $row[$index_m]='';
                }*/
            }
        if(!empty($row)) {
            return $row;
        } else {
            return false;
        }
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
}