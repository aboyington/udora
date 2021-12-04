<?php

class Estate_m extends MY_Model {
    
    protected $_table_name = 'property';
    protected $_order_by = 'is_featured DESC, id DESC';
    public $rules = array(
        'gps' => array('field'=>'gps', 'label'=>'lang:Gps', 'rules'=>'trim|required|xss_clean|callback_gps_check'),
        'date' => array('field'=>'date', 'label'=>'lang:DateTime', 'rules'=>'trim|required|xss_clean'),
        'address' => array('field'=>'address', 'label'=>'lang:Address', 'rules'=>'trim|required|xss_clean|quote_fix'),
        'is_featured' => array('field'=>'is_featured', 'label'=>'lang:Featured', 'rules'=>'trim|callback_featured_limitation_check'),
        'is_activated' => array('field'=>'is_activated', 'label'=>'lang:Activated', 'rules'=>'trim'),
        'is_visible' => array('field'=>'is_visible', 'label'=>'lang:Visible', 'rules'=>'trim'),
        'agent' => array('field'=>'agent', 'label'=>'lang:Agent', 'rules'=>'trim'),
        'id_transitions' => array('field'=>'id_transitions', 'label'=>'lang:Transitions id', 'rules'=>'trim'),
   );
    
    public $options;
   
	public function __construct(){
		parent::__construct();
        
        $this->load->model('language_m');
        $this->languages = $this->language_m->get_form_dropdown('language', FALSE, FALSE);
                                  
        //Rules for languages
        foreach($this->languages as $key=>$value)
        {
            $this->rules["slug_$key"] = array('field'=>"slug_$key", 'label'=>'lang:URI slug', 'rules'=>'trim');
        }
        
        if(config_db_item('address_not_required') === TRUE)
        {
            $this->rules['address']['rules'] = 'trim|xss_clean|quote_fix';
            $this->rules['gps']['rules'] = 'trim|xss_clean|callback_gps_check';
        }
        
        $this->load->model('option_m');
        $this->options = $this->option_m->get_field_list($this->language_m->get_default_id());
        
	}

    public function get_new()
	{
        $estate = new stdClass();
        $estate->gps = '';
        $estate->address = '';
        $estate->date = date('Y-m-d H:i:s');
        $estate->agent = NULL;
        $estate->is_featured = '0';
        $estate->is_activated = '0';
        $estate->is_visible = '1';
        $estate->counter_views = 0;
        $estate->id_transitions = '';
        
        //Add language parameters
        foreach($this->languages as $key=>$value)
        {
            $estate->{"slug_$key"} = '';
        }        
        
        return $estate;
	}
    
    public function get_new_array()
	{
        $estate = array();
        $estate['gps'] = '';
        $estate['address'] = '';
        $estate['date'] = date('Y-m-d H:i:s');
        $estate['agent'] = NULL;
        $estate['is_featured'] = '0';
        $estate['is_activated'] = '0';
        $estate['is_visible'] = '1';
        $estate['counter_views'] = 0;
        $estate['id_transitions'] = '';
        
        //Add language parameters
        foreach($this->languages as $key=>$value)
        {
            $estate["slug_$key"] = '';
        }  
        
        return $estate;
	}
    
    public function update_counter($property_id)
    {
        // $this->db->set('counter_views', 'counter_views+'.rand(1,13), FALSE); // Fake views version
        
        $this->db->set('counter_views', 'counter_views+1', FALSE);
        $this->db->where('id', $property_id);
        $this->db->update($this->_table_name); 
    }
    
    public function get_array($id = NULL, $single = FALSE, $where = NULL)
    {
        $this->db->join($this->_table_name.'_lang', $this->_table_name.'.id = '.$this->_table_name.'_lang.property_id');
        
        if(!empty($where))
            $this->db->where($where);
        
        return parent::get_array($id, $single);
    }
    
    public function count_get_by($where, $single = FALSE, $limit = NULL, $order_by = NULL, $offset = NULL, $search = array(), $where_in = NULL, $check_user = FALSE)
    {
        $this->db->cache_on();
        
        $this->filter_results($where, $search, $where_in);
        
        /* // Not important for count function
        if($order_by !== NULL)
        {
            $this->db->order_by($order_by);
        }
        else
        {
            $this->db->order_by($this->_order_by);
        }
        */
        
        if($limit !== NULL) $this->db->limit($limit, $offset);
        
        if($check_user === TRUE)
        {
            if($this->session->userdata('type') == 'AGENT_COUNTY_AFFILIATE')
            {
                $this->db->join('property_user', $this->_table_name.'.id = property_user.property_id', 'right');
            }
            else if($this->session->userdata('type') != 'ADMIN' && $this->session->userdata('type') != 'AGENT_ADMIN')
            {
                $this->db->join('property_user', $this->_table_name.'.id = property_user.property_id', 'right');
                //$this->db->where('user_id', $this->session->userdata('id'));
                
                // [AGENCY AGENT]
                if(config_db_item('agency_agent_enabled') === TRUE)
                {
                    $this->db->join('user', 'property_user.user_id = user.id', 'left');
                    $this->db->where('(user_id = '.$this->session->userdata('id').' OR agency_id = '.$this->session->userdata('id').')', NULL);
                }
                else
                {
                    $this->db->where('user_id', $this->session->userdata('id'));
                }
                // [/AGENCY AGENT]
                
            }
            
            
        }
        else if(is_numeric($check_user))
        {
            $this->db->join('property_user', $this->_table_name.'.id = property_user.property_id', 'right');
            $this->db->where('user_id', $check_user);
        }
        
//        $query = $this->db->get();
//        if(!is_object($query))
//        {
//            $str = $this->db->last_query();
//            echo 'Error in query'."\n";
//            echo $str;
//            exit();
//        }
        
        $num = $this->db->count_all_results();
        
        $this->db->cache_off();
        return $num;
    }
    
