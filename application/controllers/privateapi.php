<?php

class Privateapi extends CI_Controller
{
   
   private $user_id = NULL;
   
   private $data = array();
   
   private $settings = array();
    
   public function __construct()
   {
        parent::__construct();
        
        header('Content-Type: application/json');
        
        //load settings
        $this->load->model('settings_m');
        $this->settings = $this->settings_m->get_fields();
        
        //load language files
        $this->load->model('language_m');
        $lang_code_uri = $this->uri->segment(3);
        $lang_name = $this->language_m->get_name($lang_code_uri);
        if($lang_name != NULL)
            $this->lang->load('frontend_template', $lang_name, FALSE, TRUE, FCPATH.'templates/'.$this->settings['template'].'/');
        
        // Check login and fetch user id
        $this->load->library('session');
        $this->load->model('user_m');
        if($this->user_m->loggedin() == TRUE)
        {
            $this->user_id = $this->session->userdata('id');
        }
        else
        {
            $this->data['message'] = lang_check('Login required!');
            $this->data['success'] = false;
            echo json_encode($this->data);
            exit();
        }
   }

	public function index()
	{
		$this->data['message'] = lang_check('Hello, Private API here!');
        echo json_encode($this->data);
        exit();
	}
    
    public function design_save($lang_code='')
    {
        $this->data['message'] = lang_check('No message returned!');
        $this->data['parameters'] = $_POST;
        // To fetch user_id use: $this->user_id

        $this->load->model('settings_m');
        
        $this->data['success'] = false;
        
        if($this->session->userdata('type') == 'ADMIN')
        {
            if(isset($this->data['parameters']['design_parameters']))
            {
                $post_data = array('design_parameters' => $this->data['parameters']['design_parameters'],
                                   'css_variant' => $this->data['parameters']['css_variant'],
                                   'color' => $this->data['parameters']['color']);
                $this->settings_m->save_settings($post_data);
                $this->session->set_userdata( array('color'=>$this->data['parameters']['color']));
                $this->data['message'] = lang_check('Changes saved!');
                $this->data['success'] = true;
            }
            else
            {
                $this->data['message'] = lang_check('Parameters not defined!');
                $this->data['success'] = true;
            }
        }
        
        echo json_encode($this->data);
        exit();
    }
    
    public function add_to_favorites($lang_code='')
    {
        $this->data['message'] = lang_check('No message returned!');
        $this->data['parameters'] = $_POST;
        $property_id = $this->input->post('property_id');
        // To fetch user_id use: $this->user_id

        $this->load->model('favorites_m');
        
        $this->data['success'] = false;
        // Check if property_id already saved, stop and write message
        if($this->favorites_m->check_if_exists($this->user_id, $property_id)>0)
        {
            $this->data['message'] = lang_check('Favorite already exists!');
            $this->data['success'] = true;
        }
        // Save favorites to database
        else
        {
            $data = $this->favorites_m->get_new_array();
            $data['user_id'] = $this->user_id;
            $data['property_id'] = $property_id;
            $data['lang_code'] = $lang_code;
            $data['date_last_informed'] = date('Y-m-d H:i:s');
            
            $this->favorites_m->save($data);
            
            $this->data['message'] = lang_check('Favorite added!');
            $this->data['success'] = true;
        }
        
        echo json_encode($this->data);
        exit();
    }
    
    public function remove_from_favorites($lang_code='')
    {
        $this->data['message'] = lang_check('No message returned!');
        $this->data['parameters'] = $_POST;
        $property_id = $this->input->post('property_id');
        // To fetch user_id use: $this->user_id

        $this->load->model('favorites_m');
        
        $this->data['success'] = false;
        // Check if property_id already saved, stop and write message
        if($this->favorites_m->check_if_exists($this->user_id, $property_id)>0)
        {
            $favorite_selected = $this->favorites_m->get_by(array('property_id'=>$property_id, 'user_id'=>$this->user_id), TRUE);
            $this->favorites_m->delete($favorite_selected->id);
            
            $this->data['message'] = lang_check('Favorite removed!');
            $this->data['success'] = true;
        }
        // Save favorites to database
        else
        {
            $this->data['message'] = lang_check('Favorite doesnt exists!');
            $this->data['success'] = true;
        }
        
        echo json_encode($this->data);
        exit();
    }
    
