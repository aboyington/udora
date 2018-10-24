<?php

class Settings_m extends MY_Model {
    
    protected $_table_name = 'settings';
    protected $_order_by = 'id';
    
    public $custom_fields_user = array(
        'custom_fields_code' => array('field'=>'custom_fields_code', 'label'=>'lang:Custom fields code', 'rules'=>'trim')
    );
    
    public $rules_contact = array(
        'address' => array('field'=>'address', 'label'=>'lang:Address', 'rules'=>'trim'),
        'websitetitle' => array('field'=>'websitetitle', 'label'=>'lang:WebsiteTitle', 'rules'=>'trim'),
        'gps' => array('field'=>'gps', 'label'=>'lang:Gps', 'rules'=>'trim|callback_gps_check'),
        'map_center' => array('field'=>'map_center', 'label'=>'lang:Use as map center', 'rules'=>'trim'),
        'email' => array('field'=>'email', 'label'=>'lang:ContactMail', 'rules'=>'trim|valid_email'),
        'email_alert' => array('field'=>'email_alert', 'label'=>'lang:inputContactMailAlert', 'rules'=>'trim'),
        'phone' => array('field'=>'phone', 'label'=>'lang:Phone', 'rules'=>'trim'),
        'fax' => array('field'=>'fax', 'label'=>'lang:Fax', 'rules'=>'trim'),
        'address_footer' => array('field'=>'address_footer', 'label'=>'lang:Address Footer', 'rules'=>'trim'),
    );
    
    public $rules_template = array(
        'template' => array('field'=>'address', 'label'=>'lang:Template', 'rules'=>'trim'),
        'tracking' => array('field'=>'tracking', 'label'=>'lang:Tracking', 'rules'=>'trim'),
        'facebook' => array('field'=>'facebook', 'label'=>'lang:Facebook or Social code', 'rules'=>'trim'),
        'facebook_top' => array('field'=>'facebook_top', 'label'=>'lang:Facebook or Social code on Top', 'rules'=>'trim'),
        'facebook_jsdk' => array('field'=>'facebook_jsdk', 'label'=>'lang:Facebook Javascript SDK code', 'rules'=>'trim'),
        'facebook_comments' => array('field'=>'facebook_comments', 'label'=>'lang:Facebook comments code', 'rules'=>'trim'),
        'useful_links' => array('field'=>'useful_links', 'label'=>'lang:Useful links', 'rules'=>'trim'),
        'website_logo' => array('field'=>'website_logo', 'label'=>'lang:Website logo', 'rules'=>'trim'),
        'website_logo_secondary' => array('field'=>'website_logo_secondary', 'label'=>'lang:Website logo secondary', 'rules'=>'trim'),
        'website_favicon' => array('field'=>'website_favicon', 'label'=>'lang:Website favicon', 'rules'=>'trim'),
        'watermark_img' => array('field'=>'watermark_img', 'label'=>'lang:Watermark', 'rules'=>'trim'),
        'search_background' => array('field'=>'search_background', 'label'=>'lang:Search form background', 'rules'=>'trim'),
        'color' => array('field'=>'color', 'label'=>'lang:Color', 'rules'=>'trim')
    );
    