    public function get_by($where, $single = FALSE, $limit = NULL, $order_by = NULL, $offset = NULL, $search = array(), $where_in = NULL, $check_user = FALSE, $fetch_user_details=FALSE)
    {
        $this->db->cache_on();
        
        $this->filter_results($where, $search, $where_in, $order_by);

        if($order_by != 'RAND()' && $order_by !== NULL 
            && strpos($order_by, 'date') !== FALSE)
        {
            $order_by = str_replace('date', 'id', $order_by);
        }
        
        if($order_by != 'RAND()' && $order_by !== NULL && 
            config_db_item('orderby_datemodified_enabled') === TRUE 
            && strpos($order_by, 'id') !== FALSE)
        {
            $order_by = str_replace('property.id', 'property.date_modified', $order_by);
            $order_by = str_replace('id', 'property.date_modified', $order_by);
        }
        
        if($order_by != 'RAND()' && $order_by !== NULL && 
            config_db_item('orderby_daterenew_enabled') === TRUE 
            && strpos($order_by, 'id') !== FALSE)
        {
            $order_by = str_replace('property.id', 'property.date_renew', $order_by);
            $order_by = str_replace('id', 'property.date_renew', $order_by);
        }
        
        if($order_by !== NULL)
        {
            $this->db->order_by($order_by);
        }
        else
        {
            $this->db->order_by($this->_order_by);
        }
        
        if($limit !== NULL) $this->db->limit($limit, $offset);

        if($check_user === TRUE)
        {
            if($this->session->userdata('type') == 'AGENT_COUNTY_AFFILIATE')
            {
                $this->db->join('property_user', $this->_table_name.'.id = property_user.property_id', 'right');
            }
            else if($this->session->userdata('type') != 'ADMIN' && $this->session->userdata('type') != 'AGENT_ADMIN')
            {
                $this->db->join('property_user', $this->_table_name.'.id = property_user.property_id', 'right');
                
                // [AGENCY AGENT]
                if(config_db_item('agency_agent_enabled') === TRUE)
                {
                    $this->db->join('user', 'property_user.user_id = user.id', 'left');
                    $this->db->where('(user_id = '.$this->session->userdata('id').' OR agency_id = '.$this->session->userdata('id').')', NULL);
                }
                else
                {
                    $this->db->where('user_id', $this->session->userdata('id'));
                }
                // [/AGENCY AGENT]
            }
        }
        else if(is_numeric($check_user))
        {
            $this->db->join('property_user', $this->_table_name.'.id = property_user.property_id', 'right');
            $this->db->where('user_id', $check_user);
        }
        else if($fetch_user_details == true)
        {
            $this->db->select($this->_table_name.'.*, '.$this->_table_name.'_lang.*, user.name_surname, user.mail, user.phone, user.id as agent_id, user.image_user_filename');
            $this->db->join('property_user', $this->_table_name.'.id = property_user.property_id', 'left');
            $this->db->join('user', 'property_user.user_id = user.id', 'left');
        }

        $query = $this->db->get();  
        
        if(!is_object($query))
        {
            $str = $this->db->last_query();
            echo 'Error in query'."\n";
            echo $str;
            exit();
        }
        
        $results = $query->result();
        
        $this->db->cache_off();
        
        return $results;
    }
    