    public function check_favorites($lang_code='')
    {
        $this->data['message'] = lang_check('No message returned!');
        $this->data['parameters'] = $_POST;
        $property_id = $this->input->post('property_id');
        // To fetch user_id use: $this->user_id

        $this->load->model('favorites_m');
        
        $this->data['success'] = false;
        if($this->favorites_m->check_if_exists($this->user_id, $property_id)>0)
        {
            $this->data['message'] = lang_check('Favorite exists!');
            $this->data['success'] = false;
        }
        else
        {
            $this->data['message'] = lang_check('Favorite doesnt exists!');
            $this->data['success'] = true;
        }
        
        echo json_encode($this->data);
        exit();
    }
    
    public function dropdown($table)
    {
        $this->data['message'] = lang_check('No message returned!');
        $this->data['parameters'] = $_POST;
        // To fetch user_id use: $this->user_id

        $this->data['success'] = false;
        
        if(empty($this->data['parameters']['limit']))
            $this->data['parameters']['limit'] = 10;
            
        if(empty($this->data['parameters']['offset']))
            $this->data['parameters']['offset'] = 0;
            
        if(empty($this->data['parameters']['attribute_id']))
            $this->data['parameters']['attribute_id'] = 'id';
            
        if(empty($this->data['parameters']['show_empty']))
            $this->data['parameters']['show_empty'] = false;
            
        if(empty($this->data['parameters']['attribute_value']))
            $this->data['parameters']['attribute_value'] = 'address';
        
        if(substr($table,-2, 2) == '_m')
        {
            // it's model
            $attr_id = $this->data['parameters']['attribute_id'];
            $attr_val = $this->data['parameters']['attribute_value'];
            $attr_search = $this->data['parameters']['search_term'];
            
            $id_part="";
            if(is_numeric($attr_search))
                $id_part = "$attr_id=$attr_search OR ";
            
            $this->load->model($table);
            
            $where = array();
            if(!empty($this->data['parameters']['language_id']))
                $where["language_id"] = $this->data['parameters']['language_id'];
            
            if(!empty($attr_search))
                $where["($id_part $attr_val LIKE '%$attr_search%')"] = NULL;
            
            //get_by($where, $single = FALSE, $limit = NULL, $order_by = NULL, $offset = NULL, 
            //$search = array(), $where_in = NULL, $check_user = FALSE, $fetch_user_details=FALSE)
            if($table == 'estate_m')
            {
                $q_results = $this->$table->get_by($where, FALSE, $this->data['parameters']['limit'], 
                                                    "$attr_id DESC", $this->data['parameters']['offset'],
                                                    array(), NULL, TRUE);
            }
            else
            {
                $q_results = $this->$table->get_by($where, FALSE, $this->data['parameters']['limit'], 
                                                    "$attr_id DESC", $this->data['parameters']['offset']);
            }
            
            $results = array();
            
            if($this->data['parameters']['show_empty'] == true && $this->data['parameters']['offset'] == 0)
            {
                $results[-1]['key'] = '';
                $results[-1]['value'] = '-';
            }
            
            foreach ($q_results as $key=>$row)
            {
                $results[$key]['key'] = $row->id;
                $results[$key]['value'] = $row->{$this->data['parameters']['attribute_id']}.', '.
                                            _ch($row->{$this->data['parameters']['attribute_value']});
            }
            
            // get current value by ID
            $row = $this->$table->get($this->data['parameters']['curr_id']);
            if(is_object($row))
            {
                $this->data['curr_val'] = $row->{$this->data['parameters']['attribute_id']}.', '.
                                                _ch($row->{$this->data['parameters']['attribute_value']});
            }
            else
            {
                $this->data['curr_val'] = '-';
            }
            
            $this->data['success'] = true;
        }
        else
        {
            // it's table
            if($this->session->userdata('type') == 'ADMIN')
            {
                if(!empty($this->data['parameters']['search_term']))
                {
                    $attr_id = $this->data['parameters']['attribute_id'];
                    $attr_val = $this->data['parameters']['attribute_value'];
                    $attr_search = $this->data['parameters']['search_term'];
                    
                    $id_part="";
                    if(is_numeric($attr_search))
                        $id_part = "$attr_id=$attr_search OR ";
                    
                    $this->db->where("($id_part $attr_val LIKE '%$attr_search%')", NULL, FALSE);
                }
                
                $this->db->order_by("id desc"); 
                $query = $this->db->get($table, $this->data['parameters']['limit'], $this->data['parameters']['offset']);
                
                $results = array();
                foreach ($query->result() as $key=>$row)
                {
                    $results[$key]['key'] = $row->id;
                    $results[$key]['value'] = $row->{$this->data['parameters']['attribute_id']}.', '.
                                                _ch($row->{$this->data['parameters']['attribute_value']});
                }
                
                // get current value by ID
                $this->db->where("id", $this->data['parameters']['curr_id']); 
                $query = $this->db->get($table, 1);
                $row = $query->row();
                if(!empty($row))
                {
                    $this->data['curr_val'] = $row->{$this->data['parameters']['attribute_id']}.', '.
                                                    _ch($row->{$this->data['parameters']['attribute_value']});
                }
                else
                {
                    $this->data['curr_val'] = '-';
                }
                
                $this->data['success'] = true;
            }
            else
            {
                $this->data['success'] = false;
            }
        }
        
        $this->data['results'] = $results;
        
        echo json_encode($this->data);
        exit();
    }

