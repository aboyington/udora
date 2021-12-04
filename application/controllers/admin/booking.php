<?php

class Booking extends Admin_Controller
{

	public function __construct(){
		parent::__construct();
        $this->load->model('showroom_m');
        $this->load->model('rates_m');
        $this->load->model('estate_m');
        $this->load->model('file_m');
        $this->load->model('repository_m');
        $this->load->model('reservations_m');

        // Get language for content id to show in administration
        $this->data['content_language_id'] = $this->language_m->get_content_lang();
        
        $this->data['template_css'] = base_url('templates/'.$this->data['settings']['template']).'/'.config_item('default_template_css');
	}
    
    public function index($property_id = 0, $pagination_offset=0)
	{
	    $this->load->library('pagination');
        
        $property_selected = array();
        if($property_id != 0)
        {
            $property_selected = array('reservations.property_id'=>$property_id);
        }
        
        $_GET_clone = $_GET;
        
        if(isset($_GET_clone['date_to']) && !empty($_GET_clone['date_to']))
            $property_selected = array_merge($property_selected, array('date_from <'=>$_GET_clone['date_to']));
        
        if(isset($_GET_clone['date_from']) && !empty($_GET_clone['date_from']))
            $property_selected = array_merge($property_selected, array('date_to >'=>$_GET_clone['date_from']));
        
        // Fetch all pages
        $this->data['page_languages'] = $this->language_m->get_form_dropdown('language');
        $this->data['properties'] = $this->estate_m->get_form_dropdown('address');
        $this->data['users'] = $this->user_m->get_form_dropdown('username');
        
        $smart_search = '';
        /* get id by username */
        if(array_search($_GET['smart_search'], $this->data['users']) !== FALSE) {
            $user_id='';
            $user_id = array_search($_GET['smart_search'], $this->data['users']);
            $smart_search = $_GET['smart_search'];
            $_GET['smart_search'] = $user_id;
        } 
        
        prepare_search_query_GET(array(), array('reservations.id','reservations.user_id'));
        
        $this->data['reservations'] = $this->reservations_m->get_by_check($property_selected);
        
        $config['base_url'] = site_url('admin/booking/index/'.$property_id.'/');
        $config['uri_segment'] = 5;
        $config['total_rows'] = count($this->data['reservations']);
        $config['per_page'] = 20;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        
        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();
       
        if(config_item('admin_template') == 'udora_admin') {
            $pagination_offset = NULL;
            $config['per_page'] = NULL;
        }
        
        prepare_search_query_GET(array(), array('reservations.id','reservations.user_id'));
        $this->data['reservations'] = $this->reservations_m->get_by_check($property_selected, FALSE, $config['per_page'], NULL, $pagination_offset);
        
        
        if(!empty($smart_search))
            $_GET['smart_search'] = $smart_search;
        // Load view
		$this->data['subview'] = 'admin/booking/index';
        $this->load->view('admin/_layout_main', $this->data);
	}
    
    public function edit($id = NULL)
	{
	    // Fetch a page or set a new one
	    if($id)
        {
            $this->data['rate'] = $this->reservations_m->get($id);
            count($this->data['rate']) || $this->data['errors'][] = 'Could not be found';
            
            if(!isset($this->data['rate']->property_id))
                redirect('admin/booking');
            
            //Check if user have permissions
            if($this->session->userdata('type') != 'ADMIN')
            {
                $num_found = $this->estate_m->check_user_permission($this->data['rate']->property_id, $this->session->userdata('id'));
                
                if($num_found == 0)
                    redirect('admin/booking');
            }
        }
        else
        {
            // Only ADMIN can add new reservations
            if($this->session->userdata('type') != 'ADMIN')
            {
                exit(lang_check('Access not allowed'));
            }
            
            $this->data['rate'] = $this->reservations_m->get_new();
        }
        
		// Pages for dropdown
        $where_users = array();
        $empty_users = TRUE;
        if($this->session->userdata('type') != 'ADMIN')
        {
            $where_users = array('id'=>$this->data['rate']->user_id);
            $empty_users = FALSE;
        }
        
        $this->data['properties'] = $this->estate_m->get_form_dropdown('address', FALSE, TRUE, TRUE);
        $this->data['users'] = $this->user_m->get_form_dropdown('username', $where_users, $empty_users);
        $this->load->model('payments_m');
        $this->data['currencies'] = $this->payments_m->currencies;
        
        // [Complicated way, ID, Property name, address]
        if(config_item('address_to_title') === TRUE)
        {
            $this->load->model('option_m');
            $this->data['options'] = $this->option_m->get_options($this->data['content_language_id'], array(10), array_flip($this->data['properties']));
            
            foreach($this->data['properties'] as $key=>$val)
            {
                if(!empty($key))
                {
                    if(isset($this->data['options'][$key][10]))
                    {
                        $this->data['properties'][$key] = $val.', '.$this->data['options'][$key][10];
                    }
                    else
                    {
                        $this->data['properties'][$key] = $val;
                    }
                }
            }     
        }
        // [/Complicated way, ID, Property name, address]
        
        // Set up the form
        $rules = $this->reservations_m->rules_admin;
        $this->form_validation->set_rules($rules);

        // Process the form
        if($this->form_validation->run() == TRUE)
        {
            if($this->config->item('app_type') == 'demo')
            {
                $this->session->set_flashdata('error', 
                        lang('Data editing disabled in demo'));
                redirect('admin/booking/edit/'.$id);
                exit();
            }
            
            $data = $this->reservations_m->array_from_post(array('date_from', 'date_to', 'property_id', 
                                                          'user_id', 'total_price', 'total_paid', 
                                                          'date_paid_advance', 'date_paid_total', 'currency_code', 'is_confirmed'));
            
            if(empty($data['total_price']))
                $data['total_price'] = $this->reservations_m->calculate_price($data['property_id'], $data['date_from'], 
                                                                              $data['date_to'], $data['currency_code']);

            if(empty($data['date_paid_advance']))
                $data['date_paid_advance'] = NULL;
            
            if(empty($data['date_paid_total']))
                $data['date_paid_total'] = NULL;
            
            $id = $this->reservations_m->save($data, $id);
            
            $this->session->set_flashdata('message', 
                    '<p class="label label-success validation">'.lang_check('Changes saved').'</p>');
            
            if(!empty($id))
            {
                redirect('admin/booking/edit/'.$id);
            }
            else
            {
                $this->output->enable_profiler(TRUE);
            }
        }
        
        // Load the view
		$this->data['subview'] = 'admin/booking/edit';
        $this->load->view('admin/_layout_main', $this->data);
	}
    