    private function filter_results($where, $search_array = array(), $where_in = NULL, &$order_by = NULL)
    {
        $rectangle_ne = $this->input->get_post('v_rectangle_ne');
        $rectangle_sw = $this->input->get_post('v_rectangle_sw');
        $search_radius = $this->input->get_post('v_search_radius');

        $options = $this->options;
        //print_r($options);
        
        if(!is_array($search_array))
            $search_array = (array) $search_array;
          
        if(isset($search_array['v_rectangle_ne']))
            $rectangle_ne = $search_array['v_rectangle_ne'];
            
        if(isset($search_array['v_rectangle_sw']))
            $rectangle_sw = $search_array['v_rectangle_sw'];
            
        if(isset($search_array['v_search_radius']))
            $search_radius = $search_array['v_search_radius'];

        if(isset($search_array['v_search_option_location']) && !empty($search_array['v_search_option_location'])){
            $search_array['v_search_option_smart'] = $search_array['v_search_option_location'];
            /*$search_radius = '100';*/
        }
        if(empty($search_radius))
            $search_radius = '100';
        
        // [START] Radius search
        if(isset($search_radius) && isset($search_array['v_search_option_smart']) && $search_radius > 0)
        {
            $this->load->library('ghelper');
            $coordinates_center = $this->ghelper->getCoordinates($search_array['v_search_option_smart']);
            
            if(count($coordinates_center) >= 2 && $coordinates_center['lat'] != 0)
            {
                $distance_unit = 'km';
                if(lang_check('km') == 'm')
                {
                    $distance_unit = 'm';
                }
                
                // calculate rectangle
                $rectangle_ne = $this->ghelper->getDueCoords($coordinates_center['lat'], $coordinates_center['lng'], 45, $search_radius, $distance_unit);
                $rectangle_sw = $this->ghelper->getDueCoords($coordinates_center['lat'], $coordinates_center['lng'], 225, $search_radius, $distance_unit);
                
                unset($search_array['v_search_option_smart'], $search_array['search_option_smart']);
            }
        }
        // [END] Radius search
        
        //var_dump($search_array, $rectangle_ne, $rectangle_sw);

        $fields = $this->db->list_fields('property_lang');
        $fields = array_flip($fields);
        
        //$this->db->distinct();
        $this->db->select($this->_table_name.'.*, '.$this->_table_name.'_lang.*');
        $this->db->from($this->_table_name);
        $this->db->join($this->_table_name.'_lang', $this->_table_name.'.id = '.$this->_table_name.'_lang.property_id');
        if($where !== NULL) $this->db->where($where);
        
        // [RECTANGLE SEARCH]
        if(!empty($rectangle_ne) && !empty($rectangle_sw))
        {
            $gps_ne = explode(', ', $rectangle_ne);
            $gps_sw = explode(', ', $rectangle_sw);
            $this->db->where("(property.lat < '$gps_ne[0]' AND property.lat > '$gps_sw[0]' AND 
                               property.lng < '$gps_ne[1]' AND property.lng > '$gps_sw[1]')");
        }
        // [/RECTANGLE SEARCH]
        
        if($where_in !== NULL){
            if(count($where_in) == 0)
            {
                $this->db->where_in('property.id', -1);
            }
            else
            {
                $this->db->where_in('property.id', $where_in);
            }
        }
        
        // [is_featured via API]
        if(!empty($search_array['v_search_option_is_featured']))
        {
            if(substr($search_array['v_search_option_is_featured'],0,4) == 'true')
            {
                $this->db->where('property.is_featured', 1);
            }
        }
        
        
        // [is_visible via API]
        if(!empty($search_array['v_search_option_is_visible']))
        {
            if(substr($search_array['v_search_option_is_visible'],0,4) == 'true')
            {
                $this->db->where('property.is_visible', 1);
            }
        }
        
        unset($search_array['v_search_option_is_visible']);
        
        /* hide listing if not visible */
        //$this->db->where('property.is_visible', 1);
        
        // [/is_featured via API]

        unset($search_array['v_rectangle_ne'], $search_array['v_undefined'],
              $search_array['v_rectangle_sw'], $search_array['v_search-start'],
              $search_array['v_search_radius'], $search_array['v_search_option_is_featured']);

        if(count($search_array) > 0)
        {
            foreach($search_array as $key=>$val)
            {
                $parts = explode('_', $key);

                if(isset($parts[3]) && is_numeric($parts[3]))
                    $option_id = $parts[3];
                else $parts[3] = 'NULL';
                
                if($key == 'view')
                {
                    
                }
                else if($key == 'order')
                {
                    //$order_by = "`property`.`is_featured` DESC, `property`.$val";
                }
                else if($key == 'page_num')
                {

                }
                else if($key == 'search_option_smart' ||
                   $key == 'v_search_option_smart' ||
                   $key == 'v_search_option_quick')
                {
// Commented because numeric search should also work for zip code
//                    if(is_numeric($val))
//                    {
//                        $this->db->where('property.id', $val);
//                    }
//                    else 
                    if($val != "")
                    {
                        if(config_item('smart_search_disabled') === TRUE)
                        {
                            /* 
                               This method requre field_10 and field_64 
                               columns in database property_lang table
                            */
                            
                            $this->db->where("(property.id = '$val' OR ".
                                             "field_10 LIKE '%$val%' OR ".
                                             "field_64 LIKE '%$val%')");
                        }
                        else
                        {
                            $this->db->where("(property.id = '$val' OR property.address LIKE '%$val%' OR search_values LIKE '%$val%')");
                        }
                    }
                }
                else if($key == 'v_search_option_location')
                {
                   /* if($val != "")
                    {
                        $_val = explode(',', $val);
                        $query ='';
                            foreach ($_val as $key => $_val_parse) {
                            $_val_parse = trim($_val_parse);
                            if(empty($_val_parse)) continue;

                            if(empty($query)) 
                                    $query.='(';
                            else
                                    $query.=' OR ';

                            $query .="(json_object LIKE '%$_val_parse%' OR property.address LIKE '%$_val_parse%' OR search_values LIKE '%$_val_parse%')";
                            }
                        if(!empty($query)){
                                $query .=')';
                                $this->db->where($query);
                            }
                    }*/
                }
                else if(strrpos($key, 'from') > 0 && isset($fields['field_'.$option_id.'_int']) && (is_numeric($val) || $options[$option_id]->type == 'DATETIME'))
                {
                    if(isset($fields['field_'.$option_id.'_int']))
                    {
                        if(is_numeric($val))    
                            $val = intval($val);
                        $this->db->where("(".'field_'.$option_id.'_int'." >= '$val')");
                    }
                }
                else if(strrpos($key, 'to') > 0 && isset($fields['field_'.$option_id.'_int']) && (is_numeric($val) || $options[$option_id]->type == 'DATETIME'))
                {
                    if(isset($fields['field_'.$option_id.'_int']))
                    {
                        if(is_numeric($val))    
                            $val = intval($val);
                            
                        $this->db->where("(".'field_'.$option_id.'_int'." <= '$val')");
                    }
                }
                else if((config_item('field_dropdown_multiple_enabled') == TRUE) && (strrpos($key, 'multi') > 0))
                {
                    if(is_array($val) && !empty($val)){
                    $query ='(';
                        foreach ($val as $key => $val_parse) {
                            if($key !=0) $query.=' OR ';
                            if(!empty($val_parse))
                                $query .="(json_object LIKE '%\"field_$option_id\":\"$val_parse\"%')";
                        }
                    $query .=')';
                    $this->db->where($query);
                    }
                }
                
                else if(strrpos($key, 'search_option') > 0 && isset($fields['field_'.$option_id]) /*&& $option_id != 4*/ && $val != "" && $options[$option_id]->type != 'TREE')
                {
                    if(isset($fields['field_'.$option_id]))
                    {
                        $this->db->where('field_'.$option_id, $val);
                    }
                }
                else if(strrpos($key, 'rectangle') > 0)
                {
                    
                }
                else if(is_numeric($val) && isset($option_id))
                {
                    //$this->db->where("(search_values LIKE '% $val %')");
                    $this->db->where("(json_object LIKE '%\"field_$option_id\":\"$val\"%')");
                }
                else if($val && isset($option_id))
                {
                    if(substr($val,0,4) == 'true')
                       $val='true';
                    
                    if(isset($options[$option_id]) && $options[$option_id]->type == 'TREE') 
                        $this->db->where("(json_object LIKE '%\"field_$option_id\":\"".trim($val)."%')");
                    else 
                        $this->db->where("(json_object LIKE '%\"field_$option_id\":\"".trim($val)."\"%')");

                }
                else if($val != "")
                {
                    $this->db->where("(search_values LIKE '%$val%')");
                }
            }
        }
    }
    
