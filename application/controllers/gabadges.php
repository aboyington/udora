<?php

class gabadges extends CI_Controller
{
    
    function __construct() {
        parent::__construct();
        
        $this->load->model('gamifybadges_m');
       
    }
    
    public function index()
    {
       
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array(
                    'status' => 'success'
            )));
            
    }
    
    public function maxlevel()
    {
       
        $maxlevel = $this->gamifybadges_m->get_max_id($query);
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array(
                    'status' => 'success',
                    'level' => $maxlevel
            )));
            
    }

}

?>