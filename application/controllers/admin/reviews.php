<?php

class Reviews extends Admin_Controller
{

	public function __construct(){
		parent::__construct();
        $this->load->model('showroom_m');
        $this->load->model('rates_m');
        $this->load->model('estate_m');
        $this->load->model('file_m');
        $this->load->model('repository_m');
        $this->load->model('reviews_m');

        // Get language for content id to show in administration
        $this->data['content_language_id'] = $this->language_m->get_content_lang();
        
        $this->data['template_css'] = base_url('templates/'.$this->data['settings']['template']).'/'.config_item('default_template_css');
	}
    
        public function index($listing_id = 0, $user_id = 0, $pagination_offset=0)
	{
	    $this->load->library('pagination');
        
        $listing_selected = array();
        if($listing_id != 0)
        {
            $listing_selected['listing_id'] = $listing_id;
        }
        if($user_id != 0)
        {
            $listing_selected['user_id'] = $user_id;
        }
        
        // Fetch all pages
        $this->data['properties'] = $this->estate_m->get_form_dropdown('address');
        $this->data['listings'] = $this->reviews_m->get_joined($listing_selected);

        $config['base_url'] = site_url('admin/reviews/index/'.$listing_id.'/');
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
        
        $this->data['listings'] = $this->reviews_m->get_joined($listing_selected, $config['per_page'], NULL, $pagination_offset);
        
        // Load view
		$this->data['subview'] = 'admin/reviews/index';
        $this->load->view('admin/_layout_main', $this->data);
	}
    
    public function edit($id = NULL)
	{
	    // Fetch a page or set a new one
	    if($id)
        {
            $this->data['listing'] = $this->reviews_m->get($id);
            count($this->data['listing']) || $this->data['errors'][] = 'Could not be found';
        }
        else
        {
            $this->data['listing'] = $this->reviews_m->get_new();
        }
        
		// Pages for dropdown
        $this->data['users'] = $this->user_m->get_form_dropdown('username');
        
        //Simple way to featch only address:        
        $this->data['properties'] = $this->estate_m->get_form_dropdown('address', FALSE, TRUE, TRUE);
        

        // Set up the form
        $rules = $this->reviews_m->rules_admin;
        $this->form_validation->set_rules($rules);

        // Process the form
        if($this->form_validation->run() == TRUE)
        {
            if($this->config->item('app_type') == 'demo')
            {
                $this->session->set_flashdata('error', 
                        lang('Data editing disabled in demo'));
                redirect('admin/reviews/edit/'.$id);
                exit();
            }
            
            $data = $this->reviews_m->array_from_post(array('listing_id', 'user_id', 'stars', 'message', 'is_visible'));
            
            $id = $this->reviews_m->save($data, $id, TRUE);
            
            $this->session->set_flashdata('message', 
                    '<p class="label label-success validation">'.lang_check('Changes saved').'</p>');
            
            if(!empty($id))
            {
                redirect('admin/reviews/edit/'.$id);
            }
            else
            {
                $this->output->enable_profiler(TRUE);
            }
        }
        
        // Load the view
		$this->data['subview'] = 'admin/reviews/edit';
        $this->load->view('admin/_layout_main', $this->data);
	}

    public function allow_review () {
        
        $this->load->model('userattend_m');
        
        // Pages for dropdown
        $this->data['users'] = $this->user_m->get_form_dropdown('username');
        
        //Simple way to featch only address:        
        $this->data['properties'] = $this->estate_m->get_form_dropdown('address', FALSE, TRUE, TRUE);
        

        // Set up the form
        $rules = $this->userattend_m->rules;
        $this->form_validation->set_rules($rules);

        // Process the form
        if($this->form_validation->run() == TRUE)
        {
            if($this->config->item('app_type') == 'demo')
            {
                $this->session->set_flashdata('error', 
                        lang('Data editing disabled in demo'));
                redirect('admin/reviews/allow_review/');
                exit();
            }
            
            $data = $this->userattend_m->array_from_post(array('listing_id', 'user_id'));
            
            $data['date'] = date('Y-m-d H:i:s');
            
            
            if(!$this->userattend_m->check_notattend($data['listing_id'], $data['user_id'])) {
                $this->session->set_flashdata('message', 
                    '<p class="label label-danger validation">'.lang_check('Listing already attended').'</p>'); 
            } else {
                $id = $this->userattend_m->save($data);
                $this->session->set_flashdata('message', 
                        '<p class="label label-success validation">'.lang_check('Attended').'</p>');
                if(empty($id))
                {
                    echo 'QUERY: '.$this->db->last_query();
                    echo '<br />';
                    echo 'ERROR: '.$this->db->_error_message();
                    exit();
                }
            }
            
            redirect('admin/reviews/allow_review/');
        }
        
        // Load the view
		$this->data['subview'] = 'admin/reviews/allow_review';
        $this->load->view('admin/_layout_main', $this->data);
    }
        
    public function delete($id)
	{
        if($this->config->item('app_type') == 'demo')
        {
            $this->session->set_flashdata('error', 
                    lang('Data editing disabled in demo'));
            redirect('admin/reviews');
            exit();
        }
       
		$this->reviews_m->delete($id);
        redirect('admin/reviews');
	}
    
//    public function _check_availability($str)
//    {   
//        $id = $this->uri->segment(4);
//        $date_from = $this->input->post('date_from');
//        $date_to = $this->input->post('date_to');
//        $property_id = $this->input->post('property_id');
//        $currency_code = $this->input->post('currency_code');
//  
//        if($booking_price  === FALSE)
//        {
//            $this->form_validation->set_message('_check_availability', lang_check('No rates defined for selected dates and currency'));
//            return FALSE;
//        }
//
//        return TRUE;
//    }
    
}