    public function get_search($search_tag)
    {
        // Fetch pages without parents
        $this->db->distinct();
        $this->db->select($this->_table_name.'.id, gps, property.address, is_featured, is_activated');
        $this->db->from($this->_table_name);
        $this->db->join($this->_table_name.'_value', $this->_table_name.'.id = '.$this->_table_name.'_value.property_id');
        
        $this->db->where("(property.id = '$search_tag' OR property.address LIKE '%$search_tag%' OR value LIKE '%$search_tag%')");
        
        if($this->session->userdata('type') != 'ADMIN' && $this->session->userdata('type') != 'AGENT_ADMIN')
        {
            $this->db->join('property_user', $this->_table_name.'.id = property_user.property_id', 'right');
            $this->db->where('user_id', $this->session->userdata('id'));
        }
        
        $query = $this->db->get();
        $results = $query->result();
        
        return $results;
    }
    
    public function get_last($n = 5)
    {
        $this->db->select('property.*');
        $this->db->limit($n);
        $this->db->from($this->_table_name);
        
        if($this->session->userdata('type') != 'ADMIN' && $this->session->userdata('type') != 'AGENT_ADMIN')
        {
            $this->db->select('property.*, property_user.user_id');
            $this->db->join('property_user', $this->_table_name.'.id = property_user.property_id', 'left');
            $this->db->where('user_id', $this->session->userdata('id'));
        }
        
        $this->db->order_by($this->_table_name.'.id DESC');

        $query = $this->db->get();
        return $query->result();
    }
    
    public function get_dynamic($id)
    {
        $this->db->cache_on();
        
        $data = parent::get($id);
        
        if($data == NULL) return NULL;
        
        $this->db->where('property_id', $id);
        $query = $this->db->get('property_value');
        
        foreach ($query->result() as $row)
        {
            $data->{'option'.$row->option_id.'_'.$row->language_id} = $row->value;
        }
        
        // Get agent
        $data->agent = null;
        $this->db->where('property_id', $id);
        $this->db->limit(1);
        $query = $this->db->get('property_user');
        foreach ($query->result() as $row)
        {
            $data->agent = $row->user_id;
        }
        
        // Get slug
        $this->load->model('slug_m');
        foreach($this->languages as $key=>$value)
        {
            $slug_data = $this->slug_m->get_slug('estate_m_'.$id.'_'.$this->language_m->db_languages_id[$key]);
            
            $data->{"slug_$key"} = '';
            if($slug_data !== FALSE)
                $data->{"slug_$key"} = $slug_data->slug;
        }
        
        $this->db->cache_off();
        
        return $data;
    }
    
    public function get_dynamic_array($id)
    {
        $data = parent::get_array($id);
        
        if($data == NULL) return NULL;
        
        $this->db->where('property_id', $id);
        $query = $this->db->get('property_value');
        
        foreach ($query->result() as $row)
        {
            $data['option'.$row->option_id.'_'.$row->language_id] = $row->value;
        }
        
        // Get agent
        $data['agent'] = null;
        $this->db->where('property_id', $id);
        $this->db->limit(1);
        $query = $this->db->get('property_user');
        foreach ($query->result() as $row)
        {
            $data['agent'] = $row->user_id;
        }
        
        // Get slug
        $this->load->model('slug_m');
        foreach($this->languages as $key=>$value)
        {
            $slug_data = $this->slug_m->get_slug('estate_m_'.$id.'_'.$this->language_m->db_languages_id[$key]);

            $data["slug_$key"] = '';
            if($slug_data !== FALSE)
                $data["slug_$key"] = $slug_data->slug;
        }
        
        return $data;
    }
    
    public function get_join($limit = null, $offset = "", $lang_id=NULL)
    {
        $this->db->select('property.*, property_user.user_id as agent');
        $this->db->from($this->_table_name);
        $this->db->join('property_user', $this->_table_name.'.id = property_user.property_id', 'left');
        
        if($lang_id !== NULL)
        {
            $this->db->join('property_lang', $this->_table_name.'.id = property_lang.property_id', 'left');
        }
        
        if($this->session->userdata('type') != 'ADMIN' && $this->session->userdata('type') != 'AGENT_ADMIN')
        {
            $this->db->where('user_id', $this->session->userdata('id'));
        }
        
        $this->db->order_by('property.id DESC');
        
        if($limit != null)
            $this->db->limit($limit, $offset);
        
        $query = $this->db->get();
        
        return $query->result();
    }
    
