<?php

class Event_confirm extends Frontend_Controller
{

	public function __construct ()
	{
		parent::__construct();
        
        $this->load->model('packages_m');
	}
    
    public function index()
    {
        echo 'index';
    }
    
    public function confirmation($event_key = NULL)
    {        
        
        if($event_key == NULL) {
            show_error(lang_check('Missing event key'));
        }
        
        $this->load->library('session');
        $this->load->model('user_m');
        
        // Login check
        if($this->user_m->loggedin() == FALSE)
        {
            redirect('frontend/login/'.$this->data['lang_code'].'?redirect_url='.current_url());
        }
        
        $this->load->library('session');
        $this->load->model('user_m');
        
        $this->data['page_body'] ='';
        
        $this->load->model('favorites_m');
        $this->load->model('gamifyevents_m');
        $this->load->model('userattend_m');
        $this->load->model('estate_m');
        
        //qr_code
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
                $this->data['page_body'] = lang_check('Event ').'<a href="'.site_url('property/'.$listing['id']).'">'.$listing_object->field_10.'</a>'. lang_check(' detected and added to attend');
            else
                $this->data['page_body'] = lang_check('Event ').'<a href="'.site_url('property/'.$listing['id']).'">'.$listing_object->field_10.'</a>'. lang_check('  already added in attend');
            
        } else {
            $this->data['page_body'] = lang_check('Event with that code missing');
        }
        
        
        // Get templates
        $templatesDirectory = opendir(FCPATH.'templates/'.$this->data['settings_template'].'/components');
        // get each template
        $template_prefix = 'page_';
        while($tempFile = readdir($templatesDirectory)) {
            if ($tempFile != "." && $tempFile != ".." && strpos($tempFile, '.php') !== FALSE) {
                if(substr_count($tempFile, $template_prefix) == 0)
                {
                    $template_output = $this->parser->parse($this->data['settings_template'].'/components/'.$tempFile, $this->data, TRUE);
                    //$template_output = str_replace('assets/', base_url('templates/'.$this->data['settings_template']).'/assets/', $template_output);
                    $this->data['template_'.substr($tempFile, 0, -4)] = $template_output;
                }
            }
        }
        
        $output = $this->parser->parse($this->data['settings_template'].'/event_confirm.php', $this->data, TRUE);
        echo str_replace('assets/', base_url('templates/'.$this->data['settings_template']).'/assets/', $output);
        exit();
    }
    
}