    public $rules_system = array(
        'noreply' => array('field'=>'noreply', 'label'=>'lang:No-reply email', 'rules'=>'trim|required|valid_email'),
        'zoom' => array('field'=>'zoom', 'label'=>'lang:Zoom index', 'rules'=>'trim|required|is_natural'),
        'paypal_email' => array('field'=>'paypal_email', 'label'=>'lang:PayPal payment email', 'rules'=>'trim|valid_email'),
        'payments_enabled'=> array('field'=>'payments_enabled', 'label'=>'lang:Enable payments', 'rules'=>'trim'),
        'walkscore_enabled'=> array('field'=>'walkscore_enabled', 'label'=>'lang:Walkscore enabled', 'rules'=>'trim'),
        'property_subm_disabled'=> array('field'=>'property_subm_disabled', 'label'=>'lang:Property submission disabled', 'rules'=>'trim'),
        'maps_api_key'=> array('field'=>'maps_api_key', 'label'=>'lang:Google Maps API key', 'rules'=>'trim|required'),
        

        'listing_expiry_days' => array('field'=>'listing_expiry_days', 'label'=>'lang:Listing expiry days', 'rules'=>'trim|is_natural'),
        'activation_price' => array('field'=>'activation_price', 'label'=>'lang:Activation price', 'rules'=>'trim|is_numeric'),
        'featured_price' => array('field'=>'featured_price', 'label'=>'lang:Featured price', 'rules'=>'trim|is_numeric'),
        'default_currency' => array('field'=>'default_currency', 'label'=>'lang:Default currency code', 'rules'=>'trim|required'),
        
        'authorize_api_login_id' => array('field'=>'authorize_api_login_id', 'label'=>'lang:Authorize api login id', 'rules'=>'trim'),
        'authorize_api_hash_secret' => array('field'=>'authorize_api_hash_secret', 'label'=>'lang:Authorize api hash secret', 'rules'=>'trim'),
        'authorize_api_transaction_key' => array('field'=>'authorize_api_transaction_key', 'label'=>'lang:Authorize api transaction key', 'rules'=>'trim'),
        
        'payu_api_pos_id' => array('field'=>'payu_api_pos_id', 'label'=>'lang:Payu API pos id', 'rules'=>'trim'),
        'payu_api_key_1' => array('field'=>'payu_api_key_1', 'label'=>'lang:Payu first key', 'rules'=>'trim'),
        'payu_api_key_2' => array('field'=>'payu_api_key_2', 'label'=>'lang:Payu second key', 'rules'=>'trim'),
        'payu_api_auth_key' => array('field'=>'payu_api_auth_key', 'label'=>'lang:Payu authorisation key', 'rules'=>'trim'),
        
        
        'adsense728_90' => array('field'=>'adsense728_90', 'label'=>'lang:AdSense 728x90 code', 'rules'=>'trim'),
        'adsense160_600' => array('field'=>'adsense160_600', 'label'=>'lang:AdSense 160x600 code', 'rules'=>'trim'),
        //'agent_masking_enabled' => array('field'=>'agent_masking_enabled', 'label'=>'lang:Enable masking', 'rules'=>'trim'),
        //'rating_enabled' => array('field'=>'rating_enabled', 'label'=>'lang:Enable rating', 'rules'=>'trim'),
        'reviews_enabled' => array('field'=>'reviews_enabled', 'label'=>'lang:Enable reviews', 'rules'=>'trim'),
        'reviews_public_visible_enabled' => array('field'=>'reviews_public_visible_enabled', 'label'=>'lang:Enable reviews public visible', 'rules'=>'trim'),
        'showroom_slideshow_enabled' => array('field'=>'showroom_slideshow_enabled', 'label'=>'lang:Enable showroom slideshow', 'rules'=>'trim'),
        'withdrawal_details' => array('field'=>'withdrawal_details', 'label'=>'lang:Withdrawal payment details', 'rules'=>'trim'),
        'booking_fee' => array('field'=>'booking_fee', 'label'=>'lang:Booking fee percentage %', 'rules'=>'trim|is_natural'),
        
        'page_offline' => array('field'=>'page_offline', 'label'=>'lang:Page offline', 'rules'=>'trim'),
        'page_offline_message' => array('field'=>'page_offline_message', 'label'=>'lang:Page offline message', 'rules'=>'trim'),

        'enable_qs' => array('field'=>'enable_qs', 'label'=>'lang:Enable quick submission', 'rules'=>'trim'),
        'multilang_on_qs' => array('field'=>'multilang_on_qs', 'label'=>'lang:Multilanguage on quick submission', 'rules'=>'trim'),

    );

    public function get_new()
	{
        $setting = new stdClass();
        $setting->field = '';
        $setting->value = '';
        
        return $setting;
	}
    
    public function get_fields()
    {
        if(($fields_data = $this->cache_temp_load('fields_data')) === FALSE)
        {
            $query = $this->db->get($this->_table_name);
    
            $fields_data = array();
            
            if(is_object($query))
            foreach($query->result() as $key=>$setting)
            {
                $fields_data[$setting->field] = $setting->value;
            }
            
            $this->cache_temp_save($fields_data, 'fields_data');
        }

        return $fields_data;
    }
    
    public function get_field($field_name)
    {
        $fields = $this->get_fields();
        
        if(isset($fields[$field_name]))
            return $fields[$field_name];
            
        return NULL;
    }
    
    public function save_settings($post_data)
    {
        $this->delete_fields($post_data);
        
        $data = array();
        foreach($post_data as $key=>$value)
        {
            $data[] = array(
               'field' => $key,
               'value' => $value
            );
        }
        
        $this->db->insert_batch($this->_table_name, $data); 
    }
    
    public function delete_fields($fields = array())
    {
        $this->db->where_in('field', array_keys($fields));
        $this->db->delete($this->_table_name);
    }
    
}