    public function get_form_dropdown($column, $where = FALSE, $empty=TRUE, $show_id=TRUE, $check_user=true)
    {
        $this->db->select('property.*, property_user.user_id as agent');
        $this->db->from($this->_table_name);
        $this->db->join('property_user', $this->_table_name.'.id = property_user.property_id', 'left');

        if($this->session->userdata('type') != 'ADMIN' && $this->session->userdata('type') != 'AGENT_ADMIN' && $check_user)
        {
            $this->db->where('user_id', $this->session->userdata('id'));
        }
        
        $this->db->order_by('id DESC');

        $filter = $this->_primary_filter;
        
        if(!count($this->db->ar_orderby))
        {
            $this->db->order_by($this->_order_by);
        }
        
        if($where)
            $this->db->where($where); 
        
        $dbdata = $this->db->get()->result_array();
        
        $results = array();
        if($empty)$results[''] = '';
        foreach($dbdata as $key=>$row){
            if(isset($row[$column]))
            {
                if(lang($row[$column]) != '')$row[$column] = lang($row[$column]);
                
                if(empty($row[$column]))$row[$column]='-';
                $results[$row[$this->_primary_key]] = $row[$column];
                
                if($show_id)
                {
                    $results[$row[$this->_primary_key]] = $row['id'].', '.$results[$row[$this->_primary_key]];
                }
                
            }
            
        }
        return $results;
    }
    
    public function save($data, $id=NULL)
    {
        // Save lat lng in decimal for radius/rectangle search
        if(!empty($data['gps']))
        {
            $gps = explode(', ', $data['gps']);
            $data['lat'] = floatval($gps[0]);
            $data['lng'] = floatval($gps[1]);
        }
        
        // [Save first image in repository]
        $curr_estate = $this->get($id);
        $repository_id = NULL;
        if(is_object($curr_estate))
        {
            $repository_id = $curr_estate->repository_id;
        }
        
        if($id === NULL && 
            isset($data['repository_id']) && 
            is_numeric($data['repository_id']))
        {
            $repository_id = $data['repository_id'];
        }
        
        $data['image_repository'] = NULL;
        $data['image_filename'] = NULL;
        if(!empty($repository_id))
        {
            $files = $this->file_m->get_by(array('repository_id'=>$repository_id));
            
            $image_repository = array();
            foreach($files as $key_f=>$file_row)
            {
                if(is_object($file_row))
                if(file_exists(FCPATH.'files/thumbnail/'.$file_row->filename))
                {
                    if(empty($data['image_filename']))
                        $data['image_filename'] = $file_row->filename;
                        
                    $image_repository[] = $file_row->filename;
                }
            }
            
            $data['image_repository'] = json_encode($image_repository);
        }
        // [/Save first image in repository]
        $data['last_edit_ip']=$this->input->ip_address();
        
//        dump($data);
//        exit();
        return parent::save($data, $id);
    }
    