    public function save_search($lang_code='')
    {
        $this->data['message'] = lang_check('No message returned!');
        
        if(count($_POST > 0))
        {
            // [START] Radius search
            $search_radius = $_POST['v_search_radius'];
            if(isset($search_radius) && isset($_POST['v_search_option_smart']) && $search_radius > 0)
            {
                $this->load->library('ghelper');
                $coordinates_center = $this->ghelper->getCoordinates($search_array['v_search_option_smart']);
                
                if(count($coordinates_center) >= 2 && $coordinates_center['lat'] != 0)
                {
                    // calculate rectangle
                    $rectangle_ne = $this->ghelper->getDueCoords($coordinates_center['lat'], $coordinates_center['lng'], 315, $search_radius);
                    $rectangle_sw = $this->ghelper->getDueCoords($coordinates_center['lat'], $coordinates_center['lng'], 135, $search_radius);
                    
                    $_POST['v_rectangle_ne'] = $rectangle_ne;
                    $_POST['v_rectangle_sw'] = $rectangle_sw;
                    unset($_POST['v_search_option_smart'], $_POST['v_undefined'], $_POST['v_search_radius']);
                }
            }
            // [END] Radius search
        }

        $this->data['parameters'] = $_POST;
        $parameters = json_encode($_POST);
        // To fetch user_id use: $this->user_id
        
        $this->load->model('savedsearch_m');
        
        // Check if parameters already saved, stop and write message
        if($this->savedsearch_m->check_if_exists($this->user_id, $parameters, $lang_code)>0)
        {
            $this->data['message'] = lang_check('Search already exists!');
        }
        // Save parameters to database
        else
        {
            $data = $this->savedsearch_m->get_new_array();
            $data['user_id'] = $this->user_id;
            $data['parameters'] = $parameters;
            $data['lang_code'] = $lang_code;
            
            // Check if there is some parameters
            $values_exists = false;
            foreach($this->data['parameters'] as $key=>$value){
                if(!empty($value) && $key != 'view' && $key != 'order' && 
                    $key != 'page_num' && $key != 'v_search-start')
                $values_exists = true;
            }
            
            if(!$values_exists)
            {
                $this->data['message'] = lang_check('No values selected!');
                echo json_encode($this->data);
                exit();
            }
            
            $this->savedsearch_m->save($data);
            
            $this->data['message'] = lang_check('Search saved!');
        }
        
        echo json_encode($this->data);
        exit();
    }
    
    public function get_level_values_select($lang_id, $field_id, $parent_id=0, $level=0)
    {
        $this->data['message'] = lang_check('No message returned!');
        $this->data['parameters'] = $_POST;
        $parameters = json_encode($_POST);
        // To fetch user_id use: $this->user_id
        
        $this->load->model('language_m');
        $this->load->model('treefield_m');

        $lang_name = $this->session->userdata('lang');
        if(!empty($lang_id))
            $lang_name = $this->language_m->get_name($lang_id);
            
        $this->lang->load('backend_base', $lang_name);
        
        $values_arr = $this->treefield_m->get_level_values ($lang_id, $field_id, $parent_id, $level);
        
        $generate_select = '';
        foreach($values_arr as $key=>$value)
        {
            $generate_select.= "<option value=\"$key\">$value</option>\n";
        }
        
        $this->data['generate_select'] = $generate_select;
        $this->data['values_arr'] = $values_arr;
        
        echo json_encode($this->data);
        exit();
    }
    