    public function add_multiple()
    {
        // Only ADMIN can add new reservations
        if($this->session->userdata('type') != 'ADMIN')
        {
            exit(lang_check('Access not allowed'));
        }
        
		// Pages for dropdown
        $where_users = array();
        $empty_users = FALSE;
        $where_users = array('id'=>$this->session->userdata('id'));
        
        $this->data['properties'] = $this->estate_m->get_form_dropdown('address', FALSE, TRUE, TRUE);
        $this->data['users'] = $this->user_m->get_form_dropdown('username', $where_users, $empty_users);
        
        // [Complicated way, ID, Property name, address]
        if(config_item('address_to_title') === TRUE)
        {
            $this->load->model('option_m');
            $this->data['options'] = $this->option_m->get_options($this->data['content_language_id'], array(10), array_flip($this->data['properties']));
            
            foreach($this->data['properties'] as $key=>$val)
            {
                if(!empty($key))
                {
                    if(isset($this->data['options'][$key][10]))
                    {
                        $this->data['properties'][$key] = $val.', '.$this->data['options'][$key][10];
                    }
                    else
                    {
                        $this->data['properties'][$key] = $val;
                    }
                }
            }     
        }
        // [/Complicated way, ID, Property name, address]
        
        $prefs = array();
        $prefs['template'] = '
           {table_open}<table border="0" class="av_calender" cellpadding="0" cellspacing="0">{/table_open}
           {heading_row_start}<tr>{/heading_row_start}
           {heading_previous_cell}<th><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
           {heading_title_cell}<th colspan="{colspan}"><span>{heading}</span></th>{/heading_title_cell}
           {heading_next_cell}<th><a href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}
        
           {heading_row_end}</tr>{/heading_row_end}
        
           {week_row_start}<tr>{/week_row_start}
           {week_day_cell}<td><span>{week_day}</span></td>{/week_day_cell}
           {week_row_end}</tr>{/week_row_end}
        
           {cal_row_start}<tr>{/cal_row_start}
           {cal_cell_start}<td>{/cal_cell_start}
        
           {cal_cell_content}<a {content} href="#form">{day}</a>{/cal_cell_content}
           {cal_cell_content_today}<a {content} style="background: red; color:white;" href="#form">{day}</a>{/cal_cell_content_today}
        
           {cal_cell_no_content}<span class="disabled">{day}</span>{/cal_cell_no_content}
           {cal_cell_no_content_today}<div class="highlight disabled">{day}</div>{/cal_cell_no_content_today}
        
           {cal_cell_blank}<span>&nbsp;</span>{/cal_cell_blank}
        
           {cal_cell_end}</td>{/cal_cell_end}
           {cal_row_end}</tr>{/cal_row_end}
        
           {table_close}</table>{/table_close}
        ';
        
        $this->load->library('calendar', $prefs);
        $this->data['months_availability'] = array();
        $cal_data = array();

        for($i=0;$i < 6; $i++)
        {
            $next_month_time = strtotime("+$i month", strtotime(date("F") . "1"));
            
            $start_time = $next_month_time;
            $end_time = strtotime("+1 month", $start_time);
            for($j=$start_time; $j<$end_time; $j+=86400)
            {
               $cal_data[date("m", $j)][date("j", $j)] = 'class="available selectable" ref="'.date("Y-m-d", $j).'" ref_to="'.date("Y-m-d", strtotime(date("Y-m-d", $j).' +7 day')).'"';
            }
            
            if(!isset($cal_data[date("m", $next_month_time)]))
                $cal_data[date("m", $next_month_time)] = array();

            $this->data['months_availability'][date("Y-m", $next_month_time)] = $this->calendar->generate(date("Y", $next_month_time), date("m", $next_month_time), $cal_data[date("m", $next_month_time)]);
        }
        
        // Set up the form
        $rules = $this->reservations_m->rules_admin_multiple;
        $this->form_validation->set_rules($rules);

        // Process the form
        if($this->form_validation->run() == TRUE)
        {
            if($this->config->item('app_type') == 'demo')
            {
                $this->session->set_flashdata('error', 
                        lang('Data editing disabled in demo'));
                redirect('admin/booking/');
                exit();
            }
            
            $data = $this->reservations_m->array_from_post(array('user_id', 'property_id', 'dates'));
            
            $count_inserted = $this->reservations_m->add_multiple($data);

            if(!empty($count_inserted))
            {
                $this->session->set_flashdata('message', 
                        '<p class="label label-success validation">'.lang_check('Multiple inserted').': '.$count_inserted.'</p>');
                redirect('admin/booking/add_multiple');
            }
            else
            {
                $this->session->set_flashdata('error', lang_check('Nothing inserted, reservations already exists'));
                redirect('admin/booking/add_multiple');
            }
        }

