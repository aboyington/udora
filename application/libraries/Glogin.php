<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Glogin {
    
    var $clientId       = '1074795606787-slb69d3dsf7i2rrcmvlc6mlcqutjlch0.apps.googleusercontent.com';
    var $clientSecret   = 'E9AVgzzxW2iaqLp_E0_xnNbD';
    var $hostedDomain   = '';
    
    public function __construct($params = array())
    {
        $this->CI = &get_instance();
        
        $this->CI->load->library('MY_Composer');
        $this->CI->load->library('session');
        $this->CI->load->model('user_m');
    }
    
    public function getProvider(){
        
        if(empty($this->hostedDomain))
        {
            $this->hostedDomain = 'http://'.$_SERVER['HTTP_HOST'];
        }
        
        $provider = new League\OAuth2\Client\Provider\Google([
            'clientId'     => $this->clientId,
            'clientSecret' => $this->clientSecret,
            'redirectUri'  => site_url('api/google_login'),
            'hostedDomain' => $this->hostedDomain,
        ]);
        
        return $provider;
    }
    
}

?>