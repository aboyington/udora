<?php

class Api extends CI_Controller
{
    private $data = array();
    private $settings = array();
    
    // www.mapquestapi.com api key, to generate map image for PDF export
    private $mapquest_api_key='4PcY4Dku0JA5Gd4aT9evfEPMnG9BGBPi';
    
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('settings_m');
        $this->settings = $this->settings_m->get_fields();
        
        $method = $this->uri->segment(2);
        
        if($method == 'rss')
        {
            header('Content-Type: application/rss+xml; charset=utf-8');
        }
        else
        {
            header('Content-Type: application/json');
        }
    }
   
	public function index()
	{
		echo 'Hello, API here!';
        exit();
	}
    
    /**
     * Api::translate()
     * 
     * @param string $api, mymemory | google
     * @return
     */
    public function translate($api = 'mymemory')
    {
        $this->load->model('language_m');
        
        $this->load->library('gTranslation', array());
        $this->load->library('mymemoryTranslation', array());
        
        $code_from = $this->input->get_post('from');
        $code_to = $this->input->get_post('to');
        $value = $this->input->get_post('value');
        $index = $this->input->get_post('index');
        
        if(is_numeric($code_from))
        {
            $code_from = $this->language_m->get_code($code_from);
        }
        
        if(is_numeric($code_to))
        {
            $code_to = $this->language_m->get_code($code_to);
        }
        
        $translated_value = '';
        $all_translations = array();
        
        // Fix value if HTML errors exists:
        if(function_exists('tidy'))
        {
            $tidy = new tidy();
            $value = $tidy->repairString($value);
        }
        
        if($api == 'google')
        {
            $translated_value = $this->gtranslation->translate($value, $code_from, $code_to);
        }
        else
        {
            $translated_value = $this->mymemorytranslation->translate($value, $code_from, $code_to);
        }
        
        $all_translations['result'] = $translated_value;
        
        echo json_encode($all_translations);
        exit();
    }
    
    public function export_lang_files()
    {
        $this->load->helper('file');
        $zip = new ZipArchive;
        
        $filename_zip = APP_VERSION_REAL_ESTATE.'-languages.zip';
        unlink(FCPATH.$filename_zip);
        
        $zip->open(FCPATH.$filename_zip, ZipArchive::CREATE);
        
        $lang_path = realpath(BASEPATH.'language/');
        $remove_chars = strlen(realpath(BASEPATH.'../'))+1;
        $directory_iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($lang_path));
        foreach($directory_iterator as $filename => $path_object)
        {
            if(is_file($filename))
            {
                $zip_filename = substr($filename, $remove_chars);
                $zip->addFile($filename, $zip_filename);
            }
        }
        
        $lang_path = realpath(BASEPATH.'../'.APPPATH.'language/');
        $remove_chars = strlen(realpath(BASEPATH.'../'))+1;
        $directory_iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($lang_path));
        foreach($directory_iterator as $filename => $path_object)
        {
            if(is_file($filename))
            {
                $zip_filename = substr($filename, $remove_chars);
                $zip->addFile($filename, $zip_filename);
            }
        }
        
        $lang_path = realpath(FCPATH.'templates/'.$this->settings['template'].'/language/');
        $remove_chars = strlen(realpath(FCPATH))+1;
        $directory_iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($lang_path));
        foreach($directory_iterator as $filename => $path_object)
        {
            if(is_file($filename))
            {
                $zip_filename = substr($filename, $remove_chars);
                $zip->addFile($filename, $zip_filename);
            }
        }

        $ret = $zip->close();
        
        if($ret == true)
        {
            $this->load->helper('download');
            $data = file_get_contents(FCPATH.$filename_zip); // Read the file's contents
            force_download($filename_zip, $data);
        }
        else
        {
            echo 'failed';
        }
    }
    
    public function get_level_values_select($lang_id, $field_id, $parent_id=0, $level=0)
    {
        //load language files
        $this->load->model('language_m');
        $lang_name = $this->language_m->get_name($lang_id);
        $this->lang->load('frontend_template', $lang_name, FALSE, TRUE, FCPATH.'templates/'.$this->settings['template'].'/');
        
        $this->data['message'] = lang_check('No message returned!');
        $this->data['parameters'] = $_POST;
        $parameters = json_encode($_POST);
        
        
        $this->load->model('treefield_m');
        
        $values_arr = $this->treefield_m->get_level_values ($lang_id, $field_id, $parent_id, $level);
        
        $generate_select = '';
        foreach($values_arr as $key=>$value)
        {
            $generate_select.= "<option value=\"$key\">$value</option>\n";
        }
        
        $this->data['generate_select'] = $generate_select;
        $this->data['values_arr'] = $values_arr;
        
        echo json_encode($this->data);
        exit();
    }
    
    public function get_treefield($lang_id, $field_id)
    {
        $this->load->model('language_m');
        
        if(!is_numeric($lang_id))
        {
            $lang_id = $this->language_m->get_id($lang_id);
        }
        
        if(empty($lang_id))exit("Wrong lang_code / id");
        
        $lang_name = $this->language_m->get_name($lang_id);
        $this->lang->load('frontend_template', $lang_name, FALSE, TRUE, FCPATH.'templates/'.$this->settings['template'].'/');        
        
        $this->data['message'] = lang_check('No message returned!');
        $this->data['parameters'] = $_POST;
        $parameters = json_encode($_POST);
        
        $this->load->model('treefield_m');
        $values_arr = $this->treefield_m->get_table_tree($lang_id, $field_id);
        
        $this->data['levels'] = $this->treefield_m->get_max_level($field_id);
        $this->data['values_arr'] = $values_arr;
        
        echo json_encode($this->data);
        exit();
    }
    
    public function rss($lang_code, $limit_properties=20, $offset_properties=0)
    {
        $this->load->model('language_m');
        $this->load->model('option_m');
        $this->load->model('estate_m');
        $this->load->model('file_m');
        $lang_id = $this->language_m->get_id($lang_code);
        $lang_name = $this->language_m->get_name($lang_id);
        $this->lang->load('frontend_template', $lang_name, FALSE, TRUE, FCPATH.'templates/'.$this->settings['template'].'/');
        
        if(empty($this->settings['websitetitle']))$this->settings['websitetitle'] = 'Title not defined';
        
        $this->data['listing_uri'] = config_item('listing_uri');
        if(empty($this->data['listing_uri']))$this->data['listing_uri'] = 'property';
        
        //Fetch last 20 properties
        //$options = $this->option_m->get_options($lang_id);
        
        $where = array();
        $search_array = array();
        $where['language_id']  = $lang_id;
        $where['is_activated'] = 1;
        
        $estates = $this->estate_m->get_by($where, false, $limit_properties, 'property.id DESC', $offset_properties);
        
        // Fetch all files by repository_id
//        $files = $this->file_m->get();
//        $rep_file_count = array();
//        $this->data['page_images'] = array();
//        foreach($files as $key=>$file)
//        {
//            $file->thumbnail_url = base_url('adminudora-assets/img/icons/filetype/_blank.png');
//            $file->url = base_url('files/'.$file->filename);
//            if(file_exists(FCPATH.'files/thumbnail/'.$file->filename))
//            {
//                $file->thumbnail_url = base_url('files/thumbnail/'.$file->filename);
//                $this->data['images_'.$file->repository_id][] = $file;
//            }
//        }
        
        // Set website details
        $generated_xml = '<?xml version="1.0" encoding="UTF-8" ?>';
        $generated_xml.= '<rss version="2.0">
                            <channel>
                              <title><![CDATA[ '.strip_tags($this->settings['websitetitle']).' ]]></title>
                              <link>'.site_url().'</link>
                              <description>'.$this->settings['phone'].', '.$this->settings['email'].'</description>';
        
        
        // Add listings to rss feed     
        foreach($estates as $key=>$row){
            $title_slug=$title='';
            $value = $this->estate_m->get_field_from_listing($row, 10);
            if(!empty($value))
            {
                $title = $value;
                $title_slug = url_title_cro($value);
            }
            $url = slug_url($this->data['listing_uri'].'/'.$row->id.'/'.$lang_code.'/'.$title_slug);

            $description = 'Description field removed';
            $value = $this->estate_m->get_field_from_listing($row, 8);
            if(!empty($value))
            {
                $description = $value;
            }
            
            // Thumbnail
            $thumbnail_url = '';
            if(isset($row->image_filename))
            {
                $thumbnail_url = base_url('files/thumbnail/'.$row->image_filename);
                $thumbnail_url = '<img align="left" hspace="5" src="'.$thumbnail_url.'" />';
            }
            
            $pubDate= date("r", strtotime($row->date));
            
            $generated_xml.=  '<item>
                                <title>'.strip_tags($title).'</title>
                                <link>'.$url.'</link>
                                <pubDate>'.$pubDate.'</pubDate>
                                <description>
                                    <![CDATA['.$thumbnail_url.$description.']]>
                                </description>
                              </item>';
        }

        // Close rss  
        $generated_xml.= '</channel></rss>';

        echo $generated_xml;
        exit();
    }
    
    /*
        Example call: index.php/api/json/en?
        Supported uri parameters, for pagination:
        $limit_properties=20
        $offset_properties=0
        
        Supported query parameters:
        options_hide
        v_rectangle_ne=46.3905, 16.8329
        v_rectangle_sw=45.9905, 15.999
        search={"search_option_smart":"yellow","v_search_option_2":"Apartment"}
        
        Complete example:
        index.php/api/json/en/20/0?options_hide&search={"search_option_smart":"cestica"}&v_rectangle_ne=46.3905, 16.8329&v_rectangle_sw=45.9905, 15.999
        Example for "from":
        {"v_search_option_36_from":"60000"}
        Example for indeed value:
        {"v_search_option_4":"Sale and Rent"}
        Example for featured:
        {"v_search_option_is_featured":"trueIs Featured"}
    */
    public function json($lang_code=null, $limit_properties=20, $offset_properties=0)
    {
        if($lang_code == NULL)
            exit('Wrong API call!');
        
        $this->data['message'] = lang_check('No message returned!');
        $this->data['parameters'] = $search = $this->input->get_post('search');
        $options_hide = $this->input->get_post('options_hide');
        
        
        $this->load->model('language_m');
        $this->load->model('option_m');
        $this->load->model('estate_m');
        $this->load->model('file_m');
        $lang_id = $this->language_m->get_id($lang_code);
        $lang_name = $this->language_m->get_name($lang_id);
        $this->lang->load('frontend_template', $lang_name, FALSE, TRUE, FCPATH.'templates/'.$this->settings['template'].'/');
        
        if(empty($this->settings['websitetitle']))$this->settings['websitetitle'] = 'Title not defined';
        
        $data_tmp['listing_uri'] = config_item('listing_uri');
        if(empty($data_tmp['listing_uri']))$data_tmp['listing_uri'] = 'property';
        
        $search_array = array();
        if(!empty($search))
        {
            $search_array = json_decode($search);

            if(empty($search_array) && is_string($search))
            {
                $search_array['v_search_option_smart'] = $search;
            }
        }
        
        if(is_object($search_array))
            $search_array = (array) $search_array;
        
        $purpose = "";
        if(is_array($search_array) && isset($search_array['v_search_option_4']))
        {
            $purpose = $search_array['v_search_option_4'];
        }
        
        $order_by = NULL;
        $options_order = $this->input->get_post('order');
        if(!empty($options_order))
        {
            $order_by = $options_order;
            
            if(strpos($purpose, lang_check('Rent')) !== FALSE)
            {
                $order_by = str_replace("price", "field_37_int", $order_by);
            }
            
            $order_by = str_replace("price", "field_36_int", $order_by);
        }
        
        // Rent price support
        if(strpos($purpose, lang_check('Rent')) !== FALSE)
        {
            if(isset($search_array['v_search_option_36_from']))
                $search_array['v_search_option_37_from'] = $search_array['v_search_option_36_from'];
            if(isset($search_array['v_search_option_36_to']))
                $search_array['v_search_option_37_to'] = $search_array['v_search_option_36_to'];
            unset($search_array['v_search_option_36_from'], $search_array['v_search_option_36_to']);
        }
        
        $where = array('is_activated' => 1, 'language_id' => $lang_id);

        if(isset($this->settings['listing_expiry_days']))
        {
            if(is_numeric($this->settings['listing_expiry_days']) && $this->settings['listing_expiry_days'] > 0)
            {
                 $where['property.date_modified >']  = date("Y-m-d H:i:s" , time()-$this->settings['listing_expiry_days']*86400);
            }
        }

        //Fetch last 20 properties
        //$options = $this->option_m->get_options($lang_id);
        
        $this->data['total_results'] = $this->estate_m->count_get_by($where, false, NULL, NULL, NULL, $search_array);
        
        $estates = $this->estate_m->get_by($where, false, $limit_properties, $order_by, $offset_properties, $search_array, NULL, FALSE, TRUE);
        
        $this->data['field_details'] = NULL;
        if(!empty($options_hide))
        {
            $this->data['field_details'] = $this->option_m->get_lang(NULL, FALSE, $lang_id);

            $this->load->model('treefield_m');
            
            foreach($this->data['field_details'] as $row)
            {
                if($row->type == 'TREE')
                {
                    $levels = $this->treefield_m->get_max_level($row->id);
                    $tree   = $this->treefield_m->get_table_tree($lang_id, $row->id);
                    
                    $new_tree = array();
                    foreach($tree as $row_tree)
                    {
                        $new_tree[] = $row_tree;
                    }
                    
                    $this->data['tree_'.$row->id]['levels'] = $levels+1;
                    $this->data['tree_'.$row->id]['tree']   = $new_tree;
                }
            }
        }
        
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
        
        echo json_encode($this->data);
        exit();
    }
    
    public function google_login($lang_id = NULL)
    {
		
	
        if (version_compare(phpversion(), '5.5.0', '>=')) {
        } else {
            exit('PHP version 5.5 is required for google login');
        }
        
        if(!file_exists(APPPATH.'libraries/Glogin.php'))
        {
            exit('Google login modul is not available');
        }

        $this->load->model('language_m');
        
        if(empty($lang_id))
            $lang_id = $this->language_m->get_default_id();
        
        $lang_code = $this->language_m->get_code($lang_id);
        $lang_name = $this->language_m->get_name($lang_id);
        
        $this->load->library('Glogin');

        $provider = $this->glogin->getProvider();
        
        if (!empty($_GET['error'])) {
            // Got an error, probably user denied access
            exit('Got error: ' . $_GET['error']);
        
        } elseif (empty($_GET['code'])) {
        
            // If we don't have an authorization code then get one
            $authUrl = $provider->getAuthorizationUrl();
            $this->session->set_flashdata('oauth2state', $provider->getState());
            
            header('Location: ' . $authUrl);
            exit;
        
        } elseif (empty($_GET['state']) || ($_GET['state'] !== $this->session->flashdata('oauth2state'))) {
        
            // State is invalid, possible CSRF attack in progress
            //unset($_SESSION['oauth2state']);
            
            $this->user_m->logout();
            
            exit('Invalid state');
        
        } else {
        
            // Try to get an access token (using the authorization code grant)
            $token = $provider->getAccessToken('authorization_code', array(
                'code' => $_GET['code']
            ));
        
            // Optional: Now you have a token you can look up a users profile data
            try {
                // We got an access token, let's now get the owner details
                $ownerDetails = $provider->getResourceOwner($token);
//array(5) {
//  ["emails"]=>
//  array(1) {
//    [0]=>
//    array(1) {
//      ["value"]=>
//      string(22) ""
//    }
//  }
//  ["id"]=>
//  string(21) ""
//  ["displayName"]=>
//  string(12) ""
//  ["name"]=>
//  array(2) {
//    ["familyName"]=>
//    string(6) ""
//    ["givenName"]=>
//    string(5) ""
//  }
//  ["image"]=>
//  array(1) {
//    ["url"]=>
//    string(98) ""
//  }
//}
                $user_array = $ownerDetails->toArray();
                $user_email = $ownerDetails->getEmail();
                $user_namesurname = $ownerDetails->getFirstName();
                $user_avatar = $ownerDetails->getAvatar();
                
          
                // Register / Login
                $user_get = $this->user_m->get_by(array('password'=>$this->user_m->hash($user_array['id']), 
                                                        'username'=>$user_email), true);
                
                if(count($user_get) == 0)
                {
                    // Check if email already exists
                    if($this->user_m->if_exists($user_email) === TRUE)
                    {
                        exit('Email already exists in database, please contact administrator or reset password');
                    }
                    
                    // Register user
                    $data_f = array();
                    $data_f['username'] = $user_email;
                    $data_f['mail'] = $user_email;
                    $data_f['password'] = $this->user_m->hash($user_array['id']);
                    $data_f['facebook_id'] = '';
                    $data_f['type'] = 'USER';
                    $data_f['name_surname'] = $user_namesurname;
                    $data_f['activated'] = '1';
                    $data_f['description'] = '';
                    $data_f['language'] = $lang_name;
                    $data_f['registration_date'] = date('Y-m-d H:i:s');
                    $data_f['mail_verified'] = 0;
                    $data_f['phone_verified'] = 0;               

                    if($this->config->item('def_package') !== FALSE)
                    {
                        $data_f['package_id'] = $this->config->item('def_package');
                        
                        $this->load->model('packages_m');
                        $package = $this->packages_m->get($data_f['package_id']);
                        
                        if(is_object($package))
                        {
                            $days_extend = $package->package_days;
                        
                            if($days_extend > 0)
                                $data_f['package_last_payment'] = date('Y-m-d H:i:s', time() + 86400*intval($days_extend));
                        }
                    }      

                    $user_id = $this->user_m->save($data_f, NULL);
										
							
                    if(!empty($user_avatar)){
                        $user_avatar = str_replace('?sz=50', '', $user_avatar);
                        $this->load->model('repository_m');
                        $this->load->model('file_m');
                        $this->load->library('uploadHandler', array('initialize'=>FALSE));

                        $user_data = $this->user_m->get($user_id);
                        // Fetch file repository
                        $repository_id = $user_data->repository_id;
                        if(empty($repository_id))
                        {
                            // Create repository
                            $repository_id = $this->repository_m->save(array('name'=>'user_m'));
                            // Update with new repository_id
                            $this->user_m->save(array('repository_id'=>$repository_id), $user_data->id);
                        }

                        $file_name = '';
                        
                        $handle   = curl_init($user_avatar);
                        curl_setopt($handle, CURLOPT_HEADER, false);
                        curl_setopt($handle, CURLOPT_FAILONERROR, true);  // this works
                        curl_setopt($handle, CURLOPT_HTTPHEADER, Array("User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.15) Gecko/20080623 Firefox/2.0.0.15") ); // request as if Firefox
                        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($handle, CURLOPT_FOLLOWLOCATION, true);
                        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 3);
                        $file = curl_exec($handle);
                        ##print $connectable;
                        curl_close($handle);
                        $image_info = getimagesizefromstring($file);
											
                        $extension ='';
                        switch ($image_info['mime']) {
                            case 'image/gif':
                                            $extension = '.gif';
                                            break;
                            case 'image/jpeg':
                                            $extension = '.jpg';
                                            break;
                            case 'image/png':        
                                            $extension = '.png';
                                            break;
                            default:
                                            // handle errors
                                            break;
                        }
                        $new_file_name=time().rand(000, 999).$extension;
                        file_put_contents(FCPATH.'/files/'.$new_file_name, $file);
                        /* create thumbnail */
                        $this->uploadhandler->regenerate_versions($new_file_name);
                        /* end create thumbnail */
                        $file_name= $new_file_name;
                        $next_order=0;
                        $file_id = $this->file_m->save(array(
                        'repository_id' => $repository_id,
                        'order' => $next_order,
                        'filename' => $file_name,
                        )); 
                        $next_order++;
                    }
									
                }
                
                // Login :: AUTO
                if($this->user_m->login($user_email, $user_array['id']) == TRUE)
                {
                    if(!empty($user_id) && 
                        config_item('registration_interest_enabled') === TRUE && 
                        config_item('tree_field_enabled') === TRUE)
                    {
                        redirect('fresearch/treealerts/'.$lang_code.'/'.$user_id.'/'.md5($user_id.config_item('encryption_key')));
                    }
                    
                    redirect('frontend/myproperties/'.$lang_code);
                    exit();
                }
                else
                {
                    $this->session->set_flashdata('error', 
                            lang_check('That email/password combination does not exists'));
                    redirect('frontend/login/'.$lang_code); 
                    exit();
                }
        
            } catch (Exception $e) {
        
                // Failed to get user details
                exit('Something went wrong: ' . $e->getMessage());
        
            }
        
            // Use this to interact with an API on the users behalf
            // echo $token->accessToken;
        
            // Use this to get a new access token if the old one expires
            //echo $token->refreshToken;
        
            // Number of seconds until the access token will expire, and need refreshing
            //echo $token->expires;
        }
        
        exit();
    }
    
    /* 
     * Use for add property to compare list, use with Controller propertycompare.php
     * 
     */
    public function add_to_compare ($lang_code='en') {
        
        $this->load->model('language_m');
        $lang_id = $this->language_m->get_id($lang_code);
        $lang_name = $this->language_m->get_name($lang_id);
        $this->lang->load('frontend_template', $lang_name, FALSE, TRUE, FCPATH.'templates/'.$this->settings['template'].'/');
                
        /* config */
        $max_properties=4;   
        /* end  config */
        
        $this->load->library('session');
        $this->load->model('option_m');
        $this->load->model('language_m');
        $json_data['success'] = false;
        /*$ses=$this->session->userdata('property_compare');
        // if max property
        if(count($ses)>=$max_properties) {
            $json_data['message'] = lang_check('Added max propery');
            echo json_encode($json_data);
            exit();
        }*/
       
        /* data */
        
        $this->data['post'] = $_POST;
        // lang id and code
        if(empty($lang_code)) $lang_code= $this->language_m->get_default();
        $lang_id = $this->language_m->get_id($lang_code);
        
        $title_option_id=10;
        /* end data */
        
        $json_data=array();
            
        $id_property= trim($this->data['post']['property_id']);
        if(empty($id_property)) {
            $json_data['message'] = lang_check('Parameters not defined!');
            echo json_encode($json_data);
            exit();
        }
        
        // get title
        $title= $this->option_m->get_property_value($lang_id, $id_property, $title_option_id);
        if(empty($title)) {
            $json_data['message'] = lang_check('Parameters not defined!');
            echo json_encode($json_data);
            exit();
        }
        $this->data['listing_uri'] = 'property';
        if(config_item('listing_uri'))
            $this->data['listing_uri'] = config_item('listing_uri');
        //get other compare in session
        $data_sess['property_compare'] = $this->session->userdata('property_compare');
        $data_sess['property_compare'][$id_property] = $title;
        
         $json_data['remove_first']=false;
        if(count($data_sess['property_compare'])>$max_properties) {
            reset($data_sess['property_compare']);
            unset($data_sess['property_compare'][key($data_sess['property_compare'])]);
            $json_data['remove_first']=true;
        }
        
        $this->session->set_userdata($data_sess);
        
        // answere
        $json_data['message'] = lang_check('Propery added to compare');
        $json_data['property'] = $id_property.', '.$title;
        $json_data['property_id'] = $id_property;
        $json_data['property_url'] = slug_url($this->data['listing_uri'].'/'.$id_property.'/'.$lang_code.'/'.url_title_cro($title));
        $json_data['success'] = true;
              //  print_r($this->session->userdata('property_compare'));
       echo json_encode($json_data);
    exit();
   } 
    
    /* 
     * Use for remove property from compare list, use with Controller propertycompare.php
     * 
     */
    public function remove_from_compare($lang_code='en') {
        $this->load->model('language_m');
        $lang_id = $this->language_m->get_id($lang_code);
        $lang_name = $this->language_m->get_name($lang_id);
        $this->lang->load('frontend_template', $lang_name, FALSE, TRUE, FCPATH.'templates/'.$this->settings['template'].'/');
        
        /* data */
        $this->load->library('session');
        $this->data['post'] = $_POST;
        /* end data */
        $this->data['success'] = false;
        $json_data=array();
        $this->load->model('option_m');
        $this->load->model('language_m');
            
        $id_property= trim($this->data['post']['property_id']);
        if(empty($id_property)) {
            $json_data['message'] = lang_check('Parameters not defined!');
            $json_data['success'] = true;
            return false;
        }
        
        
        //get other compare in session
        $data_sess['property_compare'] = $this->session->userdata('property_compare');
        unset($data_sess['property_compare'][$id_property]);
        $this->session->set_userdata($data_sess);
        // answere
        $json_data['message'] = lang_check('Propery remove from compare');
        $json_data['property_id'] = $id_property;
        $json_data['success'] = true;
       echo json_encode($json_data);
    exit();
   } 
    
  public function pdf_export($property_id = '', $lang_code = 'en') {
        
        $this->load->model('language_m');
        $lang_id = $this->language_m->get_id($lang_code);
        $lang_name = $this->language_m->get_name($lang_id);
        $this->lang->load('frontend_template', $lang_name, FALSE, TRUE, FCPATH.'templates/'.$this->settings['template'].'/');
        
        if(empty($property_id)) {
           exit(lang_check('Listing not found'));
        }
        $this->load->library('pdf');
        $this->pdf->generate_by_property($property_id, $lang_code, $this->mapquest_api_key);
    }
    
    public function save_weather_cache ($property_id = NULL, $lang_code = 'en')  {
        $json_data['success'] = false;
        
        $this->load->model('language_m');
        $lang_id=$this->language_m->get_id($lang_code);
        $value = $_POST['value'];
        $weather_api = $_POST['weather_api'];
        echo $weather_api;
        $this->load->model('weathercacher_m');
        if($this->weathercacher_m->cache($property_id, $lang_id, $value, $weather_api)) {
            $json_data['success'] = true;
            echo json_encode($json_data);
        }
        else {
            $json_data['success'] = false;
            echo json_encode($json_data);
        }
        
    exit();   
    }
    
    public function get_all_counters($lang_id, $form_id)
    {
        //load language files
        $this->load->model('language_m');
        $lang_name = $this->language_m->get_name($lang_id);
        $this->lang->load('frontend_template', $lang_name, FALSE, TRUE, FCPATH.'templates/'.$this->settings['template'].'/');
        
        $this->data['message'] = lang_check('No message returned!');
        
        unset($_POST['v_undefined']);
        
        $this->data['parameters'] = $_POST;
        $parameters = json_encode($_POST);
        
        $this->data['parameters']['is_activated'] = 1;
        
        // Fetch all fields in search form
        $this->load->model('forms_m');  
        $form = $this->forms_m->get($form_id);
        $fields_value_json_1 = $form->fields_order_primary;
        $fields_value_json_1 = htmlspecialchars_decode($fields_value_json_1);
    
        $obj_widgets = json_decode($fields_value_json_1);
        
        $all_ids = array();
        
        if(is_object($obj_widgets->PRIMARY))
        {
            foreach($obj_widgets->PRIMARY as $key=>$obj)
            {
                if($obj->type == 'CHECKBOX')
                {
                    $all_ids[$obj->id] = $obj->id;
                }
            }
        }
        
        if(is_object($obj_widgets->SECONDARY))
        {
            foreach($obj_widgets->SECONDARY as $key=>$obj)
            {
                if($obj->type == 'CHECKBOX')
                {
                    $all_ids[$obj->id] = $obj->id;
                }
            }
        }
        
        $this->data['all_ids'] = $all_ids; // for test
        
        $this->load->model('estate_m');
        
        $this->data['lang_id'] = $lang_id;
        
        $this->data['counters'] = $this->estate_m->get_all_counters($lang_id, $all_ids, $this->data['parameters']);
        
        echo json_encode($this->data);
        exit();
    }

    
    public function xml2u ($lang_code = 'en', $limit_properties=NULL, $offset_properties=0) {
        $this->load->library('session');
        if(!file_exists(APPPATH.'libraries/Xml2u.php') && $this->session->userdata('type') && $this->session->userdata('type')=='ADMIN') {
            exit('XML2U modul is not installed');
        }
        
        $this->load->library('xml2u');

        header("Content-type: text/xml");
        echo $this->xml2u->export($lang_code, $limit_properties, $offset_properties);
        exit();
    }
    
    public function login_form($lang_code = 'en') {
        $this->data['success'] = false;
        $this->load->model('user_m');
        $this->load->library('session');
        $this->load->model('language_m');
        $this->load->library('form_validation');
        if($lang_code != NULL){
            $lang_name = $this->language_m->get_name($lang_code);
            $this->lang->load('frontend_template', $lang_name, FALSE, TRUE, FCPATH.'templates/'.$this->settings['template'].'/');
        }
        
        $error='';
        $redirect=false;

        // Set form
        $rules = $this->user_m->rules;
        $this->form_validation->set_rules($rules);

        // Process form
        if($this->form_validation->run() == TRUE)
        {
            // We can login and redirect
            if($this->user_m->login() == TRUE)
            {

                if(file_exists(APPPATH.'controllers/admin/booking.php') && 
                   $this->config->item('reservations_disabled') === FALSE &&
                   $this->config->item('user_login_to_reservations') === TRUE)
                {
                    $redirect = site_url('frontend/myreservations/'.$lang_code);
                }

                $this->data['success'] = true;
                $redirect = site_url('/'.$lang_code);
            }   
            else
            {
                $error .= '<p class="alert alert-danger">'.lang_check('That email/password combination does not exist').'</p>';
            }
        }
        else
        {
            $error .= validation_errors();
        }
        
            
        $this->data['redirect'] = $redirect;
        $this->data['errors'] = $error;
        echo json_encode($this->data);
        exit();
    }
    
    public function register_form($lang_code = 'en') {
        $this->data['success'] = false;
        $this->load->model('user_m');
        $this->load->library('session');
        $this->load->model('language_m');
        $this->load->library('form_validation');
        if($lang_code != NULL){
            $lang_name = $this->language_m->get_name($lang_code);
            $this->lang->load('frontend_template', $lang_name, FALSE, TRUE, FCPATH.'templates/'.$this->settings['template'].'/');
        }
        
        $error='';
        $redirect=false;

        $this->data['is_registration'] = true;

        $rules = $this->user_m->rules_admin;
        $rules['name_surname']['label'] = 'lang:FirstLast';
        $rules['password']['rules'] .= '|required';
        $rules['type']['rules'] = 'trim';
        $rules['language']['rules'] = 'trim';
        $rules['mail']['label'] = 'lang:Email';
        $rules['mail']['rules'] .= '|valid_email';
        if($this->config->item('register_reduced') == TRUE)
        {
            $rules['name_surname']['rules'] = 'trim|xss_clean';
            $rules['username']['rules'] = 'trim|xss_clean';

            $e_mail = $this->input->post('mail');
            if(!empty($e_mail))
            {
                if(empty($_POST['username']))
                    $_POST['username'] = $e_mail;
                if(empty($_POST['name_surname']))
                    $_POST['name_surname'] = $e_mail;
            }
        }

        if(isset($_POST['password']))
            $_POST['password_confirm'] = $_POST['password'];
/*
        if($this->config->item('captcha_disabled') === FALSE)
            $rules['captcha'] = array('field'=>'captcha', 'label'=>'lang:Captcha', 
                                      'rules'=>'trim|required|callback_captcha_check|xss_clean');
*/
        if($this->config->item('recaptcha_site_key') !== FALSE || TRUE)
            $rules['g-recaptcha-response'] = array('field'=>'g-recaptcha-response', 'label'=>'lang:Recaptcha', 
                                                    'rules'=>'trim|required|callback_captcha_check|xss_clean');

        $this->form_validation->set_rules($rules);

        // Process the form
        if($this->form_validation->run() == TRUE)
        {

            $data = $this->user_m->array_from_post(array('name_surname', 'mail', 'password', 'username',
                                                         'address', 'description', 'mail', 'phone','phone2', 'type', 'language', 'activated', 'type','age','gender'));
           /*dump($_POST);
           dump($data);*/
            if($data['password'] == '')
            {
                unset($data['password']);
            }
            else
            {
                $data['password'] = $this->user_m->hash($data['password']);
            }

            if($data['type'] == 'AGENT' && config_db_item('dropdown_register_enabled') === TRUE)
            {
                $data['type'] = 'AGENT';
            }
            else
            {
                $data['type'] = 'USER';
            }

            $data['activated'] = '1';
            if(config_db_item('email_activation_enabled') === TRUE)
                $data['activated'] = '0';

            $data['description'] = '';
            $data['registration_date'] = date('Y-m-d H:i:s');
            $data['mail_verified'] = 0;
            $data['phone_verified'] = 0;

            if(empty($data['phone']))$data['phone'] = '';
            if(empty($data['phone2']))$data['phone2'] = '';
            if(empty($data['address']))$data['address'] = '';

            if($this->config->item('def_package') !== FALSE && $data['type'] == 'USER')
            {
                $data['package_id'] = $this->config->item('def_package');

                $this->load->model('packages_m');
                $package = $this->packages_m->get($data['package_id']);

                if(is_object($package))
                {
                    $days_extend = $package->package_days;

                    if($days_extend > 0)
                        $data['package_last_payment'] = date('Y-m-d H:i:s', time() + 86400*intval($days_extend));
                }
            }

            if($this->config->item('def_package_agent') !== FALSE && $data['type'] == 'AGENT')
            {
                $data['package_id'] = $this->config->item('def_package_agent');

                $this->load->model('packages_m');
                $package = $this->packages_m->get($data['package_id']);

                if(is_object($package))
                {
                    $days_extend = $package->package_days;

                    if($days_extend > 0)
                        $data['package_last_payment'] = date('Y-m-d H:i:s', time() + 86400*intval($days_extend));
                }
            }

            $user_id = $this->user_m->save($data, NULL);

            $message_mail = '';

            if(!empty($data['mail']) && config_db_item('email_activation_enabled') === TRUE)
            {
                $data['mail_verified'] = 0;
                // [START] Activation email

                //if(ENVIRONMENT != 'development')
                $this->load->library('email');
                $config_mail['mailtype'] = 'html';
                $this->email->initialize($config_mail);
                $this->email->from($this->settings['noreply'], lang_check('Your friends at Udora'));
                $this->email->to($data['mail']);

                $this->email->subject(lang_check('Please confirm your email address'));

                $new_hash = substr($this->user_m->hash($data['mail'].$user_id), 0, 5);

                $data_m = array();
                $data_m['name_surname'] = $data['name_surname'];
                $data_m['username'] = $data['username'];
                $data_m['activation_link'] = '<a href="'.site_url('admin/user/verifyemail/'.$user_id.'/'.$new_hash).'">'.lang_check('Activate your account').'</a>';
                $data_m['activation_link_url'] = site_url('admin/user/verifyemail/'.$user_id.'/'.$new_hash);
                $data_m['login_link'] = '<a href="'.site_url('frontend/login/').'?username='.$data['username'].'#content">'.lang_check('login_link').'</a>';

                $message = $this->load->view('email/email_activation', array('data'=>$data_m), TRUE);

                $this->email->message($message);
                if ( ! $this->email->send())
                {
                    $message_mail = ', '.lang_check('Problem sending email to user');
                }
                // [END] Activation email
            }

            if(!empty($data['phone']) && !empty($user_id) &&
               config_db_item('clickatell_api_id') != FALSE && config_db_item('phone_verification_enabled') === TRUE &&
               file_exists(APPPATH.'libraries/Clickatellapi.php'))
            {
                $data['phone_verified'] = 0;

                //Send SMS for phone verification
                $new_hash = substr($this->user_m->hash($data['phone'].$user_id), 0, 5);

                $message='';
                $message.=lang_check('Your code').": \n";
                $message.=$new_hash."\n";
                $message.=lang_check('Verification link').": \n";
                $message.=site_url('admin/user/verifyphone/'.$user_id.'/'.$new_hash);

                $this->load->library('clickatellapi');
                $return_sms = $this->clickatellapi->send_sms($message, $data['phone']);

                if(substr_count($return_sms, 'successnmessage') == 0)
                {
                    // nginx causing error 502
                    // $this->session->set_flashdata('error_sms', $return_sms);
                }
            }

            if(config_db_item('email_activation_enabled') !== FALSE)
            {
                $this->data['message'] =
                        lang_check('Thanks on registration, please check and activate your email to login').$message_mail;
            }
            else
            {
                $this->data['message'] =
                        lang_check('Thanks on registration, you can login now').$message_mail;
            }

            if(!empty($user_id) && 
                config_item('registration_interest_enabled') === TRUE && 
                config_item('tree_field_enabled') === TRUE)
            {
                $redirect = site_url('fresearch/treealerts/'.$this->data['lang_code'].'/'.$user_id.'/'.md5($user_id.config_item('encryption_key')));
            }

            $this->data['success'] = true;
        }
        else {
            $error .= validation_errors();
        }
				
				if(config_db_item('email_activation_enabled') !== FALSE)
				{
					$redirect = false;
				}
				
        $this->data['redirect'] = $redirect;
        $this->data['errors'] = $error;
        echo json_encode($this->data);
        exit();
    }

    
    public function repository_check($str)
	{
        $this->load->model('file_m');
            $file_rep = $this->file_m->get_by(array('repository_id'=>$str));
            
            if (empty($file_rep))
            {
                    $this->form_validation->set_message('repository_check', lang_check('Please upload ID card copy'));
                    return FALSE;
            }
            else
            {
                    return TRUE;
            }
	}
        
        
    public function _unique_mail($str)
    {
        // Do NOT validate if mail alredy exists
        // UNLESS it's the mail for the current user
        $this->load->model('user_m');
        $id = $this->session->userdata('id');
        $this->db->where('mail', $this->input->post('mail'));
        !$id || $this->db->where('id !=', $id);
        
        $user = $this->user_m->get();
        
        if(count($user))
        {
            $this->form_validation->set_message('_unique_mail', '%s '.lang_check('should be unique'));
            return FALSE;
        }
        
        return TRUE;
    }
        
    public function get_repository_id($model='user_m') {
        $this->data['success'] = false;
        $this->load->model('repository_m');
        
        // Create new repository
        $repository_id = $this->repository_m->save(array('name'=>$model, 'is_activated'=>0));
        
        if($repository_id){
            $this->data['success'] = true;
            $this->data['repository_id'] = $repository_id;
        } else {
            $this->data['message'] = lang_check("Images can't upload please contact with administrator");
        }
        echo json_encode($this->data);
        exit();
    }

	public function captcha_check($str)
	{
        if($this->config->item('recaptcha_site_key') !== FALSE)
        {
            if(valid_recaptcha() === TRUE)
            {
                return TRUE;
            }
            else
            {
                $this->form_validation->set_message('captcha_check', lang_check('Robot verification failed'));
                return FALSE;
            }
        }
       
		if ($str != substr(md5($this->data['captcha_hash_old'].config_item('encryption_key')), 0, 5))
		{
			$this->form_validation->set_message('captcha_check', lang_check('Wrong captcha'));
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
        
    function generate_property_popup($property_id =NULL, $lang_code='en', $json_output = false)
    {
        if($property_id === NULL) return false;
        
        $this->load->model('language_m');
        $this->load->model('option_m');
        $this->load->model('estate_m');
        $this->load->model('file_m');
        $this->load->model('user_m');
        $this->load->helper('text_helper');
        $lang_id=$this->language_m->get_id($lang_code);
        
        $lang_name = $this->language_m->get_name($lang_code);
        $this->lang->load('frontend_template', $lang_name, FALSE, TRUE, FCPATH.'templates/'.$this->settings['template'].'/');
        
        //Get template settings
        $template_name = $this->settings['template'];
        
        $options_name = $this->option_m->get_lang(NULL, FALSE, $lang_id);
        $this->data['options_name'] = &$options_name;
        $option_categories = array();
        $estate = array();
        foreach($options_name as $key=>$row)
        {
            $estate['options_obj_'.$row->option_id] = $row;
            $estate['options_name_'.$row->option_id] = $row->option;
            $estate['options_suffix_'.$row->option_id] = $row->suffix;
            $estate['options_prefix_'.$row->option_id] = $row->prefix;
            $estate['category_options_'.$row->parent_id][$row->option_id]['option_name'] = $row->option;
            $estate['category_options_'.$row->parent_id][$row->option_id]['option_type'] = $row->type;
            $estate['category_options_'.$row->parent_id][$row->option_id]['option_suffix'] = $row->suffix;
            $estate['category_options_'.$row->parent_id][$row->option_id]['option_prefix'] = $row->prefix;
            
            $estate['category_options_'.$row->parent_id][$row->option_id]['is_checkbox'] = array();
            $estate['category_options_'.$row->parent_id][$row->option_id]['is_dropdown'] = array();
            $estate['category_options_'.$row->parent_id][$row->option_id]['is_text'] = array();
            $estate['category_options_'.$row->parent_id][$row->option_id]['is_upload'] = array();
            $estate['category_options_'.$row->parent_id][$row->option_id]['is_tree'] = array();
            $estate['category_options_'.$row->parent_id][$row->option_id]['is_pedigree'] = array();
            $estate['options_values_arr_'.$row->option_id] = explode(',', $row->values);
            $estate['category_options_count_'.$row->parent_id] = 0;
            
            $this->data['options_obj_'.$row->option_id] = $row;
            $this->data['options_name_'.$row->option_id] = $row->option;
            $this->data['options_suffix_'.$row->option_id] = $row->suffix;
            $this->data['options_prefix_'.$row->option_id] = $row->prefix;
            $this->data['category_options_'.$row->parent_id][$row->option_id]['option_name'] = $row->option;
            $this->data['category_options_'.$row->parent_id][$row->option_id]['option_type'] = $row->type;
            $this->data['category_options_'.$row->parent_id][$row->option_id]['option_suffix'] = $row->suffix;
            $this->data['category_options_'.$row->parent_id][$row->option_id]['option_prefix'] = $row->prefix;
            $this->data['category_options_'.$row->parent_id][$row->option_id]['is_checkbox'] = array();
            $this->data['category_options_'.$row->parent_id][$row->option_id]['is_dropdown'] = array();
            $this->data['category_options_'.$row->parent_id][$row->option_id]['is_text'] = array();
            $this->data['category_options_'.$row->parent_id][$row->option_id]['is_upload'] = array();
            $this->data['category_options_'.$row->parent_id][$row->option_id]['is_tree'] = array();
            $this->data['category_options_'.$row->parent_id][$row->option_id]['is_pedigree'] = array();
            $this->data['options_values_arr_'.$row->option_id] = explode(',', $row->values);
            $this->data['category_options_count_'.$row->parent_id] = 0;
            
            $option_categories[$row->option_id] = $row->parent_id;
        }
        /* End fetch options names */
          /* Fetch estate data */
        $estate_obj = $this->estate_m->get_array($property_id, TRUE, array('language_id'=>$lang_id));
        
        $estate['id'] = $estate_obj['id'];
        $estate['gps'] = $estate_obj['gps'];
        $estate['address'] = $estate_obj['address'];
        $estate['date'] = $estate_obj['date'];
        $estate['repository_id'] = $estate_obj['repository_id'];
        $estate['is_featured'] = $estate_obj['is_featured'];

        $json_obj = json_decode($estate_obj['json_object']);
        foreach($options_name as $key2=>$row2)
        {
            $key1 = $row2->option_id;
            $estate['has_option_'.$key1] = array();

            if(isset($json_obj->{"field_$key1"}))
            {
                $row1 = $json_obj->{"field_$key1"};
                if(substr($row1, -2) == ' -')$row1=substr($row1, 0, -2);
                $estate['option_'.$key1] = $row1;
                $estate['option_chlimit_'.$key1] = character_limiter(strip_tags($row1), 80);
                $estate['option_icon_'.$key1] = '';

                if(!empty($row1))
                {
                    $estate['has_option_'.$key1][] = array('count'=>count($row1));

                    if($this->data['options_obj_'.$key1]->type == 'CHECKBOX' || $this->data['options_obj_'.$key1]->type == 'INPUTBOX')
                    if(!empty($this->data['options_obj_'.$key1]->image_filename))
                    {
                        $estate['option_icon_'.$key1] = '<img class="results-icon" src="'.base_url('files/'.$this->data['options_obj_'.$key1]->image_filename).'" alt="'.$row1.'"/>';;
                        $estate['icons'][]['icon']= $estate['option_icon_'.$key1];
                    }
                    elseif(file_exists(FCPATH.'templates/'.$this->data['settings_template'].
                        '/assets/img/icons/option_id/'.$key1.'.png'))
                    {
                        $estate['option_icon_'.$key1] = '<img class="results-icon" src="assets/img/icons/option_id/'.$key1.'.png" alt="'.$row1.'"/>';;
                        $estate['icons'][]['icon']= $estate['option_icon_'.$key1];
                    }
                }
            }
        }

        // [START] custom price field
        $estate['custom_price'] = '';
        if(!empty($estate_objfield_36))
            $estate['custom_price'].=$this->data['options_prefix_36'].$estate_objfield_36.$this->data['options_suffix_36'];
        if(!empty($estate_objfield_37))
        {
            if(!empty($estate['custom_price']))
                $estate['custom_price'].=' / ';
            $estate['custom_price'].=$this->data['options_prefix_37'].$estate_objfield_37.$this->data['options_suffix_37'];
        }

        if(empty($estate_objfield_37) && !empty($estate_objfield_56))
        {
            if(!empty($estate['custom_price']))
                $estate['custom_price'].=' / ';
            $estate['custom_price'].=$this->data['options_prefix_56'].$estate_objfield_56.$this->data['options_suffix_56'];
        }
        // [END] custom price field

        $estate['icon'] = 'assets/img/markers/'.$this->data['color_path'].'marker_blue.png';
        if(isset($json_obj->field_6))
        {
            if($json_obj->field_6 != '' && $json_obj->field_6 != 'empty')
            {
                // if uploaded
                $uloaded_set = false;
                if(!empty($this->data['options_obj_6']->image_gallery))
                {
                    $gallery_images = explode(',', $this->data['options_obj_6']->image_gallery);
                    $value_index = array_search($json_obj->field_6, $this->data['options_values_arr_6']);
                    if(isset($gallery_images[$value_index]) && !empty($gallery_images[$value_index]))
                    {
                        $uloaded_set=true;
                        $estate['icon'] = base_url('files/'.$gallery_images[$value_index]);
                    }
                }

                if(!$uloaded_set)
                if(file_exists(FCPATH.'templates/'.$this->data['settings_template'].
                               '/assets/img/markers/'.$this->data['color_path'].$json_obj->field_6.'.png'))
                {
                    $estate['icon'] = 'assets/img/markers/'.$this->data['color_path'].$json_obj->field_6.'.png';
                }
                elseif (file_exists(FCPATH.'templates/'.$this->data['settings_template'].
                               '/assets/img/markers/'.$estate['option_6'].'.png'))
                {
                    $estate['icon'] = 'assets/img/markers/'.$estate['option_6'].'.png';
                }
            }
        }

        // [fetch marker by type uploaded image]

        // [/fetch marker by type uploaded image]

        // Url to preview
        if(isset($json_obj->field_10))
        {
            $estate['url'] = slug_url($this->data['listing_uri'].'/'.$estate_objid.'/'.$this->data['lang_code'].'/'.url_title_cro($json_obj->field_10));
        }
        else
        {
            $estate['url'] = slug_url($this->data['listing_uri'].'/'.$estate_objid.'/'.$this->data['lang_code']);
        }

        // Thumbnail
        if(isset($estate_obj['image_filename']) and file_exists(FCPATH.'files/thumbnail/'.$estate_obj['image_filename']))
        {
            $estate['thumbnail_url'] = base_url('files/thumbnail/'.$estate_obj['image_filename']);
        }
        else
        {
            $estate['thumbnail_url'] = base_url('templates/'.$this->data['settings_template']).'/assets/img/no_image.jpg';
        }

        $estate['slideshow_property_images'] = array();
        $num=0;
        $files = $this->file_m->get_by(array(
            'repository_id' => $estate_obj['repository_id']
        ));
        
        foreach($files as $key=>$file)
        {
            if($estate_obj['repository_id'] == $file->repository_id)
            {
                $slideshow_image = array();
                $slideshow_image['num'] = $num;
                $slideshow_image['url'] = base_url('files/'.$file->filename);
                $slideshow_image['first_active'] = '';
                if($num==0)$slideshow_image['first_active'] = 'active';
                
                $estate['slideshow_property_images'][] = $slideshow_image;
                $num++;
            }
        }
        $estate['property_id'] = $estate['id'];
                
        if(!empty($json_obj))
        foreach($json_obj as $key_json=>$val)
        {
            $j_parts = explode('_',$key_json);
            $key = $j_parts[1];
            
            if($val != '')
            {
                if(substr($val, -2) == ' -')$val=substr($val, 0, -2);
                $estate['estate_data_option_'.$key] = $val;
                
                // Set Category data
                if(isset($option_categories[$key]) && empty($options[$estate_data['id']][$option_categories[$key]]))
                {
                    $estate['category_options_'.$option_categories[$key]][$key]['option_value'] = $val;
                    if(!empty($val) && !isset($categories_hidden_preview[$option_categories[$key]]))
                        $estate['category_options_count_'.$option_categories[$key]]++;
    
                    if($estate['category_options_'.$option_categories[$key]][$key]['option_type'] == 'CHECKBOX')
                    {
                        //you can define this via cms_config.php, $config['show_not_available_amenities'] = TRUE;
                        if(config_item('show_not_available_amenities') !== FALSE)
                        {
                            $estate['category_options_'.$option_categories[$key]][$key]['is_checkbox'][] = array('true'=>'true');
                        }
                        else
                        {
                            if($val == 'true')
                                $estate['category_options_'.$option_categories[$key]][$key]['is_checkbox'][] = array('true'=>'true');
                        }

                    }
                    elseif($estate['category_options_'.$option_categories[$key]][$key]['option_type'] == 'DROPDOWN' || 
                           $estate['category_options_'.$option_categories[$key]][$key]['option_type'] == 'DROPDOWN_MULTIPLE')
                    {
                        $estate['category_options_'.$option_categories[$key]][$key]['is_dropdown'][] = array('true'=>'true');
                    }
                    elseif($estate['category_options_'.$option_categories[$key]][$key]['option_type'] == 'UPLOAD')
                    {
                        $estate['category_options_'.$option_categories[$key]][$key]['is_upload'][] = array('true'=>'true');
                    }
                    elseif($estate['category_options_'.$option_categories[$key]][$key]['option_type'] == 'TREE')
                    {
                        $estate['category_options_'.$option_categories[$key]][$key]['is_tree'][] = array('true'=>'true');
                    }
                    elseif($estate['category_options_'.$option_categories[$key]][$key]['option_type'] == 'CATEGORY')
                    {
                        if($val == 'true') // hidden
                        {
                            $categories_hidden_preview[$key] = true;
                        }
                    }
                    elseif($estate['category_options_'.$option_categories[$key]][$key]['option_type'] == 'PEDIGREE')
                    {
                        $estate['category_options_'.$option_categories[$key]][$key]['is_pedigree'][] = array('true'=>'true');
                    }
                    else
                    {
                        $estate['category_options_'.$option_categories[$key]][$key]['is_text'][] = array('true'=>'true');
                    }
                    
                    $estate['category_options_'.$option_categories[$key]][$key]['option_id'] = $key;
                    
                    /* icon */
                    $estate['category_options_'.$option_categories[$key]][$key]['icon']='';
                    
                    if(!empty($estate['options_obj_'.$key]->image_filename))
                    {
                        $estate['category_options_'.$option_categories[$key]][$key]['icon']=
                        '<img src="'.base_url('files/'.$estate['options_obj_'.$key]->image_filename).'" alt="'.$val.'"/>';
                    }
                    else if(file_exists(FCPATH.'templates/'.$template_name.
                                   '/assets/img/icons/option_id/'.$key.'.png'))
                    {
                        $estate['category_options_'.$option_categories[$key]][$key]['icon']=
                        '<img src="'.base_url('templates/'.$template_name.'/assets/img/icons/option_id/'.$key.'.png').'" alt="'.$val.'"/>';
                    }
                }
            }
        }
        $estate['settings_websitetitle']= $this->settings['websitetitle'];
        $estate['lang_code']= $lang_code;
        $estate['page_current_url']= site_url('/property/'.$estate['property_id'].'/'.$lang_code);
        $estate['assets_url']= base_url('templates/'.$template_name.'/assets');
        $estate['api_private_url']=  site_url('privateapi');
        // Fetch settings
        $this->load->model('settings_m');
        $this->data['settings'] = $this->settings_m->get_fields();
        
        foreach($this->data['settings'] as $key=>$value)
        {
            if($key == 'address')
            {
                $value = str_replace('"', '\\"', $value);
            }
            
            $estate['settings_'.$key] = $value;
            
        }
        
        /* Fetch agent */
        
        $agent = $this->user_m->get_agent($estate['property_id']);
        $estate['agent'] = $agent;
        // [agent_direct feature]
        $standard_agent = true;
        if(config_db_item('agent_profile_direct') === TRUE)
        {
            $agent_direct = $this->session->userdata('agent_direct');
            $last_activity = $this->session->userdata('last_activity');

            if(is_array($agent_direct) && $agent_direct['id'] != $agent['id'])
            {
                $agent = $agent_direct;
                $standard_agent=false;
            }
            
        }
        // [/agent_direct feature]
        
        if(count($agent))
        {
            $estate['agent_name_surname'] = $agent['name_surname'];
            $estate['agent_phone'] = $agent['phone'];
            
            $$estate['agent_phone2'] = '';
            if(isset($agent['phone2']))
            $estate['agent_phone2'] = $agent['phone2'];   
            $estate['agent_mail'] = $agent['mail'];
            $estate['agent_address'] = $agent['address'];
            $estate['agent_id'] = $agent['id'];
            $estate['agent_name_title'] = url_title_cro($agent['name_surname']);
            $estate['agent_url'] = slug_url('profile/'.$agent['id'].'/'.$lang_code.'/'.$estate['agent_name_title']);
            
            $estate['agent_profile'] = $agent;
        }
        
        $estate['has_agent'] = array();
        if(count($agent))
            $estate['has_agent'][] = array('count'=>count($agent));
        
        // Thumbnail
        if(count($agent) && isset($agent['image_user_filename']))
        {
            $estate['agent_image_url'] = base_url('files/thumbnail/'.$agent['image_user_filename']);
        }
        else
        {
            $estate['agent_image_url'] = base_url('templates/'.$template_name.'/assets/img/user-agent.png');
        }
        
        if(!isset($estate['option_2']))$estate['option_2'] = '{option_2}';
        if(!isset($estate['option_4']))$estate['option_4'] = '{option_4}';
        //Load view
        if(file_exists(FCPATH.'templates/'.$template_name.'/widgets/property_popup.php'))
        {
            $output = $this->load->view($template_name.'/widgets/property_popup.php', $estate, true);
            /*$output = str_replace("'", "\'", $output);
            $output = str_replace('"', '\"', $output);
            $output = str_replace(array("\n", "\r"), '', $output);*/
        }
        
        $json = array();
        $json['message'] = lang_check('No message returned!');
        $json['html'] = $output;
        echo json_encode($json);
        exit();
    }
    
        
    public function popup_request_to_event($lang_code = 'en') {
        $this->data['success'] = false;
        $this->load->model('user_m');
        $this->load->library('session');
        $this->load->model('language_m');
        $this->load->library('form_validation');
        if($lang_code != NULL){
            $lang_name = $this->language_m->get_name($lang_code);
            $this->lang->load('frontend_template', $lang_name, FALSE, TRUE, FCPATH.'templates/'.$this->settings['template'].'/');
        }
        
        $error='';
        $redirect=false;
        $message ='';
        // Set form
        $rules = array();
        $rules['firstname'] = array('field'=>'firstname', 'label'=>'lang:First and last name', 
                                        'rules'=>'trim|required');
        $rules['email'] = array('field'=>'email', 'label'=>'lang:Mail', 
                                        'rules'=>'trim|required');

        $this->form_validation->set_rules($rules);

        // Process form
        if($this->form_validation->run() == TRUE)
        {
            $data = $this->user_m->array_from_post(array('firstname', 'email', 'message'));

            // [START] Send email

            $this->load->library('email');
            $config_mail['mailtype'] = 'html';
            $this->email->initialize($config_mail);
            $this->email->from($this->settings['noreply'], lang_check('Submit from visitor for add events to that area'));
            $this->email->to($this->settings['email']);

            $this->email->subject(lang_check(''));

            $new_hash = substr($this->user_m->hash($data['mail'].$user_id), 0, 5);

            $data_m = array();
            $data_m['name_surname'] = $data['firstname'];
            $data_m['email'] = $data['email'];
            $data_m['message'] = $data['message'];

            $message = $this->load->view('email/email_activation', array('data'=>$data_m), TRUE);

            $this->email->message($message);
            $this->email->send();
            // [END] Send email
            
            $message = lang_check('We add new events, thanks');
             $this->data['success'] = true;
        }
        else
        {
            $error .= validation_errors();
        }
        
            
        $this->data['message'] = $message;
        $this->data['redirect'] = $redirect;
        $this->data['errors'] = $error;
        echo json_encode($this->data);
        exit();
    }
    
}
