<?php

class Gamify extends Admin_Controller {
	
    public function __construct(){
		parent::__construct();
        //$this->load->model('settings_m');
        //$this->data['settings'] = $this->settings_m->get_fields();
	}
    
    public function contact()
    {
        // $this->index();
    }
    
    public function index() 
    {
    	$this->data['subview'] = 'admin/gamify/manage';
    	$this->load->view('admin/_layout_main', $this->data);
    }
    
}