    public function save_dynamic($data, $id, $run_delete = TRUE)
    {
        // Delete all
        if($run_delete)
        {
            $this->db->where('property_id', $id);
            $this->db->where('value !=', 'SKIP_ON_EMPTY');
            $this->db->delete('property_value'); 
        }
        
        if(config_db_item('slug_enabled') === TRUE)
        {
            // save slug
            $this->load->model('slug_m');
            $this->slug_m->save_slug('estate_m', $id, $data);
        }
        
        // Fetch fields with cache
        if(($fields = $this->cache_temp_load('fields')) === FALSE)
        {
            $fields = $this->db->list_fields('property_lang');
            $fields = array_flip($fields);
            $this->cache_temp_save($fields, 'fields');
        }
        
        $this->load->library('mymemoryTranslation', array());
               
        // Insert all
        $insert_batch = array();
        $data_property_lang = array();
        foreach($data as $key=>$value)
        {
            if(substr($key, 0, 6) == 'option')
            {
                $pos = strpos($key, '_');
                $option_id = substr($key, 6, $pos-6);
                $language_id = substr($key, $pos+1);
                
                if($value === false)$value='';
                
                $val_numeric = get_numeric_val($value);
                
                $insert_arr = array('language_id' => intval($language_id),
                                    'property_id' => intval($id),
                                    'option_id' => intval($option_id),
                                    'value' => $value,
                                    'value_num' => $val_numeric);
                
                /* [property_lang] */
                $data_property_lang[$language_id]['language_id']=intval($language_id);
                $data_property_lang[$language_id]['property_id']=intval($id);
                $data_property_lang[$language_id]['json_object']['field_'.$option_id] = $value;
                
                if (isset($fields['field_'.$option_id]))
                {
                    $data_property_lang[$language_id]['field_'.$option_id]=$value;
                } 
                
                if(strtotime($value) && isset($fields['field_'.$option_id.'_int']))
                {
                    $data_property_lang[$language_id]['field_'.$option_id.'_int'] = $value;
                }
                elseif(is_numeric($val_numeric) && isset($fields['field_'.$option_id.'_int']))
                {
                    $data_property_lang[$language_id]['field_'.$option_id.'_int'] = floatval($val_numeric);
                }
                /* [/property_lang] */
                
                $field_data = $this->option_m->get_field_data($option_id, $language_id);
                
                if($value != 'SKIP_ON_EMPTY')
                    $insert_batch[] = $insert_arr;
                
                if(config_item('multilang_on_qs') == 0 && $this->uri->segment(1) == 'fquick')
                {
                    if($language_id == $this->language_m->get_default_id())
                    {
                        // populate $data_property_lang for other langauges
                        foreach($this->option_m->languages as $ch_lang_id=>$val_lang)
                        {
                            if($language_id != $ch_lang_id)
                            {
                                if($field_data->type == 'DROPDOWN' || $field_data->type == 'DROPDOWN_MULTIPLE')
                                {
                                    $vals = explode(',',$field_data->values);
                                    $index = array_search($value, $vals);
                                    
                                    if($index !== FALSE)
                                    {
                                        $field_data_cus = $this->option_m->get_field_data($option_id, $ch_lang_id);
                                        $field_data_cus->values;
                                        $vals = explode(',',$field_data_cus->values);
                                        
                                        if(!isset($vals[$index]))break;
        
                                        $value_custom = $vals[$index];
                                        
                                        $data_property_lang[$ch_lang_id]['language_id']=    intval($ch_lang_id);
                                        $data_property_lang[$ch_lang_id]['property_id']=    intval($id);
                                        $data_property_lang[$ch_lang_id]['json_object']['field_'.$option_id] = $value_custom;
                                        
                                        if (isset($fields['field_'.$option_id]))
                                        {
                                            $data_property_lang[$ch_lang_id]['field_'.$option_id]=$value_custom;
                                        } 
                                        
                                        if(is_numeric($val_numeric) && isset($fields['field_'.$option_id.'_int']))
                                        {
                                            $data_property_lang[$ch_lang_id]['field_'.$option_id.'_int'] = floatval($val_numeric);
                                        }
                                        
        //                                if($option_id == 10)
        //                                    dump($data_property_lang);
                                            
                                        $insert_arr_2 = array(  'language_id' => intval($ch_lang_id),
                                                                'property_id' => intval($id),
                                                                'option_id' => intval($option_id),
                                                                'value' => $value_custom,
                                                                'value_num' => $val_numeric);
                                    }
                                    
                                }
                                else
                                {
                                    // transplate $value
                                    // Fix value if HTML errors exists:
                                    if(!empty($value)){
                                        if(function_exists('tidy'))
                                        {
                                            $tidy = new tidy();
                                            $value = $tidy->repairString($value);
                                        }

                                        $value = $this->mymemorytranslation->translate($value, $this->language_m->db_languages_id[$language_id], $this->language_m->db_languages_id[$ch_lang_id]);
                                    }                                    
                                    // End transplate $value
                                            
                                    $data_property_lang[$ch_lang_id]['language_id']=    intval($ch_lang_id);
                                    $data_property_lang[$ch_lang_id]['property_id']=    intval($id);
                                    $data_property_lang[$ch_lang_id]['json_object']['field_'.$option_id] = $value;
                                    
                                    if (isset($fields['field_'.$option_id]))
                                    {
                                        $data_property_lang[$ch_lang_id]['field_'.$option_id]=$value;
                                    } 
                                    
                                    if(is_numeric($val_numeric) && isset($fields['field_'.$option_id.'_int']))
                                    {
                                        $data_property_lang[$ch_lang_id]['field_'.$option_id.'_int'] = floatval($val_numeric);
                                    }
                                    
    //                                if($option_id == 10)
    //                                    dump($data_property_lang);
                                        
                                    $insert_arr_2 = array(  'language_id' => intval($ch_lang_id),
                                                            'property_id' => intval($id),
                                                            'option_id' => intval($option_id),
                                                            'value' => $value,
                                                            'value_num' => $val_numeric);
                                }
                                    
                                if($value != 'SKIP_ON_EMPTY')
                                    $insert_batch[] = $insert_arr_2;
                            }
                        }
                    }
                }
            }
        }
        
        //dump($insert_batch);
//        exit();
        
        if(count($insert_batch) > 0)
            $this->db->insert_batch('property_value', $insert_batch);
            
            
        //echo $this->db->last_query();
        //exit();
        
        if($this->db->_error_message() != '')
        {
            echo 'QUERY: '.$this->db->last_query();
            echo '<br />';
            echo 'ERROR: '.$this->db->_error_message();
            exit();
        }

        // Delete all users
        if(!empty($data['agent']))
        {
            $this->db->where('property_id', $id);
            $this->db->delete('property_user'); 
            $this->db->set(array('property_id'=>$id,
                                 'user_id'=>$data['agent']));
            $this->db->insert('property_user');
        }
        /* [property_lang] */
        foreach($data_property_lang as $lang_id =>$property_data)
        {
            foreach($fields as $key_field=>$val_field)
            {
                if(!isset($data_property_lang[$lang_id][$key_field]))
                    $data_property_lang[$lang_id][$key_field] = NULL;
            }
            
            $data_property_lang[$lang_id]['json_object'] = 
                json_encode($data_property_lang[$lang_id]['json_object'], JSON_UNESCAPED_UNICODE);
        }
        
        if(count($data_property_lang) > 0)
        {
            if($run_delete)
            {
                $this->db->delete('property_lang', array('property_id' => $id)); 
            }
            
            //dump($data_property_lang);
            
            $this->db->insert_batch('property_lang', $data_property_lang); 
            
            //echo $this->db->last_query();
            //exit();
        }
        /* [/property_lang] */
        
        // if cache is enabled delete all db caches
        $this->db->cache_delete_all();
    }
    
    public function get_field_from_listing($listing, $field_id)
    {
        if(isset($listing->{"field_$field_id"}))
        {
            return $listing->{"field_$field_id"};
        }
        else
        {
            $json_obj = json_decode($listing->json_object);
            if(isset($json_obj->{"field_$field_id"}))
                return $json_obj->{"field_$field_id"};
        }
        
        return '';
    }
    