    public function load_reservations($property_id)
    {
        $this->data['message'] = lang_check('No message returned!');
        $this->data['parameters'] = $_POST;
        $parameters = json_encode($_POST);
        // To fetch user_id use: $this->user_id
        
        $this->load->model('reservations_m');
        
        $existing_dates = array();
        $query = $this->db->get_where('reservations', array('property_id' => $property_id, 'date_to >' => date('Y-m-d 00:00:00')));
        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
            {
                /* [get days] */
                $days_between = $this->reservations_m->days_between($row->date_from, $row->date_to);
                
                $days = array();
                for($i=0; $i < $days_between;  $i++)
                {
                    $row_time = strtotime($row->date_from." + $i day");
                    $row_time_00 = date("Y-m-d", $row_time);
                    $existing_dates[$row_time_00] = $row_time_00;
                }
                /* [/get days] */
            }
        }
        
        $this->data['existing_dates'] = $existing_dates;     

        echo json_encode($this->data);
        exit();
    }
    
    public function property_exists($lang_code='')
    {
        $this->load->model('estate_m');
        $this->load->model('removedlistings_m');
        
        $this->data['message'] = lang_check('No message returned!');
        $this->data['parameters'] = $_POST;
        // To fetch user_id use: $this->user_id

        $this->load->model('settings_m');
        
        $this->data['success'] = false;
        $this->data['exists'] = true;
        $this->data['removed'] = true;
        $this->data['removed_list'] = array();
        
        if(empty($this->data['parameters']['address']) || empty($this->data['parameters']['gps']))
        {}
        else
        {
            $address = $this->data['parameters']['address'];
            $gps = explode(', ', $this->data['parameters']['gps']);
            $lat = floatval($gps[0]);
            $lng = floatval($gps[1]);
            
            $id=0;
            if(isset($this->data['parameters']['id']))
                $id = $this->data['parameters']['id'];
            
            $listings_similar = $this->estate_m->get_similar($address, $lat, $lng, array(), $id);
            //$this->data['similar_query'] = $this->db->last_query();
            
            $listings_removed = $this->removedlistings_m->get_similar($address, $lat, $lng, array());

            if($listings_similar === NULL)
            {
                $this->data['exists'] = false;
            }
            
            if($listings_removed === NULL)
            {
                $this->data['removed'] = false;
            }
            else
            {
                $this->data['removed_list'] = $listings_removed;
            }
            
            if($listings_similar === NULL && $listings_removed === NULL)
                $this->data['success']=TRUE;
            
        }

        echo json_encode($this->data);
        exit();
    }
    

    function parse_svg_map($file_name= NULL) {
        if($file_name == NULL) return false;
            
        // Fetch settings
        $this->load->model('settings_m');
        $settings= $this->settings_m->get_fields();
        
        $this->data = array();
        $this->data['success'] = false;
        $region_names = array();
        
        if(file_exists(FCPATH.'templates/'.$settings['template'].'/assets/svg_maps/'.$file_name)){
            $svg = file_get_contents(FCPATH.'templates/'.$settings['template'].'/assets/svg_maps/'.$file_name);
            $region_names = array();
            $match = '';
            preg_match_all('/(data-title-map)=("[^"]*")/i', $svg, $match);

            if(!empty($match[2])) {
                preg_match_all('/(data-name)=("[^"]*")/i', $svg, $matches);
                if(!empty($matches[2]))
                    foreach ($matches[2] as $value) {
                       $value = str_replace('"', '', $value);                       
                        $region_names[] = $value;
                    }
            } else if(stristr($svg, "http://amcharts.com/ammap") != FALSE ) {
                preg_match_all('/(title)=("[^"]*")/i', $svg, $matches);
                if(!empty($matches[2]))
                    foreach ($matches[2] as $value) {
                       $value = str_replace('"', '', $value);                       
                        $region_names[] = $value;
                    }
            }   
            
            $match = '';
            $this->data['title_map']='';
            preg_match_all('/(data-title-map)=("[^"]*")/i', $svg, $match);

            if(!empty($match[2])) {
               $this->data['title_map'] = str_replace('"', '', $match[2][0]);
            }
                
                
          $this->data['success'] = true; 
          $this->data['region_names'] = $region_names;
        }    
        
        
        echo json_encode($this->data);
        exit();        
    }
    
    /*
     * For Eventful lib
     * return count_pages
     */
    function eventful_get_count_pages($eventful_category = NULL){
        $this->data['success'] = false; 
        
        $post= $_POST;
        
        
        if(empty($post['eventful_category']))  {
            echo json_encode($this->data);
            exit();      
        }
        
        if(!file_exists(APPPATH.'libraries/Eventful.php') || $this->session->userdata('type')!='ADMIN') {
            echo json_encode($this->data);
            exit(); 
        }
        
        $this->load->library('eventful');
        $result = $this->eventful->get_count_pages($post['eventful_category'],250, $post['location']);
        if($result != FALSE) {
            $this->data['success'] = true; 
            $this->data['eventful_get_count_pages'] = $result; 
            echo json_encode($this->data);
            exit();  
        } else {
            echo json_encode($this->data);
            exit();
        }
    }
    
    /*
     * For Eventful lib
     * return count_pages
     */
    function eventbrite_get_count_pages($eventful_category = NULL){
        $this->data['success'] = false; 
        
        $post= $_POST;
        
        $event_keyword = _ch($post['event_keyword'],'');
        $category = _ch($post['category'],'');
        $location = _ch($post['location'],'');
        $date_start = _ch($post['date_start'],'');
        $date_end = _ch($post['date_end'],'');
        
        if(!file_exists(APPPATH.'libraries/Eventbrite.php')) {
            echo json_encode($this->data);
            exit(); 
        }
        
        $this->load->library('eventbrite');
        $result = $this->eventbrite->get_count_pages($event_keyword, $category, $location, $date_start,$date_end);
        if($result != FALSE) {
            $this->data['success'] = true; 
            $this->data['eventful_get_count_pages'] = $result; 
            echo json_encode($this->data);
            exit();  
        } else {
            echo json_encode($this->data);
            exit();
        }
    }
    
    
    /*
     * For Eventful lib
     * return count_pages
     */
    function send_review($listing_id = NULL){
        $this->data['success'] = false; 
        if($listing_id == NULL)  {
            echo json_encode($this->data);
            exit();      
        }
        
        $post = $_POST;
        
        $this->load->model('reviews_m');
        $this->load->library('form_validation');  
        
        {
            /* Validation for reviews */
            
            $this->form_validation->set_rules($this->reviews_m->rules);
            
            // Process the form
            if($this->form_validation->run() == TRUE)
            {
                $data_review = $this->reviews_m->array_from_post(array('stars', 'message'));
                
                // Save reviews to database
                $data = array();
                $data['listing_id'] = $listing_id;
                $data['user_id'] = $this->session->userdata('id');
                $data['stars'] = $data_review['stars'];
                $data['message'] = $data_review['message'];
                $data['is_visible'] = 1;
                $data['date_publish'] = date('Y-m-d H:i:s');
                
                if($this->reviews_m->check_if_exists($data['user_id'], $data['listing_id']) == 0 ) {
                    $this->data['message'] = lang_check('Thanks on review'); 
                    $this->reviews_m->save($data);
                } else {
                    $this->data['message'] = lang_check('You already have review on this event'); 
                }
            }
            
            //$this->data['reviews_validation_errors'] = validation_errors();

            /* End Validation for reviews */
        }
        
        
            $this->data['success'] = true; 
            echo json_encode($this->data);
            exit();
    }
    
    public function favorites_exists_check($lang_code='')
    {
        $this->data['message'] = '';
        $this->data['parameters'] = $_POST;
        // To fetch user_id use: $this->user_id

        $this->load->model('favorites_m');
        $this->data['success'] = false;
        $favorites_list = $this->favorites_m->get_by(array('user_id'=>$this->session->userdata('id')));
        
        if($favorites_list && count($favorites_list) > 0)
        {
            $this->data['success'] = true;
        }
        else
        {
            $this->data['message'] = lang_check('No events in favourites, please add');
            $this->data['success'] = false;
        }
        
        echo json_encode($this->data);
        exit();
    }
    
    public function attend_near_favorites($lang_id='1')
    {
        $this->data['message'] = '';
        $this->data['parameters'] = $_POST;
        $this->data['success'] = false;

        $this->load->model('favorites_m');
        $this->load->model('userattend_m');
        

        $ip = $_SERVER['REMOTE_ADDR'];
        //$ip = "178.218.79.27";

        $query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
        if($query && $query['status'] == 'success') {
            $lat = $query['lat'];
            $lng = $query['lon'];
            $this->load->model('estate_m');
            $search_array = array();
            $search_array['v_search_option_location'] = $query ['city']. ", ".$query['country'];
            
            //$search_array['v_search_option_location'] = 'Toronto, ON, Canada';
            $search_array['v_search_radius'] = '20';
            $search_array['v_search_option_in_favorite'] = '1';

            $listings = $this->estate_m->get_by(array('language_id'=>$lang_id), FALSE, NULL, NULL, NULL, $search_array);
            if(!empty($listings)) {
                $listings_added = false;
                
                foreach ($listings as $key => $listing) {
                    $attendent =  $this->userattend_m->get_by(array('user_id' => $this->session->userdata('id'),'listing_id' => $listing->id));
                    if(empty($attendent)){
                        $data = array(
                            'user_id' => $this->session->userdata('id'),
                            'listing_id' => $listing->id,
                            'date' => date('Y-m-d H:i:s'),
                        );

                        $this->userattend_m->save($data);
                        $listings_added = true;
                    }
                }
                
                $this->data['success'] = true;
                if($listings_added)
                    $this->data['message'] = lang_check('Event(s) added to attend');
                else
                    $this->data['message'] = lang_check('You are already checked in to near events!');
            } else {
                $this->data['message'] = lang_check('Missing near events');
            }
        } else {
            $this->data['message'] = lang_check('Can\'t detect address');
        }
        
        echo json_encode($this->data);
        exit();
    }
    
    public function attend_by_ga_event_code($lang_code='1')
    {
        $this->data['message'] = '';
        $this->data['parameters'] = $_POST;
        $this->data['success'] = false;

        $this->load->model('favorites_m');
        $this->load->model('gamifyevents_m');
        $this->load->model('userattend_m');
        $this->load->model('estate_m');
        
        //qr_code
        $post = $_POST;
        
        if(isset($_FILES['qr_code'])) {
            $this->load->library('qr_code');
            $qr_code_img = $_FILES['qr_code'];
            $text = $this->qr_code->read($qr_code_img['tmp_name']); //return decoded text from QR Code
            $pos = stripos($text, 'event_confirm/confirmation/');
            $event_key = substr($text, $pos+ strlen('event_confirm/confirmation/'));
        }
        elseif(!empty($post['key_1']) && !empty($post['key_2']) && !empty($post['key_3']) && !empty($post['key_4'])) {
            $event_key = $post['key_1'].$post['key_2'].$post['key_3'].$post['key_4'];
        }
        

        $events = $this->gamifyevents_m->get_by(array('event_key'=>$event_key));
        $listing = false;
        if($events){
            $listing = $this->estate_m->get_array($events[0]->listing_id);
        }
        
        if($listing) {
            $listing_object = json_decode($listing['json_object']);
            $this->data['success'] = true;
            $listings_added = false;
            
            $attendent =  $this->userattend_m->get_by(array('user_id' => $this->session->userdata('id'),'listing_id' => $listing['id']));
                if(empty($attendent)){
                    $data = array(
                        'user_id' => $this->session->userdata('id'),
                        'listing_id' => $listing['id'],
                        'date' => date('Y-m-d H:i:s'),
                    );

                    $this->userattend_m->save($data);
                    $listings_added = true;
                }
                
            if($listings_added)    
                $this->data['message'] = lang_check('Event '.$listing_object->field_10. ' detected and added to attend');
            else
                $this->data['message'] = lang_check('Event '.$listing_object->field_10. ' already added in attend');
            
        } else {
            $this->data['message'] = lang_check('Event with that code missing');
        }
        
        echo json_encode($this->data);
        exit();
    }
}