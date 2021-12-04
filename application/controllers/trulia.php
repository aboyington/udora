<?php

class Trulia extends CI_Controller
{
    private $data = array();
    private $settings = array();
    
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('settings_m');
        $this->settings = $this->settings_m->get_fields();
    }
   
	public function index()
	{
		echo 'Hello, trulia API here!';
        exit();
	}
    
    /*
        Based on Trulia Feed Development Guidelines
        For Sale and Rental Listings
        XML Specification
        Version 2.5: Last Updated 03/04/14
        
        index.php/trulia/feed/en
    */
    public function feed($lang_code = 'en', $limit_properties=NULL, $offset_properties=0)
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
        
        $where = array();
        $search_array = array();
        $where['language_id']  = $lang_id;
        $where['is_activated'] = 1;
        
        // fetch with user details
        $estates = $this->estate_m->get_by($where, false, $limit_properties, 'property.id DESC', $offset_properties, array(), NULL, FALSE, TRUE);
                
        // Set website details
        $generated_xml = '<?xml version="1.0" encoding="UTF-8" ?>';
        $generated_xml.= '<properties>';
        
        // Add listings to feed     
        foreach($estates as $key=>$row){            
            // Trulia required parameters
            
            // Price
            $price = 0;
            
            // status <= purpose #4
            $value = strtolower($this->estate_m->get_field_from_listing($row, 4));
            $status = '';

            if(stripos($value, lang_check('Sale')) !== FALSE)
            {
                $status = 'for sale';
                $price = $this->estate_m->get_field_from_listing($row, 36);
            }
            else if(stripos($value, lang_check('Rent')) !== FALSE)
            {
                $status = 'for rent';
                $price = $this->estate_m->get_field_from_listing($row, 37);
            }
            else
            {
                continue;
            }
            
            // Picture
            $first_url = '';
            if(isset($row->image_filename))
            {
                $first_url = base_url('files/'.$row->image_filename);
            }
            else
            {
                continue;
            }
            
            // Picture agent
            $agent_pic_url = '';
            if(isset($row->image_user_filename))
            {
                $agent_pic_url = base_url('files/'.$row->image_user_filename);
            }
            else
            {
                continue;
            }
            
            // Url
            $title_slug=$title='';
            $value = $this->estate_m->get_field_from_listing($row, 10);
            if(!empty($value))
            {
                $title = $value;
                $title_slug = url_title_cro($value);
            }
            $url = slug_url($this->data['listing_uri'].'/'.$row->id.'/'.$lang_code.'/'.$title_slug);
            
            // Description
            $description = 'Description field removed';
            $value = $this->estate_m->get_field_from_listing($row, 8);
            if(!empty($value))
            {
                $description = strip_tags($value);
                $description = str_replace(array("\r", "\n"), '', $description);
            }
            
            // Price to integer conversion
            
            if(empty($price))
            {
                continue;
            }
            else
            {
                $price = intval($price);
            }

            // property-type
            
            $value = $this->estate_m->get_field_from_listing($row, 2);
            
            $property_type = 'apartment/condo/townhouse';
            
            if(stripos($value, lang_check('Apartment')))
            {
                $property_type = 'apartment';
            }
            else if(stripos($value, lang_check('House')))
            {
                $property_type = 'single-familyhome';
            }
            else if(stripos($value, lang_check('Land')))
            {
                $property_type = 'lot/land';
            }

            if(empty($row->name_surname) || empty($row->mail))
                continue;

            $generated_xml.=  
             '<property>
                <status>'.$status.'</status>
                <location>
                    <street-address>'.$row->address.'</street-address>
                    <display-address>'.$row->address.'</display-address>
                    '.$this->xml_tag('city-name', $row, 7).'
                    '.$this->xml_tag('zipcode', $row, 40).'
                    '.$this->xml_tag('county', $row, 5).'
                    <longitude>'.$row->lng.'</longitude>
                    <latitude>'.$row->lat.'</latitude>
                </location>
                <details>
                    <price>'.$price.'</price>
                    <property-type>'.$property_type.'</property-type>
                    <description><![CDATA['.$description.']]></description>
                    '.$this->xml_tag('listing-title', $row, 10).'
                    <provider-listingid>'.$row->id.'</provider-listingid>
                </details>
                <landing-page>
                    <lp-url>'.$url.'</lp-url>
                </landing-page>
                <site>
                    <site-url>'.base_url().'</site-url>
                    <site-name><![CDATA[ '.strip_tags($this->settings['websitetitle']).' ]]></site-name>
                </site>
                <pictures>
                    <picture>
                        <picture-url>'.$first_url.'</picture-url>
                    </picture>
                </pictures>
                <agent>
                    '.$this->xml_tag_var('agent-name', $row->name_surname).'
                    '.$this->xml_tag_var('aagent-email', $row->mail).'
                    '.$this->xml_tag_var('agent-phone', $row->phone).'
                    '.$this->xml_tag_var('agent-picture-url', $agent_pic_url).'
                    <agent-id>'.$row->agent_id.'</agent-id>                               
                </agent>
                <detailed-characteristics>
                    <appliances>
                        '.$this->xml_tag_checkbox('has-dishwasher', $row, 25).'
                        '.$this->xml_tag_checkbox('has-microwave', $row, 31).'
                    </appliances>
                    '.$this->xml_tag_checkbox('has-balcony', $row, 11).'
                    '.$this->xml_tag_checkbox('has-pool', $row, 33).'
                    '.$this->xml_tag_checkbox('building-has-elevator', $row, 30).'
                    '.$this->xml_tag_checkbox('has-cable-satellite', $row, 23).'
                    '.$this->xml_tag_checkbox('has-intercom', $row, 29).'
                </detailed-characteristics>
              </property>';
        }

        // Close rss  
        $generated_xml.= '</properties>';
        
        header("Content-type: text/xml");
        echo $generated_xml;
        exit();
    }
    
    private function xml_tag_var($tag_name, &$var)
    {
        if(!empty($var))
        {
            return "<$tag_name>$var</$tag_name>";
        }
        
        
        return '';
    }
    
    private function xml_tag($tag_name, $property_row, $field_id)
    {
        $val = $this->estate_m->get_field_from_listing($property_row, $field_id);
        
        if(!empty($val))
        {
            return "<$tag_name>$val</$tag_name>";
        }
        
        
        return '';
    }
    
    private function xml_tag_checkbox($tag_name, $property_row, $field_id)
    {
        $val = $this->estate_m->get_field_from_listing($property_row, $field_id);
        
        if($val == 'true')
            $val = 'yes';
        else
            $val = 'no';
        
        if(!empty($val))
        {
            return "<$tag_name>$val</$tag_name>";
        }
        
        
        return '';
    }
    
    

}