    public function delete($id)
    {
        $estate_data = $this->get($id, TRUE);
        
        // [Feature related to removed_reports_enabled]
        if(isset($this->session))
        if(config_item('removed_reports_enabled') === TRUE &&
           count($estate_data) && 
           $this->session->userdata('type') == 'USER' &&
           $estate_data->is_activated == 1)
        {
            $this->load->model('removedlistings_m');
            $estate_dyn = $this->estate_m->get_dynamic_array($id);
            
            $data = array();
            $data['date_removed'] = date('Y-m-d H:i:s');
            $data['submission_date'] = $estate_data->date;
            $data['expire_date'] = date('Y-m-d H:i:s', strtotime($estate_data->date_modified)+($this->data['settings']['listing_expiry_days'])*86400);
            $data['address'] = $estate_data->address;
            $data['lat'] = $estate_data->lat;;
            $data['lng'] = $estate_data->lng;
            $data['price_0'] = '';
            $data['price_1'] = '';
            $data['price_2'] = '';
            
            if(!empty($estate_dyn["option36_1"]))
            {
                $data['price_0'] = get_numeric_val($estate_dyn["option36_1"]);
            }
            
            if(!empty($estate_dyn["option36_2"]))
            {
                $data['price_1'] = get_numeric_val($estate_dyn["option36_2"]);
            }
            
            if(!empty($estate_dyn["option36_3"]))
            {
                $data['price_2'] = get_numeric_val($estate_dyn["option36_3"]);
            }
            
            $this->removedlistings_m->save($data);
        }
        // [/Feature related to removed_reports_enabled]

        // Delete all options
        $this->db->where('property_id', $id);
        $this->db->delete('property_value'); 
        
        $this->db->where('property_id', $id);
        $this->db->delete('property_lang'); 
        
        $this->db->where('property_id', $id);
        $this->db->delete('enquire'); 
        
        $this->db->where('property_id', $id);
        $this->db->delete('property_user'); 
        
        $this->db->where('property_id', $id);
        $this->db->delete('reservaions');
        
        $this->db->where('property_id', $id);
        $this->db->delete('favorites');
        
        $this->db->where('property_id', $id);
        $this->db->delete('trates'); 
        
        // [START] remove rates
        $query = $this->db->get_where('rates', array('property_id' => $id));
        if ($query->num_rows() > 0)
        {
            $row = $query->row();
            $this->db->where('rates_id', $row->id);
            $this->db->delete('rates_lang'); 
        } 
        $this->db->where('property_id', $id);
        $this->db->delete('rates'); 
        // [END] remove rates
        
        // Remove repository
        if(count($estate_data))
        {
            $this->load->model('repository_m');	
            $this->load->model('file_m');	
            $this->repository_m->delete($estate_data->repository_id);
        }
        
        parent::delete($id);
    }
    
    public function get_sitemap()
	{
        // Fetch pages without parents
        $this->db->select('*');
        //$this->db->join($this->_table_name.'_lang', $this->_table_name.'.id = '.$this->_table_name.'_lang.page_id');
        $estates = parent::get_by(array('is_activated'=>1));
                
        return $estates;
	}
    
