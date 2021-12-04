<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

// Library for API: https://www.clickatell.com

class Clickatellapi
{
    public $clickatell_user;
    public $clickatell_password;
    private $clickatell_api_id;

    public function __construct($params = array())
    {
        $this->clickatell_user = config_db_item('clickatell_user');
        $this->clickatell_password = config_db_item('clickatell_password');
        $this->clickatell_api_id = config_db_item('clickatell_api_id');        
        
        if(is_array($params))
        {
            if(isset($params['clickatell_user']))
                $this->clickatell_user = $params['clickatell_user'];
            
            if(isset($params['clickatell_password']))
                $this->clickatell_password = $params['clickatell_password'];
                
            if(isset($params['clickatell_api_id']))
                $this->clickatell_api_id = $params['clickatell_api_id'];
        }
    }

    public function send_sms($text, $to)
    {   
        $CI =& get_instance();
        $CI->load->helper('text');
        
        $user = $this->clickatell_user;
        $password = $this->clickatell_password;
        $api_id = $this->clickatell_api_id;
        $baseurl ="http://api.clickatell.com";
     
        $text = urlencode($text);
     
        // auth call
        $url = "$baseurl/http/auth?user=$user&password=$password&api_id=$api_id";
     
        // do auth call
        $ret = file($url);
     
        // explode our response. return string is on first line of the data returned
        $sess = explode(":",$ret[0]);
        if ($sess[0] == "OK") {
     
            $sess_id = trim($sess[1]); // remove any whitespace
            $url = "$baseurl/http/sendmsg?session_id=$sess_id&to=$to&text=$text";
     
            // do sendmsg call
            $ret = file($url);
            $send = explode(":",$ret[0]);
     
            if ($send[0] == "ID") {
                return "successnmessage ID: ". $send[1];
            } else {
                return "Send SMS message failed";
            }
        } else {
            return "Authentication failure: ". $ret[0];
        }
    }

}

?>