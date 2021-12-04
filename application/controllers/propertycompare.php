<?php

class Propertycompare extends Frontend_Controller
{
    
    public function __construct ()
    {
            parent::__construct();
    }
    
    public function _remap($method)
    {
        $param_offset = 2;
        // Default to index
        if (is_numeric($method) || !method_exists($this, $method))
        {
            // We need one more param
            $param_offset = 1;
            $method = 'index';
        }
        
        // Since all we get is $method, load up everything else in the URI
        $params = array_slice($this->uri->rsegment_array(), $param_offset);
        // Call the determined method with all params
        call_user_func_array(array($this, $method), $params);
    }
    
    public function index()
    {    
        // ID-s which should be hidden, just add in array saparated with ,
        $skipped_ids = array(6,38,76);
        
        /* data */
            $this->data['page_navigation_title'] = '';
            $this->data['page_title'] = lang_check('Compare listings');
            $this->data['page_body']  = '';
            $this->data['page_description'] = lang_check('Compare listings');
    
            /* default vars */
            $this->data['all_estates'] = array();
        /* end data */
        
        
        $this->load->library('session');
        $this->load->model('masking_m');
        $lang_code = $this->data['lang_code'];
        $lang_id = $this->data['lang_id'];
        $options_name = $this->option_m->get_lang(NULL, FALSE, $this->data['lang_id']);
        /* option */
        $property_compare_name = array();
        
        $this->data['options_name'] = array();
        $this->data['options_suffix'] = array();
        foreach($options_name as $key=>$row)
        {
            $property_compare_name['option_'.$row->option_id] = $row->option;
            $this->data['options_name_'.$row->option_id] = $row->option;
            $this->data['options_suffix_'.$row->option_id] = $row->suffix;
            $this->data['options_prefix_'.$row->option_id] = $row->prefix;
            $this->data['options_obj_'.$row->option_id] = $row;
            $this->data['options_values_arr_'.$row->option_id] = explode(',',$row->values);
        }
        
        $this->data['property_compare_name'] = $property_compare_name;
        
        
        /* get property from session */
        $where_in=array();
        
        // php 5.3
        $session_compare=$this->session->userdata('property_compare');
        
        if(!empty($session_compare) && count($this->session->userdata('property_compare'))>0):
        foreach ($this->session->userdata('property_compare') as $key => $value) {
            $where_in[]=$key;
        }
        
        $_property_compare = $this->estate_m->get_by(array('language_id'=>$lang_id), FALSE, NULL, 'id DESC',NULL,FALSE,$where_in, false, true);

        $this->data['property_compare'] = array();
        
        $property_compare= array();
        
        foreach ($_property_compare as $key => $estate_arr) {
            $estate = array();
            
            $id = $estate_arr->id;
            $property_compare['id'][$id] = $id;
            
            $property_compare['gps'][$id] = $estate_arr->gps;
            $property_compare['address'][$id] = $estate_arr->address;
            $property_compare['date'][$id] = $estate_arr->date;
            $property_compare['repository_id'][$id] = $estate_arr->repository_id;
            $property_compare['is_featured'][$id] = $estate_arr->is_featured;
            $property_compare['counter_views'][$id] = $estate_arr->counter_views;
            $property_compare['estate_data_id'][$id] = $estate_arr->id;
            $property_compare['agent_name'][$id] = $estate_arr->name_surname;
            $property_compare['agent_mail'][$id] = $estate_arr->mail;
            $property_compare['agent_phone'][$id] = $estate_arr->phone;
            $property_compare['agent_id'][$id] = $estate_arr->agent_id;
            
            //address
            if(!isset($property_compare['address']['tr'])) {
            $property_compare['address']['tr']='<td>'.  lang_check('Address').'</td>';
            }
            $property_compare['address']['tr'].='<td>'.$estate_arr->address.'</td>';
            
            //agent
            if(!isset($property_compare['agent_name']['tr'])) {
            $property_compare['agent_name']['tr']='<td>'.  lang_check('Agent name').'</td>';
            }
            $property_compare['agent_name']['tr'].='<td>'.$estate_arr->name_surname.'</td>';
            
            $json_obj = json_decode($estate_arr->json_object);
            foreach($options_name as $key2=>$row2)
            {
                $type= $row2->type;
                
                //skip
                if($type=='TEXTAREA') continue;
                if($type=='CATEGORY') continue;
                if($type=='UPLOAD') continue;
                if($type=='HTMLTABLE') continue;
                if($type=='PEDIGREE') continue;
                if($type=='TREE') continue;

                if(in_array($row2->option_id, $skipped_ids)) continue;
                if(in_array($row2->parent_id, $skipped_ids)) continue;
                
                $key1 = $row2->option_id;
                
                if(isset($json_obj->{"field_$key1"}))
                {
                    $row1 = $json_obj->{"field_$key1"};
                    $property_compare['option_'.$key1]['values'][$id] = $row1;
                    
                    /* check if  row empty */
                    if(!isset($property_compare['option_'.$key1]['empty']))
                        $property_compare['option_'.$key1]['empty'] = true;
                    
                    if(!empty($row1))    
                        $property_compare['option_'.$key1]['empty'] = false;
                    /* end check if row empty */
                    
                    if(!isset($property_compare['option_'.$key1]['tr'])) {
                        $property_compare['option_'.$key1]['tr']='<td>'.$property_compare_name['option_'.$key1].'</td>';
                    }
                    
                    if(!empty($row1)){
                        if($type=='CHECKBOX') {
                            $property_compare['option_'.$key1]['tr'].='<td style="text-align:center;"><img src="assets/img/checkbox_true.png" alt="true" class="check"></td>';
                        } else{
                            $property_compare['option_'.$key1]['tr'].='<td>'.$row1.' '.$this->data['options_prefix_'.$key1].' '.$this->data['options_suffix_'.$key1].'</td>';
                        }
                    } else {
                        $property_compare['option_'.$key1]['tr'].='<td></td>'; 
                    }
                    
                   
                    //type
                    $property_compare['option_'.$key1]['type']=$row2->type;
                } else {
                    if(!isset($property_compare['option_'.$key1]['empty']))
                        $property_compare['option_'.$key1]['empty'] = true;
                    
                    if(!isset($property_compare['option_'.$key1]['tr'])) {
                        $property_compare['option_'.$key1]['tr']='<td>'.$property_compare_name['option_'.$key1].'</td>';
                    }
                    
                    $property_compare['option_'.$key1]['type']='';
                    $property_compare['option_'.$key1][$id] = '';
                    $property_compare['option_'.$key1]['tr'].='<td></td>'; 
                }
                
                
            }
            
            if(isset($estate_arr->image_filename))
            {
                $property_compare['thumbnail_url']['values'][$id] = base_url('files/thumbnail/'.$estate_arr->image_filename);
            }
            else
            {
                $property_compare['thumbnail_url']['values'][$id] = 'assets/img/no_image.jpg';
            }
            
            // Url to preview
            if(isset($json_obj->field_10))
            {
                $property_compare['url']['values'][$id] = slug_url($this->data['listing_uri'].'/'.$estate_arr->id.'/'.$this->data['lang_code'].'/'.url_title_cro($json_obj->field_10));
            }
            else
            {
                $property_compare['url']['values'][$id] = slug_url($this->data['listing_uri'].'/'.$estate_arr->id.'/'.$this->data['lang_code']);
            }
        }
         $this->data['property_compare']=$property_compare;
        endif;
        /* end get property from session */
         
         
        // standart

        
          /* Validation for contact */
        $rules = array(
            'firstname' => array('field'=>'firstname', 'label'=>'lang:FirstLast', 'rules'=>'trim|required|xss_clean'),
            'email' => array('field'=>'email', 'label'=>'lang:Email', 'rules'=>'trim|required|xss_clean'),
            'phone' => array('field'=>'phone', 'label'=>'lang:Phone', 'rules'=>'trim|xss_clean'),
            'message' => array('field'=>'message', 'label'=>'lang:Message', 'rules'=>'trim|required|xss_clean')
       );
       
       if(config_item('captcha_disabled') === FALSE)
            $rules['captcha'] = array('field'=>'captcha', 'label'=>'lang:Captcha', 'rules'=>'trim|required|callback_captcha_check|xss_clean');
       
       if(isset($_POST['question']))
       {
            unset($rules['message']);
            $rules['question'] = array('field'=>'question', 'label'=>'lang:Question', 'rules'=>'trim|required|xss_clean');
       }
       
       $this->form_validation->set_rules($rules);
        
        // Process the form
        if($this->form_validation->run() == TRUE)
        {
            $data = $this->page_m->array_from_post(array('firstname', 'email', 'phone', 'message'));

            // Send email
            $this->load->library('email');
            $config_mail['mailtype'] = 'html';
            $this->email->initialize($config_mail);
            
            $this->email->from($this->data['settings_noreply'], lang_check('Web page'));
            $this->email->to($this->data['settings_email']);
            
            $this->email->subject(lang_check('Message from real-estate web'));
            
            if(isset($_POST['question']))
            {
                $this->load->model('qa_m');
                
                $data_t = $this->page_m->array_from_post(array('firstname', 'email', 'phone', 'question'));
                
                $data = array();
                $data['is_readed'] = 0;
                $data['date'] = date('Y-m-d H:i:s');
                $data['type'] = 'QUESTION';
                $data['answer_user_id'] = 0;
                $data['parent_id'] = 0;
                
                $data_lang = array();
                $data_lang['question_'.$lang_id] = $data_t['question'];
                
                $id = $this->qa_m->save_with_lang($data, $data_lang, NULL);
                $this->email->subject(lang_check('Expert question from real-estate web'));
    
                $data['name_surname'] = $data_t['firstname'];
                $data['phone'] = $data_t['phone'];
                $data['mail'] = $data_t['email'];
            }
            
            unset($_POST['captcha'], $_POST['captcha_hash']);
            
            $message='';
            foreach($_POST as $key=>$value){
            	$message.="$key:\n$value\n";
            }
                        
            $message = $this->load->view('email/contact_message', array('data'=>$data), TRUE);
            
            $this->email->message($message);
            if ( ! $this->email->send())
            {
                $this->session->set_flashdata('email_sent', 'email_sent_false');
            }
            else
            {
                $this->session->set_flashdata('email_sent', 'email_sent_true');
            }
            
//            echo $this->email->print_debugger();
//            exit();

            redirect($this->uri->uri_string());
        }
        
        $this->data['validation_errors'] = validation_errors();

        $this->data['form_sent_message'] = '';
        if($this->session->flashdata('email_sent'))
        {
            if($this->session->flashdata('email_sent') == 'email_sent_true')
            {
                $this->data['form_sent_message'] = '<p class="alert alert-success">'.lang_check('message_sent_successfully').'</p>';
            }
            else
            {
                $this->data['form_sent_message'] = '<p class="alert alert-error">'.lang_check('message_sent_error').'</p>';
            }  
        }
        
        // Form errors
        $this->data['form_error_firstname'] = form_error('firstname')==''?'':'error';
        $this->data['form_error_email'] = form_error('email')==''?'':'error';
        $this->data['form_error_phone'] = form_error('phone')==''?'':'error';
        $this->data['form_error_message'] = form_error('message')==''?'':'error';
        $this->data['form_error_question'] = form_error('question')==''?'':'error';
        $this->data['form_error_captcha'] = form_error('captcha')==''?'':'error';
        
        // Form values
        $this->data['form_value_firstname'] = set_value('firstname', '');
        $this->data['form_value_email'] = set_value('email', '');
        $this->data['form_value_phone'] = set_value('phone', '');
        $this->data['form_value_message'] = set_value('message', '');
        $this->data['form_value_question'] = set_value('question', '');
        
        /* End validation for contact */
        
        /* Get last n properties */
        $last_n = 4;
        if(config_item('last_estates_limit'))
            $last_n = config_item('last_estates_limit');
        
        $last_n_estates = $this->estate_m->get_by(array('is_activated' => 1, 'language_id'=>$lang_id), FALSE, $last_n, 'id DESC');
        
        $this->data['last_estates_num'] = $last_n;
        $this->data['last_estates'] = array();
        foreach($last_n_estates as $key=>$estate_arr)
        {
            $estate = array();
            $estate['id'] = $estate_arr->id;
            $estate['gps'] = $estate_arr->gps;
            $estate['address'] = $estate_arr->address;
            $estate['date'] = $estate_arr->date;
            $estate['repository_id'] = $estate_arr->repository_id;
            $estate['is_featured'] = $estate_arr->is_featured;
            $estate['counter_views'] = $estate_arr->counter_views;
            $estate['estate_data_id'] = $estate_arr->id;
            
            $json_obj = json_decode($estate_arr->json_object);
            
            foreach($options_name as $key2=>$row2)
            {
                $key1 = $row2->option_id;
                $estate['has_option_'.$key1] = array();
                
                if(isset($json_obj->{"field_$key1"}))
                {
                    $row1 = $json_obj->{"field_$key1"};
                    $estate['option_'.$key1] = $row1;
                    $estate['option_chlimit_'.$key1] = character_limiter(strip_tags($row1), 80);
                    $estate['option_icon_'.$key1] = '';
                    
                    if(!empty($row1))
                    {
                        $estate['has_option_'.$key1][] = array('count'=>count($row1));
                        
                        if(file_exists(FCPATH.'templates/'.$this->data['settings_template'].
                            '/assets/img/icons/option_id/'.$key1.'.png'))
                        {
                            $estate['option_icon_'.$key1] = '<img class="results-icon" src="assets/img/icons/option_id/'.$key1.'.png" alt="'.$row1.'"/>';;
                            $estate['icons'][]['icon']= $estate['option_icon_'.$key1];
                        }
                    }
                }
            }
            
            // [START] custom price field
//            $estate['custom_price'] = '';
//            if(!empty($estate['option_36']))
//                $estate['custom_price'].=$this->data['options_prefix_36'].$estate['option_36'].$this->data['options_suffix_36'];
//            if(!empty($estate['option_37']))
//                $estate['custom_price'].=$this->data['options_prefix_37'].$estate['option_37'].$this->data['options_suffix_37'];
//            if(empty($estate['option_37']) && !empty($estate['option_56']))
//                $estate['custom_price'].=$this->data['options_prefix_56'].$estate['option_56'].$this->data['options_suffix_56'];
            // [END] custom price field
            
            // Url to preview
            if(isset($json_obj->field_10))
            {
                $estate['url'] = slug_url($this->data['listing_uri'].'/'.$estate_arr->id.'/'.$this->data['lang_code'].'/'.url_title_cro($json_obj->field_10));
            }
            else
            {
                $estate['url'] = slug_url($this->data['listing_uri'].'/'.$estate_arr->id.'/'.$this->data['lang_code']);
            }
            
            // Thumbnail
            if(isset($estate_arr->image_filename))
            {
                $estate['thumbnail_url'] = base_url('files/thumbnail/'.$estate_arr->image_filename);
            }
            else
            {
                $estate['thumbnail_url'] = 'assets/img/no_image.jpg';
            }

            $this->data['last_estates'][] = $estate;
        }
        
        /* END Get last n properties */
        
        /* Widgets functions */
        $this->data['print_menu'] = get_menu($this->temp_data['menu'], false, $this->data['lang_code']);
        $this->data['print_menu_realia'] = get_menu_realia($this->temp_data['menu'], false, $this->data['lang_code']);
        $this->data['print_lang_menu'] = get_lang_menu($this->language_m->get_array_by(array('is_frontend'=>1)), $this->data['lang_code']);
        $this->data['page_template'] = $this->temp_data['page']->template;
        /* End widget functions */
        
        $output = $this->parser->parse($this->data['settings_template'].'/propertycompare.php', $this->data, TRUE);
        echo str_replace('assets/', base_url('templates/'.$this->data['settings_template']).'/assets/', $output);
    }
        
}