    public function check_user_permission($property_id, $user_id)
    {
        if($this->session->userdata('type') == 'ADMIN')return 1;
        
        $this->db->select('*');
        $this->db->from('property_user');
        $this->db->where('property_id', $property_id);
        
        // [AGENCY AGENT]
        if(config_db_item('agency_agent_enabled') === TRUE)
        {
            $this->db->join('user', 'property_user.user_id = user.id', 'left');
            $this->db->where('(user_id = '.$user_id.' OR agency_id = '.$user_id.')', NULL);
        }
        else
        {
            $this->db->where('user_id', $user_id);
        }
        // [/AGENCY AGENT]
        
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    public function get_user_properties($user_id)
    {
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('property_user');
        
        $properties = array();
        foreach ($query->result() as $row)
        {
          $properties[] = $row->property_id;
        }
        
        return $properties;
    }
    
    public function get_user_id($property_id)
    {
        $this->db->where('property_id', $property_id);
        $query = $this->db->get('property_user', 1);
        
        if ($query->num_rows() > 0)
        {
           $row = $query->row();
           return $row->user_id;
        } 
        
        return NULL;
    }
    
    public function get_similar($address, $lat, $lng, $other=array(), $exlude_id=0)
    {
        $expire_days = $this->settings_m->get_field('listing_expiry_days');
        
        $this->db->select('property.*');
        $this->db->from($this->_table_name);        
        $this->db->where('address LIKE', "%$address%");
        if(!empty($expire_days))
            $this->db->where('property.date_modified >', date("Y-m-d H:i:s" , time()-$expire_days*86400));
        if(count($other) > 0)
            $this->db->where($other);
        $this->db->where('property.id !='.$exlude_id);
        $this->db->or_where("(property.lat = $lat AND property.lng = $lng AND property.id != $exlude_id)");
        $this->db->order_by($this->_table_name.'.id DESC');
        $query = $this->db->get();
        
        if ($query->num_rows() > 0)
        {
           return $query->result();
        }
        
        return NULL;
    }
    
    public function get_similar_expired($address, $lat, $lng, $other=array(), $exlude_id=0)
    {
        $expire_days = $this->settings_m->get_field('listing_expiry_days');
        if(empty($expire_days)) return NULL;
        
        $this->db->select('property.*, user.mail');
        $this->db->from($this->_table_name);
        $this->db->join('property_user', $this->_table_name.'.id = property_user.property_id', 'left');  
        $this->db->join('user', 'property_user.user_id = user.id', 'left');     
        $this->db->where('property.address LIKE', "%$address%");
        $this->db->where('property.date_modified <', date("Y-m-d H:i:s" , time()-$expire_days*86400));
        $this->db->where('property.id !='.$exlude_id);
        $this->db->or_where("(property.lat = $lat AND property.lng = $lng AND property.id != $exlude_id)");

        $this->db->order_by($this->_table_name.'.id DESC');
        $query = $this->db->get();
        
        if ($query->num_rows() > 0)
        {
           return $query->result();
        }
        
        return NULL;
    }
    
    
    public function get_all_counters($lang_id, $all_ids, $search_params)
    {
        // get all cached fields
        $fields = $this->db->list_fields('property_lang');
        $fields = array_flip($fields);
        
        // Example:
        // SELECT option_id, COUNT(*) as count FROM `property_value` WHERE option_id IN (23,33) AND value = 'true' GROUP BY option_id

        $this->db->select('option_id, COUNT(*) as count');
        $this->db->from('property_value');
        $this->db->join($this->_table_name.'_lang', 'property_value.property_id = '.$this->_table_name.'_lang.property_id');
        $this->db->join($this->_table_name, 'property_value.property_id = '.$this->_table_name.'.id');
        $this->db->where('value', 'true'); 
        $this->db->where('property_value.language_id', $lang_id); 
        $this->db->where($this->_table_name.'_lang.language_id', $lang_id);
        $this->db->where_in('option_id', $all_ids);
        
        
        $search_array = $search_params;
        
        unset($search_array['v_rectangle_ne'], $search_array['v_undefined'],
              $search_array['v_rectangle_sw'], $search_array['v_search-start'],
              $search_array['v_search_radius']);
        
        $where = array();
        $settings_listing_expiry_days = $this->settings_m->get_field('listing_expiry_days');;
        if(isset($settings_listing_expiry_days))
        {
            if(is_numeric($settings_listing_expiry_days) && $settings_listing_expiry_days > 0)
            {
                 $where['property.date_modified >']  = date("Y-m-d H:i:s" , time()-$settings_listing_expiry_days*86400);
            }
        }
        
        $this->db->where($where); 
        
        if(is_array($search_array) && count($search_array) > 0)
        {
            foreach($search_array as $key=>$val)
            {
                $parts = explode('_', $key);

                if(isset($parts[3]) && is_numeric($parts[3]))
                    $option_id = $parts[3];
                else $parts[3] = 'NULL';
                
                if($key == 'view')
                {
                    
                }
                else if($key == 'order')
                {
                    //$order_by = "`property`.`is_featured` DESC, `property`.$val";
                }
                else if($key == 'page_num')
                {

                }
                else if($key == 'search_option_smart' ||
                   $key == 'v_search_option_smart' || 
                    $key == 'v_search_option_quick')
                {
// Commented because numeric search should also work for zip code
//                    if(is_numeric($val))
//                    {
//                        $this->db->where('property.id', $val);
//                    }
//                    else 
                    if($val != "")
                    {
                        if(config_item('smart_search_disabled') === TRUE)
                        {
                            /* 
                               This method requre field_10 and field_64 
                               columns in database property_lang table
                            */
                            
                            $this->db->where("(property.id = '$val' OR ".
                                             "field_10 LIKE '%$val%' OR ".
                                             "field_64 LIKE '%$val%')");
                        }
                        else
                        {
                            $this->db->where("(property.id = '$val' OR property.address LIKE '%$val%' OR search_values LIKE '%$val%')");
                        }
                    }
                }
                else if(strrpos($key, 'from') > 0 && isset($fields['field_'.$option_id.'_int']) && (is_numeric($val) || $options[$option_id]->type == 'DATETIME'))
                {
                    if(isset($fields['field_'.$option_id.'_int']))
                    {
                        if(is_numeric($val))    
                            $val = intval($val);
                        $this->db->where("(".'field_'.$option_id.'_int'." >= '$val')");
                    }
                }
                else if(strrpos($key, 'to') > 0 && isset($fields['field_'.$option_id.'_int']) && (is_numeric($val) || $options[$option_id]->type == 'DATETIME'))
                {
                    if(isset($fields['field_'.$option_id.'_int']))
                    {
                        if(is_numeric($val))    
                            $val = intval($val);
                            
                        $this->db->where("(".'field_'.$option_id.'_int'." <= '$val')");
                    }
                }
                
                else if(strrpos($key, 'multi') > 0)
                {
                    if(is_array($val) && !empty($val)){
                    $query ='(';
                        foreach ($val as $key => $val_parse) {
                            if($key !=0) $query.=' OR ';
                            if(!empty($val_parse))
                                $query .="(json_object LIKE '%\"field_$option_id\":\"$val_parse\"%')";
                        }
                    $query .=')';
                    $this->db->where($query);
                    }
                }
                
                else if(strrpos($key, 'search_option') > 0 && isset($fields['field_'.$option_id]) /*&& $option_id != 4*/ && $val != "" && $options[$option_id]->type != 'TREE')
                {
                    if(isset($fields['field_'.$option_id]))
                    {
                        $this->db->where('field_'.$option_id, $val);
                    }
                }
                else if(strrpos($key, 'rectangle') > 0)
                {
                    
                }
                else if(is_numeric($val) && isset($option_id))
                {
                    //$this->db->where("(search_values LIKE '% $val %')");
                    $this->db->where("(json_object LIKE '%\"field_$option_id\":\"$val\"%')");
                }
                else if($val && isset($option_id))
                {
                    if(substr($val,0,4) == 'true')
                       $val='true';
                    
                    if(isset($options[$option_id]) && $options[$option_id]->type == 'TREE') 
                        $this->db->where("(json_object LIKE '%\"field_$option_id\":\"".trim($val)."%')");
                    else 
                        $this->db->where("(json_object LIKE '%\"field_$option_id\":\"".trim($val)."\"%')");

                }
                else if($val != "")
                {
                    $this->db->where("(search_values LIKE '%$val%')");
                }
            }
        }
        
        
        
        $this->db->group_by("option_id"); 

        $query = $this->db->get();
        
        if(!is_object($query))
            echo $this->db->last_query();
        
        if ($query->num_rows() > 0)
        {
           return $query->result();
        } 
        
        return array();
    }
    

    
    public function change_activated_properties($property_ids = array(), $is_activated)
    {
        $data = array(
                       'is_activated' => $is_activated
                    );
        
        $this->db->where_in('id', $property_ids);
        $this->db->update($this->_table_name, $data); 
    }

}