        // Load the view
		$this->data['subview'] = 'admin/booking/add_multiple';
        $this->load->view('admin/_layout_main', $this->data);
    }
    
    public function payments($reservation_id = 0, $pagination_offset=0)
    {
	    $this->load->library('pagination');
        $this->load->model('payments_m');
        
        $reservation_selected = array('invoice_num LIKE'=>'%_RES_%');
        if($reservation_id != 0)
        {
            $reservation_selected = array('invoice_num LIKE'=>$reservation_id.'_RES_%');
        }
        
        // Fetch all pages
        $this->data['page_languages'] = $this->language_m->get_form_dropdown('language');
        $this->data['properties'] = $this->estate_m->get_form_dropdown('address');
        $this->data['payments'] = $this->payments_m->get_by_check($reservation_selected);
        
        $config['base_url'] = site_url('admin/booking/payments/'.$reservation_id.'/');
        $config['uri_segment'] = 5;
        $config['total_rows'] = count($this->data['payments']);
        $config['per_page'] = 20;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';

        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();
        if(config_item('admin_template') == 'udora_admin') {
            $pagination_offset = NULL;
            $config['per_page'] = NULL;
        }
        if($this->session->userdata('type') == 'ADMIN')
            $this->data['payments'] = $this->payments_m->get_by_check($reservation_selected, FALSE, $config['per_page'], NULL, $pagination_offset);
        
        // Load view
		$this->data['subview'] = 'admin/booking/payments';
        $this->load->view('admin/_layout_main', $this->data);
    }
    
    public function view_payment($id = NULL)
	{
        $this->load->model('payments_m');
        
	    // Fetch a page or set a new one
	    if($id)
        {
            $this->data['payment'] = $this->payments_m->get_by(array('id'=>$id), TRUE);
            count($this->data['payment']) || $this->data['errors'][] = 'Could not be found';
        }
        else
        {
            redirect('admin/booking/payments/');
        }
                
        // Load the view
		$this->data['subview'] = 'admin/booking/view_payment';
        $this->load->view('admin/_layout_main', $this->data);
	}
    
    public function rates($property_id = 0, $pagination_offset=0)
	{
	    $this->load->library('pagination');
        
        $property_selected = array();
        if($property_id != 0)
        {
            $property_selected = array('rates.property_id'=>$property_id);
        }
        
        // Fetch all pages
        $this->data['page_languages'] = $this->language_m->get_form_dropdown('language');
        $this->data['properties'] = $this->estate_m->get_form_dropdown('address');
        $this->data['rates'] = $this->rates_m->get_by_check($property_selected);
        
        $config['base_url'] = site_url('admin/booking/rates/'.$property_id.'/');
        $config['uri_segment'] = 5;
        $config['total_rows'] = count($this->data['rates']);
        $config['per_page'] = 20;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        
        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();
        if(config_item('admin_template') == 'udora_admin') {
            $pagination_offset = NULL;
            $config['per_page'] = NULL;
        }
        $this->data['rates'] = $this->rates_m->get_by_check($property_selected, FALSE, $config['per_page'], NULL, $pagination_offset);
        
        // Load view
		$this->data['subview'] = 'admin/booking/rates';
        $this->load->view('admin/_layout_main', $this->data);
	}
    
    public function withdrawals($user_id = 0, $pagination_offset=0)
	{
	    $this->load->library('pagination');
        $this->load->model('withdrawal_m');
        
        $property_selected = array();
        if($property_id != 0)
        {
            $property_selected = array('withdrawal.user_id'=>$user_id);
        }
        
        // Fetch all pages
        $this->data['properties'] = $this->estate_m->get_form_dropdown('address');
        $this->data['listings'] = $this->withdrawal_m->get_by($property_selected, FALSE);
        
        $config['base_url'] = site_url('admin/booking/withdrawals/'.$user_id.'/');
        $config['uri_segment'] = 5;
        $config['total_rows'] = count($this->data['listings']);
        $config['per_page'] = 20;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        
        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();
        if(config_item('admin_template') == 'udora_admin') {
            $pagination_offset = NULL;
            $config['per_page'] = NULL;
        }
        
        $this->data['listings'] = $this->withdrawal_m->get_by($property_selected, FALSE, $config['per_page'], NULL, $pagination_offset);
        
        // Load view
		$this->data['subview'] = 'admin/booking/withdrawals';
        $this->load->view('admin/_layout_main', $this->data);
	}
    
    public function import_booked()
    {
        $this->load->model('language_m');
        $this->load->model('reservations_m');
        $this->load->model('payments_m');
        
        $this->data['currencies'] = $this->payments_m->currencies;
        
		$config['upload_path'] = './files/';
		$config['allowed_types'] = 'xml';
		$config['max_size']	= '1000';
        $config['overwrite'] = TRUE;
        
        
        $default_currency = 'USD';
        if(!empty($this->data['settings']['default_currency']))
            $default_currency = $this->data['settings']['default_currency'];

		$this->load->library('upload', $config);

        if(isset($_POST['submit']))
		if ( ! $this->upload->do_upload('userfile_xml'))
		{
			$this->data['error'] = $this->upload->display_errors('', '');
		}
		else
		{
			$upload_data = $this->upload->data();
            $file_path = $upload_data['full_path'];

            // Load xml file for import
            $xmlurl = $file_path;
            $dom = new DOMDocument();   
            $dom->load($xmlurl);
            
            $imported_counter = array();
            $root_property = $dom->getElementsByTagName('properties');
            $properties = $root_property->item(0)->getElementsByTagName('property');
            foreach($properties as $property) {
                $property_id = $property->getAttribute('id');
                
                //jump to next iteration
                if(empty($property_id))continue;
                
                if(config_db_item('transitions_id_enabled') === TRUE)
                {
                    //Check if property with custom id exists
                    $query = $this->db->get_where('property', array('id_transitions' => $property_id));
                }
                else
                {
                    //Check if property exists
                    $query = $this->db->get_where('property', array('id' => $property_id));
                }
                
                $property_id = NULL;
                
                if ($query->num_rows() > 0)
                {
                    $row = $query->row();
                    $property_id = $row->id;
                }
                
                //jump to next iteration
                if(empty($property_id))continue;
                
                if(!isset($imported_counter[$property_id]))
                    $imported_counter[$property_id] = 0;
                
                //Load property rates from yesterday, last todate
                $existing_res = array();
                $existing_dates = array();
                $last_to_date = date('Y-m-d');
                $query = $this->db->get_where('reservations', array('property_id' => $property_id, 'date_to >' => date('Y-m-d 00:00:00')));
                if ($query->num_rows() > 0)
                {
                    foreach ($query->result() as $row)
                    {
                        $existing_res[date('Y-m-d', strtotime($row->date_from))] = 
                                      date('Y-m-d', strtotime($row->date_to));
                                        
                        if(strtotime($row->date_to) > strtotime($last_to_date))
                            $last_to_date = date('Y-m-d', strtotime($row->date_to));
                            
                        /* [get days] */
                        $days_between = $this->reservations_m->days_between($row->date_from, $row->date_to);
                        
                        $days = array();
                        for($i=0; $i < $days_between;  $i++)
                        {
                            $row_time = strtotime($row->date_from." + $i day");
                            $row_time_00 = date("Y-m-d", $row_time);
                            $existing_dates[$row_time_00] = strtotime($row_time_00);
                        }
                        /* [/get days] */
                    }
                }
                
                $dates_reserved_iso = array();
                $dates_ranges_iso = array();
                $dates_import = $property->getElementsByTagName('date');
                foreach($dates_import as $date_curr) {
                    $iso_date       = $date_curr->nodeValue;
                    $row_time_00 = date("Y-m-d", strtotime($iso_date));
                    $dates_reserved_iso[$row_time_00] = strtotime($row_time_00);
                    
                    $last_added_date_from = end(array_keys($dates_ranges_iso));

                    if($last_added_date_from === NULL)
                    {
                        $last_added_date_from = $row_time_00;
                        $dates_ranges_iso[$last_added_date_from] = date("Y-m-d", strtotime($row_time_00." + 1 day"));
                    }
                    else if($dates_ranges_iso[$last_added_date_from] == $row_time_00)
                    {
                        $dates_ranges_iso[$last_added_date_from] = date("Y-m-d", strtotime($row_time_00." + 1 day"));
                    }
                    else
                    {
                        $last_added_date_from = $row_time_00;
                        $dates_ranges_iso[$last_added_date_from] = date("Y-m-d", strtotime($row_time_00." + 1 day"));
                    }
                }
                
                $user_id = $this->session->userdata('id');
                
                $data_batch = array();
                if(!empty($user_id))
                foreach($dates_ranges_iso as $from_date=>$to_date)
                {
                    if(isset($existing_res[$from_date]))
                        continue;
                    
                    $date_prepare = array();
                    $date_prepare['user_id'] = $user_id;                  
                    $date_prepare['property_id'] = $property_id;
                    $date_prepare['date_from'] = date('Y-m-d 12:00:00', strtotime($from_date));
                    $date_prepare['date_to'] = date('Y-m-d 12:00:00', strtotime($to_date));
                    
                    $date_prepare['total_price'] = 0;
                    $date_prepare['currency_code'] = $default_currency;
                    $date_prepare['date_paid_advance'] = 0;
                    $date_prepare['date_paid_total'] = 0;
                    $date_prepare['total_paid'] = 0;
                    $date_prepare['is_confirmed'] = 1;
                    $date_prepare['saller_id'] = NULL;
                    $date_prepare['booking_fee'] = 0;

                    $data_batch[] = $date_prepare;

                    $imported_counter[$property_id]++;
                }
                
                // Import all rates for property
                if(count($data_batch) > 0)
                    $this->db->insert_batch('reservations', $data_batch);
            }
            
            if(count($imported_counter) == 0)
                $this->data['error'] = lang_check('Nothing to import');
            
            unlink($file_path);
		}
        
        $this->data['import'] = $imported_counter;

        // Load the view
		$this->data['subview'] = 'admin/booking/import_booked';
        $this->load->view('admin/_layout_main', $this->data);
    }
    
    public function import_rate()
    {
        $this->load->model('language_m');
        
        $this->load->model('payments_m');
        $this->data['currencies'] = $this->payments_m->currencies;
        
        $this->lang->load('calendar');
        $this->data['changeover_days'] = array(lang_check('Flexible'), 
                                               lang_check('cal_monday'),
                                               lang_check('cal_tuesday'),
                                               lang_check('cal_wednesday'),
                                               lang_check('cal_thursday'),
                                               lang_check('cal_friday'),
                                               lang_check('cal_saturday'),
                                               lang_check('cal_sunday'));
        
		$config['upload_path'] = './files/';
		$config['allowed_types'] = 'xml';
		$config['max_size']	= '1000';
        $config['overwrite'] = TRUE;

		$this->load->library('upload', $config);
        
        if(isset($_POST['min_stay']))
		if ( ! $this->upload->do_upload('userfile_xml'))
		{
			$this->data['error'] = $this->upload->display_errors('', '');
		}
		else
		{
			$upload_data = $this->upload->data();
            $min_stay = $this->input->post('min_stay');
            $changeover_day = $this->input->post('changeover_day');
            $file_path = $upload_data['full_path'];

            if(empty($min_stay))$min_stay = 1;

            // Load xml file for import
            $xmlurl = $file_path;
            $dom = new DOMDocument();   
            $dom->load($xmlurl);
            
            $imported_counter = array();
            $root_property = $dom->getElementsByTagName('property');
            $properties = $root_property->item(0)->getElementsByTagName('property');
            foreach($properties as $property) {
                $property_id = $property->getAttribute('id');
                
                //jump to next iteration
                if(empty($property_id))continue;
                
                if(config_db_item('transitions_id_enabled') === TRUE)
                {
                    //Check if property with custom id exists
                    $query = $this->db->get_where('property', array('id_transitions' => $property_id));
                }
                else
                {
                    //Check if property exists
                    $query = $this->db->get_where('property', array('id' => $property_id));
                }
                
                $property_id = NULL;
                
                if ($query->num_rows() > 0)
                {
                    $row = $query->row();
                    $property_id = $row->id;
                }
                
                //jump to next iteration
                if(empty($property_id))continue;
                
                if(!isset($imported_counter[$property_id]))
                    $imported_counter[$property_id] = 0;
                
                //Load property rates from yesterday, last todate
                $existing_rates = array();
                $last_to_date = date('Y-m-d');
                $query = $this->db->get_where('rates', array('property_id' => $property_id, 'date_to >' => date('Y-m-d 00:00:00')));
                if ($query->num_rows() > 0)
                {
                    foreach ($query->result() as $row)
                    {
                        $existing_rates[date('Y-m-d', strtotime($row->date_from))] = 
                                        date('Y-m-d', strtotime($row->date_to));
                                        
                        if(strtotime($row->date_to) > strtotime($last_to_date))
                            $last_to_date = date('Y-m-d', strtotime($row->date_to));
                    }
                }
                
                $data_rates = array();
                $data_rates_lang = array();
                $data_rates_imports = array();
                $data_rates_prices = array();
                $rates              = $property->getElementsByTagName('period');
                foreach($rates as $rate) {
                    $fromdate       = $rate->getElementsByTagName('fromdate')->item(0)->nodeValue;
                    $todate         = $rate->getElementsByTagName('todate')->item(0)->nodeValue;
                    $priceperweek   = $rate->getElementsByTagName('priceperweek')->item(0)->nodeValue;
                    
                    //If rate is from last todate
                    if(strtotime($todate) < strtotime($last_to_date) || 
                       !is_numeric($priceperweek) || 
                       empty($fromdate) || 
                       empty($todate))
                        continue;
                    
                    //If rate doesn't exists add it to batch import
                    if(!isset($existing_rates[date('Y-m-d', strtotime($fromdate))]))
                    {
                        $imported_counter[$property_id]++;
                        
                        $date_prepare = array();
                        $date_prepare['property_id'] = $property_id;
                        $date_prepare['date_from'] = date('Y-m-d 12:00:00', strtotime($fromdate));
                        //$date_prepare['date_to'] = date('Y-m-d 12:00:00', strtotime($todate));
                        $date_prepare['date_to'] = date('Y-m-d 12:00:00', strtotime($todate)+24*60*60);
                        $date_prepare['min_stay'] = $min_stay;
                        $date_prepare['changeover_day'] = $changeover_day;
                        $data_rates[] = $date_prepare;
                        
                        $data_rates_imports[] = $date_prepare['date_from'];
                        $data_rates_prices[$date_prepare['date_from']] = $priceperweek;
                    }
                }
                
                // Import all rates for property
                if(count($data_rates) > 0)
                    $this->db->insert_batch('rates', $data_rates);
                
                // get all imports
                if(count($data_rates_imports) > 0 && count($data_rates) > 0)
                {
                    $this->db->where_in('date_from', $data_rates_imports);
                    $query = $this->db->get_where('rates', array('property_id' => $property_id));
                    if ($query->num_rows() > 0)
                    {
                        foreach ($query->result() as $row)
                        {
                            if(isset($data_rates_prices[$row->date_from]))
                            foreach($this->language_m->db_languages_code_obj as $lang_obj)
                            {
                                    $price_week = $data_rates_prices[$row->date_from];
                                    
                                    $date_prepare = array();
                                    $date_prepare['rates_id'] = $row->id;
                                    $date_prepare['language_id'] = $lang_obj->id;
                                    $date_prepare['rate_nightly'] = $price_week/7;
                                    $date_prepare['rate_weekly'] = $price_week;
                                    $date_prepare['rate_monthly'] = $price_week*4;
                                    $date_prepare['currency_code'] = $lang_obj->currency_default;
                                    $data_rates_lang[] = $date_prepare;
                            }
                        }
                        
                        if(count($data_rates_lang) > 0)
                            $this->db->insert_batch('rates_lang', $data_rates_lang); 
                    }
                }
            }
            
            if(count($imported_counter) == 0)
                $this->data['error'] = lang_check('Nothing to import');
            
            unlink($file_path);
		}
        
        $this->data['import'] = $imported_counter;

        // Load the view
		$this->data['subview'] = 'admin/booking/import_rate';
        $this->load->view('admin/_layout_main', $this->data);
    }
    
    public function edit_rate($id = NULL)
	{
	    // Fetch a page or set a new one
	    if($id)
        {
            $this->data['rate'] = $this->rates_m->get_lang($id, FALSE, $this->data['content_language_id']);
            count($this->data['rate']) || $this->data['errors'][] = 'Could not be found';
            
            if(!isset($this->data['rate']->property_id))
                redirect('admin/booking/rates');
            
            //Check if user have permissions
            if($this->session->userdata('type') != 'ADMIN')
            {
                $num_found = $this->estate_m->check_user_permission($this->data['rate']->property_id, $this->session->userdata('id'));
                
                if($num_found == 0)
                    redirect('admin/booking/rates');
            }
        }
        else
        {
            $this->data['rate'] = $this->rates_m->get_new();
        }
        
		// Pages for dropdown
        $this->data['page_languages'] = $this->language_m->get_form_dropdown('language');
        
        //Simple way to featch only address:        
        $this->data['properties'] = $this->estate_m->get_form_dropdown('address', false, true, true);
        
        // [Complicated way, ID, Property name, address]
        // Commented because use to much of memory
//        $this->load->model('option_m');
//        $this->data['options'] = $this->option_m->get_options($this->data['content_language_id']);
//        
//        foreach($this->data['properties'] as $key=>$val)
//        {
//            if(!empty($key))
//            {
//                if(isset($this->data['options'][$key][10]))
//                {
//                    $this->data['properties'][$key] = $key.', '.$this->data['options'][$key][10].', '.$val;
//                }
//                else
//                {
//                    $this->data['properties'][$key] = $key.', '.$val;
//                }
//            }
//        }        
        // [/Complicated way, ID, Property name, address]
        $this->load->model('payments_m');
        $this->data['currencies'] = $this->payments_m->currencies;
        
        $this->lang->load('calendar');
        $this->data['changeover_days'] = array(lang_check('Flexible'), 
                                               lang_check('cal_monday'),
                                               lang_check('cal_tuesday'),
                                               lang_check('cal_wednesday'),
                                               lang_check('cal_thursday'),
                                               lang_check('cal_friday'),
                                               lang_check('cal_saturday'),
                                               lang_check('cal_sunday'));
        
        // Set up the form
        $rules = $this->rates_m->get_all_rules();
        $this->form_validation->set_rules($rules);

        // Process the form
        if($this->form_validation->run() == TRUE)
        {
            if($this->config->item('app_type') == 'demo')
            {
                $this->session->set_flashdata('error', 
                        lang('Data editing disabled in demo'));
                redirect('admin/booking/edit_rate/'.$id);
                exit();
            }
            
            $data = $this->rates_m->array_from_post(array('date_from', 'date_to', 'min_stay', 'changeover_day', 'property_id'));
            
            $data_lang = $this->rates_m->array_from_post($this->rates_m->get_lang_post_fields());
            
            //Check if user have permissions
            if($this->session->userdata('type') != 'ADMIN')
            {
                $num_found = $this->estate_m->check_user_permission($data['property_id'], $this->session->userdata('id'));
                
                if($num_found == 0)
                    exit(lang_check('Access not allowed'));
            }
            
            $id = $this->rates_m->save_with_lang($data, $data_lang, $id);
            
            $this->session->set_flashdata('message', 
                    '<p class="label label-success validation">'.lang_check('Changes saved').'</p>');
            
            if(!empty($id))
            {
                redirect('admin/booking/edit_rate/'.$id);
            }
            else
            {
                $this->output->enable_profiler(TRUE);
            }
        }
        
        // Load the view
		$this->data['subview'] = 'admin/booking/edit_rate';
        $this->load->view('admin/_layout_main', $this->data);
	}
    
    public function add_multiple_rates_summer () {
        $this->data['properties'] = $this->estate_m->get_form_dropdown('address', false, true, true);
        $this->load->model('language_m');
 
        $this->lang->load('calendar');

        $this->data['months'] = array(   '1'=> lang_check('cal_january'), 
                                               lang_check('cal_february'),
                                               lang_check('cal_march'),
                                               lang_check('cal_april'),
                                               lang_check('cal_mayl'),
                                               lang_check('cal_june'),
                                               lang_check('cal_july'),
                                               lang_check('cal_august'),
                                               lang_check('cal_september'),
                                               lang_check('cal_october'),
                                               lang_check('cal_november'),
                                               lang_check('cal_december'));
        
        /* create weeks array
        * 
        * create array[months][weeks][days]  $cal_weeks
        */ 
        $dateCurrent = getdate();
        $start = new DateTime('01.01.'.$dateCurrent["year"]);
        $end = new DateTime('31.12.'.$dateCurrent["year"].' 23:59:59'); 
        
        $interval = new DateInterval('P1D');
        $dateRange = new DatePeriod($start, $interval, $end);
        $weekNumber = 1;
        $month = 1;
        $cal_weeks = array();
        foreach ($dateRange as $date) {
          $cal_weeks[$month][$weekNumber][] = $date->format('U');
          if ($date->format('w') == 6) {
           $weekNumber++;
            if ($date->format('m') > $month || $date->format('d') > 27) {
             $month++;
             $weekNumber=1;
            }
          }
        }
       $this->data['cal_weeks'] = $cal_weeks;
        
        
        /* add rules */
        $rules=array();
        for ($month=6;$month<=9;$month++) :
                foreach ($cal_weeks[$month] as $key_week=>$week) {
                    foreach ($this->showroom_m->languages as $key => $value) {
                        $rules['rate_weekly_'.$month.'_'.$key_week.'_'.$key]= array ( 'field' => 'rate_weekly_'.$month.'_'.$key_week.'_'.$key,'label' => 'lang:Rate weekly '.$this->data['months'][$month].' day '.date('d',$week[0]).'/'.date('d', ($week[count($week)-1]+86400)), 'rules' => 'trim|required|xss_clean' );
                    }
            }
        endfor;
       /* echo '<pre>';
        print_r($rules);
        return false;*/
        $rules['property_id']= array('field'=>'property_id', 'label'=>'lang:Property', 'rules'=>'trim|required|intval');
        $this->form_validation->set_rules($rules);
        /* end add rules */
        
        // Process the form
        if($this->form_validation->run() == TRUE)
        {
            if($this->config->item('app_type') == 'demo')
            {
                $this->session->set_flashdata('error', 
                        lang('Data editing disabled in demo'));
                redirect('admin/booking/rate/'.$id);
                exit();
            }
            
            $data = $this->rates_m->array_from_post(array('property_id'));
            $data_lang = $this->rates_m->array_from_post($this->rates_m->get_lang_post_fields());
            //Check if user have permissions
            if($this->session->userdata('type') != 'ADMIN')
            {
                $num_found = $this->estate_m->check_user_permission($data['property_id'], $this->session->userdata('id'));
                
                if($num_found == 0)
                    exit(lang_check('Access not allowed'));
            }
            
            $property_id=$this->input->post('property_id');
            
            /* [start] check is_blocked Date */
            $dateCurrent = getdate();
            $is_booked = $this->rates_m->is_defined(30, $dateCurrent["year"]."-06-01 12:00:00", $dateCurrent["year"]."-11-01 12:00:00");
            if(count($is_booked) > 0)
            { 
                // Load the view
                $this->session->set_flashdata('error', lang_check('Summer dates already defined'));                
                redirect('admin/booking/rates/');
                exit();
            }
            /* [end] check is_blocked Date */
            
            /* fetch rates */
            for ($month=6;$month<=9;$month++) :
                // fetch rates for week of month
                foreach ($cal_weeks[$month] as $colm=>$week) {
                    $data=array();
                    $data_lang = array();
                    $flag=true;
                    // add rates to $data_lang
                    foreach ($this->showroom_m->languages as $key => $value) {
                        if(!isset($_POST['rate_weekly_'.$month.'_'.$colm.'_'.$key])) {
                            $flag=false;
                        }
                            $lang=$this->language_m->get($key);
                            
                            $data_lang["rate_weekly_$key"]=$this->input->post('rate_weekly_'.$month.'_'.$colm.'_'.$key);
                            $data_lang["rate_nightly_$key"]=$data_lang["rate_weekly_$key"]/7;
                            $data_lang["rate_monthly_$key"]=$data_lang["rate_nightly_$key"]*30;
                            $data_lang["currency_code_$key"]=$lang->currency_default;
                    }
                    
                $data['property_id'] = $property_id; 
                $data['date_from'] = $this->input->post('date_from_'.$month.'_'.$colm);
                $data['date_to'] = $this->input->post('date_to_'.$month.'_'.$colm);
                
                    // add in bd new rate
                if($flag)
                   $id = $this->rates_m->save_with_lang($data, $data_lang);     
                }
            
            endfor;
            
            
            /* end fetch rates */
            
            $this->session->set_flashdata('message', 
                    '<p class="label label-success validation">'.lang_check('Multiple rates added').'</p>');
            
            
            
            if(!empty($id))
            {
               redirect('admin/booking/rates/');
            }
            else
            {
               $this->output->enable_profiler(TRUE);
            }
        }
        
        
        // Load the view
        $this->data['subview'] = 'admin/booking/add_multiple_rates_summer';
        $this->load->view('admin/_layout_main', $this->data);
    }    
        
    public function edit_withdrawal($id)
    {
        $this->load->model('withdrawal_m');
        
	    // Fetch a page or set a new one
	    if($id)
        {
            $this->data['item'] = $this->withdrawal_m->get($id);
            count($this->data['item']) || $this->data['errors'][] = 'Could not be found';

            if(!isset($this->data['item']->user_id))
                redirect('admin/booking/withdrawals');

            //Check if user have permissions
            if($this->session->userdata('type') != 'ADMIN')
            {
                 redirect('admin/booking/withdrawals');
            }
        }
        else
        {
            redirect('admin/booking/withdrawals');
        }
        
        $this->data['users'] = $this->user_m->get_form_dropdown('username', array('user.id'=>$this->data['item']->user_id));
        
        // Set up the form
        $rules = $this->withdrawal_m->rules_admin;
        $this->form_validation->set_rules($rules);

        // Process the form
        if($this->form_validation->run() == TRUE)
        {
            if($this->config->item('app_type') == 'demo')
            {
                $this->session->set_flashdata('error', 
                        lang('Data editing disabled in demo'));
                redirect('admin/booking/edit_withdrawal/'.$id);
                exit();
            }
            
            $data = $this->withdrawal_m->array_from_post(
                            $this->withdrawal_m->get_post_from_rules($rules)
                        );
            
            if(empty($data['date_completed']))
                $data['date_completed'] = NULL;
            else
                $data['completed'] = 1;
                
            if(empty($data['date_requested']))
                $data['date_requested'] = NULL;
            
            $id = $this->withdrawal_m->save($data, $id);
            
            $this->session->set_flashdata('message', 
                    '<p class="label label-success validation">'.lang_check('Changes saved').'</p>');
            
            if(!empty($id))
            {
                redirect('admin/booking/edit_withdrawal/'.$id);
            }
            else
            {
                $this->output->enable_profiler(TRUE);
            }
        }
        
        // Load the view
		$this->data['subview'] = 'admin/booking/edit_withdrawal';
        $this->load->view('admin/_layout_main', $this->data);
    }
    
    public function withdrawals_export()
    {
        $this->load->helper('download');
        $this->load->model('withdrawal_m');
        
	    // Fetch all users
		$users = $this->withdrawal_m->get_by(array('completed'=>0));
        
        $data = '';
        
        foreach($users as $row)
        {
            if(strpos($row->withdrawal_email, '@') > 1)
            {
                $data.= $row->withdrawal_email."\t".$row->amount."\t".$row->currency
                       ."\twithdrawal-".$row->id_withdrawal."\tPayment#".$row->id_withdrawal."\r\n";
            }
        }
        
        if(strlen($data) > 2)
            $data = substr($data,0,-1);
        
        $name = 'withdrawals-'. date('Y-m-d').'.txt';
        
        force_download($name, $data); 
    }

    public function delete_rate($id)
	{
        if($this->config->item('app_type') == 'demo')
        {
            $this->session->set_flashdata('error', 
                    lang('Data editing disabled in demo'));
            redirect('admin/booking/rates');
            exit();
        }
        
        //Check if user have permissions
        if($this->session->userdata('type') != 'ADMIN')
        {
            $rate = $this->rates_m->get($id);
            
            if(!isset($rate->property_id))
                redirect('admin/booking/rates');
            
            $num_found = $this->estate_m->check_user_permission($rate->property_id, $this->session->userdata('id'));
            
            if($num_found == 0)
                redirect('admin/booking/rates');
        }
       
		$this->rates_m->delete($id);
        redirect('admin/booking/rates');
	}

    public function delete($id)
	{
        if($this->config->item('app_type') == 'demo')
        {
            $this->session->set_flashdata('error', 
                    lang('Data editing disabled in demo'));
            redirect('admin/booking');
            exit();
        }
        
        //Check if user have permissions
        if($this->session->userdata('type') != 'ADMIN')
        {
            $rate = $this->reservations_m->get($id);
            
            if(!isset($rate->property_id))
                redirect('admin/booking');
            
            $num_found = $this->estate_m->check_user_permission($rate->property_id, $this->session->userdata('id'));
            
            if($num_found == 0)
                redirect('admin/booking');
        }
       
		$ret = $this->reservations_m->delete($id);
        
        if($ret === FALSE)
        {
            $this->session->set_flashdata('error', 
                    lang_check('Removing reservation disabled, because already paid!'));
        }
        
        redirect('admin/booking');
	}
    
    public function delete_withdrawal($id)
    {
        if($this->config->item('app_type') == 'demo')
        {
            $this->session->set_flashdata('error', 
                    lang('Data editing disabled in demo'));
            redirect('admin/booking/withdrawals');
            exit();
        }
        
        if($this->session->userdata('type') == 'ADMIN')
        {
            $this->load->model('withdrawal_m');
            $this->withdrawal_m->delete($id);
        }
        
        redirect('admin/booking/withdrawals');
    }
    
    public function _check_availability($str)
    {   
        $id = $this->uri->segment(4);
        $date_from = $this->input->post('date_from');
        $date_to = $this->input->post('date_to');
        $property_id = $this->input->post('property_id');
        $currency_code = $this->input->post('currency_code');
  
        // check 'from' before 'to', 'from' after 'now'
        if(strtotime($date_from) < time() || strtotime($date_to) < strtotime($date_from))
        {
            $this->form_validation->set_message('_check_availability', lang_check('Please correct dates'));
            return FALSE;
        }

        $is_booked = $this->reservations_m->is_booked($property_id, $date_from, $date_to, $id);
        
        if(count($is_booked) > 0)
        {
            $this->form_validation->set_message('_check_availability', lang_check('Dates already booked'));
            return FALSE;
        }
        
        $changeover_day = $this->reservations_m->changeover_day($property_id, $date_from);
        if($changeover_day  === FALSE)
        {
            $this->form_validation->set_message('_check_availability', lang_check('Changeover day condition is not met'));
            return FALSE;
        }
        
        $min_stay = $this->reservations_m->min_stay($property_id, $date_from, $date_to);
        
        if($min_stay  === FALSE)
        {
            $this->form_validation->set_message('_check_availability', lang_check('Min. stay condition is not met'));
            return FALSE;
        }
        
        $booking_price = $this->reservations_m->calculate_price($property_id, $date_from, $date_to, $currency_code);

        if($booking_price  === FALSE)
        {
            $this->form_validation->set_message('_check_availability', lang_check('No rates defined for selected dates and currency'));
            return FALSE;
        }

        return TRUE;
    }
    
    public function _check_exists($str)
    {   
        $id = $this->uri->segment(4);
        $date_from = $this->input->post('date_from');
        $date_to = $this->input->post('date_to');
        $property_id = $this->input->post('property_id');
  
        // check 'from' before 'to', 'from' after 'now'
        if(strtotime($date_from) < time() || strtotime($date_to) < strtotime($date_from))
        {
            $this->form_validation->set_message('_check_exists', lang_check('Please correct dates'));
            return FALSE;
        }

        $is_defined = $this->rates_m->is_defined($property_id, $date_from, $date_to, $id);
        
        if(count($is_defined) > 0)
        {
            $this->form_validation->set_message('_check_exists', lang_check('Dates already defined'));
            return FALSE;
        }

        return TRUE;
    }
    
}