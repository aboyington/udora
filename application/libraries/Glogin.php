<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Glogin {

    //var $clientId       = '7976329998-d9cudrgqjbpku12a7qpv7tbbah1g2inm.apps.googleusercontent.com';
    //var $clientSecret   = 'OOvQogx177HPjlZ75w31s6ey';
    var $clientId       = '787193853488-4n3lhmavs3gd8k5n4u01ibq690efv2dj.apps.googleusercontent.com';
    var $clientSecret   = 'ZDyvizymmpJzxrJm3Rkh6AkA';
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
