<?php

class Tokenapi extends CI_Controller
{
    private $data = array();
    private $settings = array();
    
    private $key='4PcY4Dku0JkuretevfEPMnG9BGBPi';
    private $enabled=FALSE;
    
    public function __construct()
    {
        parent::__construct();
        
        if(!$this->enabled && ENVIRONMENT != 'development')exit('DISABLED');
        
        $this->load->model('settings_m');
        $this->settings = $this->settings_m->get_fields();
        
        $this->load->model('user_m');
        $this->load->model('token_m');
        
        header('Content-Type: application/json');
    }
   
	public function index()
	{
        $this->data['message'] = lang_check('Hello, API here!');

        echo json_encode($this->data);
        exit();
	}
    
    /*
    
    Example call:
    /index.php/tokenapi/authenticate/?username=admin&password=admin&key=4PcY4Dku0JkuretevfEPMnG9BGBPi
    
    */
    public function authenticate()
    {
        $this->data['message'] = lang_check('Something is wrong with request');
        $POST = $this->input->get_post(NULL, TRUE);
        //$this->data['parameters'] = $POST;

        if(isset($POST['key'], $POST['username'], $POST['password']) && $POST['key'] == $this->key)
        {
            $this->load->library('session');
            
            // Check if user exists
            if($this->user_m->login($POST['username'], $POST['password']) === TRUE)
            {
                $this->data['user_data'] = $this->user_m->user_session_data;
                
                // Generate, return token
                $token = $this->user_m->hash_token($POST['username'].$POST['password'].time().rand(1,9999));
                $this->data['token'] = $token;
                
                $ip = '';
                if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
                } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                } else {
                    $ip = $_SERVER['REMOTE_ADDR'];
                }
            
                // Delete all previous user token logs
                $this->db->where('user_id', $this->data['user_data']['id']);
                $this->db->delete('token_api');
                        
                // Save token
                $data = array();
                $data['date_last_access'] = date('Y-m-d H:i:s');
                $data['ip'] = $ip;
                $data['username'] = $POST['username'];
                $data['user_id'] = $this->data['user_data']['id'];
                $data['token'] = $this->data['token'];
                $data['other'] = '';
                $this->token_m->save($data);
                
                $this->data['message'] = lang_check('Results available');
            }
        }
        
        echo json_encode($this->data);
        exit();
    }
    
    /*
    
    Example call:
    /index.php/tokenapi/user/?token=b02ec8d9b3d7ca1bb8e9e8880245166c
    
    */
	public function user()
	{
        $this->data['message'] = lang_check('Something is wrong with request');
        $POST = $this->input->get_post(NULL, TRUE);
        
        $token = $this->token_m->get_token($POST);
        
        if(is_object($token))
        {
            $user = $this->user_m->get_by(array(
                                            'id' => $token->user_id,
                                            'activated' => 1,
                                        ), TRUE);
            $res_user = array();
            $res_user['username'] = $user->username;
            $res_user['name_surname'] = $user->name_surname;
            $res_user['address'] = $user->address;
            $res_user['phone'] = $user->phone;
            $res_user['mail'] = $user->mail;
            $res_user['type'] = $user->type;
            $res_user['language'] = $user->language;
            $res_user['description'] = $user->description;
            $res_user['image_user_filename'] = $user->image_user_filename;
            
            $this->data['results'] = $res_user;
            
            $this->data['message'] = lang_check('Results available');
        }

        echo json_encode($this->data);
        exit();
	}
    
	public function register()
	{
        $this->data['success'] = false;
        $this->data['message'] = lang_check('Hello, API here!');

        echo json_encode($this->data);
        exit();
	}
    
    /*
    
    Example call for GET:
    /index.php/tokenapi/favorites/?token=b02ec8d9b3d7ca1bb8e9e8880245166c&lang_code=en
    
    Example call for POST:
    /index.php/tokenapi/favorites/POST/?token=b02ec8d9b3d7ca1bb8e9e8880245166c&lang_code=en&property_id=8
    
    Example call for DELETE:
    /index.php/tokenapi/favorites/DELETE/?token=b02ec8d9b3d7ca1bb8e9e8880245166c&property_id=8
    
    */
	public function favorites($method='GET')
	{
        $this->load->model('language_m');
        $this->load->model('estate_m');
        $this->load->model('option_m');
        $this->load->model('favorites_m');
       
        $this->data['message'] = lang_check('Something is wrong with request');
        $POST = $this->input->get_post(NULL, TRUE);
        
        if(isset($POST['lang_code']))
        {
            $lang_id = $this->language_m->get_id($POST['lang_code']);
        }
        
        if(empty($lang_id))$lang_id=$this->language_m->get_default_id();
        $lang_code = $this->language_m->get_code($lang_id);
        
        $token = $this->token_m->get_token($POST);
        
        if(is_object($token))
        {
            if($method == 'GET')
            {
                $options = $this->option_m->get_field_list($this->language_m->get_default_id());
                
                $this->db->join('favorites', 'property.id = favorites.property_id', 'right');
                $this->db->where('user_id', $token->user_id);
                $estates = $this->estate_m->get_by(array('is_activated' => 1, 'language_id'=>$lang_id));
                
                // Set website details
                $json_data = array();
                // Add listings to rss feed     
                foreach($estates as $key=>$row){
                    $estate_date = array();
                    $title = $this->estate_m->get_field_from_listing($row, 10);
                    $url = site_url($data_tmp['listing_uri'].'/'.$row->id.'/'.$lang_code.'/'.url_title_cro($title));
                    
                    $row->json_object = json_decode($row->json_object);
                    $row->image_repository = json_decode($row->image_repository);
                    $estate_date['url'] = $url;
                    $estate_date['listing'] = $row;
                    
                    $json_data[] = $estate_date;
                }
                
                $this->data['results'] = $json_data;
                
                $this->data['message'] = lang_check('Results available');
            }
            elseif($method == 'POST' && isset($POST['property_id']))
            {
                $property_id = $POST['property_id'];
                
                $this->data['success'] = false;
                // Check if property_id already saved, stop and write message
                if($this->favorites_m->check_if_exists($token->user_id, $property_id)>0)
                {
                    $this->data['message'] = lang_check('Favorite already exists!');
                    $this->data['success'] = true;
                }
                // Save favorites to database
                else
                {
                    $data = $this->favorites_m->get_new_array();
                    $data['user_id'] = $token->user_id;
                    $data['property_id'] = $property_id;
                    $data['lang_code'] = $lang_code;
                    $data['date_last_informed'] = date('Y-m-d H:i:s');
                    
                    $this->favorites_m->save($data);
                    
                    $this->data['message'] = lang_check('Favorite added!');
                    $this->data['success'] = true;
                } 
            }
            elseif($method == 'DELETE' && isset($POST['property_id']))
            {
                $property_id = $POST['property_id'];
                
                $this->data['success'] = false;
                // Check if property_id already saved, stop and write message
                if($this->favorites_m->check_if_exists($token->user_id, $property_id)>0)
                {
                    $favorite_selected = $this->favorites_m->get_by(array('property_id'=>$property_id, 'user_id'=>$token->user_id), TRUE);
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
            }
        }

        echo json_encode($this->data);
        exit();
	}
    
    // TODO: below still need to be done

	public function searches($method='GET')
	{
        $this->data['message'] = lang_check('Hello, API here!');

        echo json_encode($this->data);
        exit();
	}
    
	public function listings($method='POST')
	{
        $this->data['message'] = lang_check('Hello, API here!');

        echo json_encode($this->data);
        exit();
	}
    
}
