<?php

class Analitics extends Admin_Controller
{

	public function __construct(){
		parent::__construct();
        $this->load->model('customtemplates_m');

        // Get language for content id to show in administration
        $this->data['content_language_id'] = $this->language_m->get_content_lang();
        
        $this->data['template_css'] = base_url('templates/'.$this->data['settings']['template']).'/'.config_item('default_template_css');
	}
    
    public function index()
    {
        redirect('admin/analitics/event_stats');
    }
    
    public function event_stats()
    {
        // Load view
		$this->data['subview'] = 'admin/analitics/event_stats';
        $this->load->view('admin/_layout_main', $this->data);
    }
    
    public function event_stats2()
    {
        // Load view
		$this->data['subview'] = 'admin/analitics/event_stats2';
        $this->load->view('admin/_layout_main', $this->data);
    }
    
}