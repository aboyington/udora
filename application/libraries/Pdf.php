<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require(APPPATH . 'libraries/fpdf/fpdf.php');
require(APPPATH . 'libraries/fpdf/makefont/makefont.php');

//MakeFont(APPPATH.'libraries/fpdf/font/test/TrebuchetMSItalic.ttf','cp1250');

class Pdf extends Fpdf {

    public function __construct($orientation = 'P', $unit = 'mm', $size = 'A4') {
        parent::__construct($orientation, $unit, $size);
        /* include */
        $this->CI = &get_instance();
        $this->CI->load->model('estate_m');
        $this->CI->load->model('option_m');
        $this->CI->load->model('file_m');
        $this->CI->load->model('language_m');
        $this->CI->load->model('settings_m');
        $this->CI->load->model('user_m');
        /* end  include */
    }

    /*
     * Put remote image 
     * 
     * @param $url_img string link with img
     * @param $x string/int position X
     * @param $y string/int position Y
     * @param $w string/int width of image
     * @param $h string/int height of image
     *      
     */

    public function set_image_by_link($url_img, $x = '', $y = '', $w = '', $h = '') {
        $f = file_get_contents($url_img);
        $file_name = time() . rand(000, 999) . '.jpg';
        file_put_contents(FCPATH . 'files/' . $file_name, $f);
        $this->Image(base_url('files/' . $file_name), $x, $y, $w, $h);
        unlink(FCPATH . 'files/' . $file_name);
    }

    
    /*
     * Function convert string to requested character encoding
     * 
     * @param string $lang code lang
     * @param string $str string for character encoding
     * retur encoded string;
     */
    public function charset_prepare($lang = 'en', $str) {
        $_str = ' ';
        if ($lang == 'hr') {
            //some conversion
            $_str = iconv(mb_detect_encoding($str), 'CP1250//TRANSLIT', html_entity_decode($str));
        } elseif ($lang == 'en') {
            $_str = iconv(mb_detect_encoding($str), 'utf-8//IGNORE', html_entity_decode($str));
        } else {
            $_str = $str;
        }
        return $_str;
    }

    /*
     * Function add font, if for lang need speacial charset
     * 
     * @param string $lang code lang
     * retur added forn
     */
    private function add_font_prepare($lang = 'en') {
        if ($lang = 'hr') {
            $this->AddFont('trebuc', '', 'trebuc.php');
            $this->AddFont('trebuc', 'B', 'trebucbd.php');
            $this->AddFont('trebuc', 'BI', 'trebucbi.php');
            $this->AddFont('trebuc', 'I', 'Trebuchet MS Bold Italic.php');
        } elseif ($lang = 'en') {
            
        } else {
            
        }
        return true;
    }

    
    /*
     * Function choose font
     * 
     * @param string $lang code lang
     * retur string font family name, default Arial
     */
    private function fontfamily_prepare($lang = 'en') {
        if ($lang = 'hr') {
            return 'trebuc';
        } elseif ($lang = 'en') {
            return 'Arial';
        } else {
            return 'Arial';
        }
    }

    public function generate_by_property($property_id = '', $lang_code = 'en', $api_key = null) {


        /* data var */

        /* var int id lang */
        $language_id = $this->CI->language_m->get_id($lang_code);

        /* var array website settings */
        $settings = $this->CI->settings_m->get_fields();

        /* var array property field */
        $_property = '';

        /* var array property options */
        $json_obj = '';

        /* var array category options */
        $category = '';

        /* var array option names */
        $option_name = '';

        /* var array property images */
        $images = '';

        /* end data */

        // some congig
        $fontfamily = $this->fontfamily_prepare($lang_code);
        $textColour = array(0, 0, 0);
        $tableHeaderTopTextColour = array(255, 255, 255);
        $tableHeaderTopFillColour = array(125, 152, 179);
        $tableHeaderTopProductTextColour = array(0, 0, 0);
        $tableHeaderTopProductFillColour = array(143, 173, 204);
        $tableHeaderLeftTextColour = array(99, 42, 57);
        $tableHeaderLeftFillColour = array(184, 207, 229);
        $tableBorderColour = array(50, 50, 50);
        $tableRowFillColour = array(213, 170, 170);
        // end some congig

        /* property */
        $where_in = array($property_id);
        $_property = $_property_compare = $this->CI->estate_m->get_by(array('is_activated' => 1, 'language_id' => $language_id), FALSE, NULL, 'id DESC', NULL, FALSE, $where_in);
        if (empty($_property)) {
            exit(lang_check('Listing not found'));
        }

        $_property = $_property[0];
        $json_obj = json_decode($_property->json_object);

        foreach ($json_obj as $key => $value) {
            if (is_string($value))
                $json_obj->$key = $this->charset_prepare($lang_code, $value);
        }

        /* fetch category */
        $options_name = $this->CI->option_m->get_lang(NULL, FALSE, $language_id);
        $category = array();
        $option_name = array();
        foreach ($options_name as $key => $row) {
            $field = 'field_' . $row->option_id;
            $type = $row->type;
            //skip
            if ($type == 'UPLOAD')
                continue;
            if ($type == 'HTMLTABLE')
                continue;
            if ($type == 'PEDIGREE')
                continue;
            if ($type == 'TREE')
                continue;

            if (!isset($json_obj->$field))
                continue;
            $option_name['option_' . $row->option_id] = $this->charset_prepare($lang_code, $row->option);
            if (empty($json_obj->$field))
                continue;

            // echo $json_obj->$field.PHP_EOL;
            $category['category_options_' . $row->parent_id][$row->option_id]['option_name'] =  $json_obj->$field;
            $category['category_options_' . $row->parent_id][$row->option_id]['option'] = 'option_' . $row->option_id;
            $category['category_options_' . $row->parent_id][$row->option_id]['option_suffix'] = $this->charset_prepare($lang_code, $row->suffix) ;
            $category['category_options_' . $row->parent_id][$row->option_id]['option_prefix'] = $this->charset_prepare($lang_code, $row->prefix) ;
        }
        /* end fetch category */

        $images = array();
        $_property->image_repository = json_decode($_property->image_repository);
        if(!empty($_property->image_repository))
        foreach ($_property->image_repository as $key => $value) {
            if (isset($_property->image_filename)) {
                $images[] = base_url('files/' . $value);
            }
        }

        /* [START] Fetch logo URL */
        $settings['website_logo_url'] = FCPATH . '/templates/' . $settings["template"] . '/assets/img/logo.svg';
        if (isset($settings['website_logo'])) {
            if (is_numeric($settings['website_logo'])) {
                $files_logo = $this->CI->file_m->get_by(array('repository_id' => $settings['website_logo']), TRUE);
                if (is_object($files_logo) && file_exists(FCPATH . 'files/thumbnail/' . $files_logo->filename)) {
                    $settings['website_logo_url'] = base_url('files/' . $files_logo->filename);
                }
            }
        }
        /* [END] Fetch logo URL */

        /* end property */

        // START CREATE PDF

        $this->AddPage();

        // add font for special charset
        $this->add_font_prepare();


        $this->SetDisplayMode('fullwidth');

        $this->SetFont($fontfamily, 'B', 16);

        // Title
        $this->Write(6, $json_obj->field_10);
        $this->Ln(8);
        //address
        
        $this->SetFont($fontfamily, '', 13);
        $this->Write(6, $this->charset_prepare($lang_code, $_property->address));
        $this->Ln(6);

        // Gps
        $this->Write(6, $_property->gps);
        $this->Ln(6);

        /* images */
        for ($i = 0; $i < count($images) && $i < 3; $i++) {
            $this->Image(_simg($images[$i], '230x150'), 11 + ($i * 64), 31);
        }
        /* end images */

        
        // description
        if(!empty($images)){
            $this->Ln($this->GetY() + 12);
        }
        $this->Ln(5);
        $this->SetFont($fontfamily, '', 12);
        $this->Write(6, '     ' . str_replace(array("\r\n", "\r", "\n"), '', strip_tags($json_obj->field_17)));


        /* Create Overview tanble */
        $this->Ln(10);
        $this->SetFont($fontfamily, 'B', 14);
        $this->Write(6, '' . $option_name['option_1']);
        $this->Ln(10);

        $this->SetLeftMargin(11);
        $fill = false;
        $table_category = array();
        foreach ($category['category_options_1'] as $key => $value) {
            $table_category[] = $option_name[$value['option']] . ': ' . $value['option_prefix'] . $value['option_name'] . $value['option_suffix'];
        }
        for ($i = 0; $i < count($table_category); $i++) {

            $this->SetFont($fontfamily, '', 8);

            $this->SetTextColor($tableHeaderLeftTextColour[0], $tableHeaderLeftTextColour[1], $tableHeaderLeftTextColour[2]);
            $this->SetFillColor($tableHeaderLeftFillColour[0], $tableHeaderLeftFillColour[1], $tableHeaderLeftFillColour[2]);

            $this->Cell(63, 10, ( '' . $table_category[$i]), 1, 0, 'C', $fill);
            $fill = !$fill;

            if (isset($table_category[$i + 1])) {
                $this->SetTextColor($tableHeaderLeftTextColour[0], $tableHeaderLeftTextColour[1], $tableHeaderLeftTextColour[2]);
                $this->SetFillColor($tableHeaderLeftFillColour[0], $tableHeaderLeftFillColour[1], $tableHeaderLeftFillColour[2]);
                $this->Cell(63, 10, ( '' . $table_category[$i + 1]), 1, 0, 'C', $fill);
                $fill = !$fill;
            }

            if (isset($table_category[$i + 2])) {
                $this->SetTextColor($tableHeaderLeftTextColour[0], $tableHeaderLeftTextColour[1], $tableHeaderLeftTextColour[2]);
                $this->SetFillColor($tableHeaderLeftFillColour[0], $tableHeaderLeftFillColour[1], $tableHeaderLeftFillColour[2]);
                $this->Cell(63, 10, ( '' . $table_category[$i + 2]), 1, 0, 'C', $fill);
            }

            $i++;
            $i++;
            $fill = !$fill;
            $this->Ln(10);
        }
        $this->SetLeftMargin(10);
        /* end Create Overview table */
        $this->SetTextColor($textColour[0], $textColour[1], $textColour[2]);
        $this->Ln(10);
        
        /* Indoor amenities */
        if(isset($category['category_options_21'])&&!empty($category['category_options_21'])):
        
            $this->SetFont($fontfamily, 'B', 14);
            $this->Write(6, '' . $option_name['option_21']);
            $this->Ln(10);

            $this->SetLeftMargin(11);
            $this->SetFont($fontfamily, '', 12);
            $_count = 1;
            $value = current($category['category_options_21']);
            do {
                // Create the data cells
                $this->SetTextColor($textColour[0], $textColour[1], $textColour[2]);
                $this->SetFillColor($tableRowFillColour[0], $tableRowFillColour[1], $tableRowFillColour[2]);
                $this->SetFont($fontfamily, '', 12);

                if (file_exists(FCPATH . '/templates/' . $settings["template"] . '/assets/img/icons/option_id/' . key($category['category_options_21']) . '.png'))
                    $this->Cell(50, 10, ('    ' . $option_name[$value['option']] . ' ' . $this->Image(base_url('templates/' . $settings["template"] . '/assets/img/icons/option_id/' . key($category['category_options_21']) . '.png'), $this->GetX(), $this->GetY() + 2.5) . '   '), 0, 0, 'L');
                else {
                    $this->Cell(50, 10, ('' . $option_name[$value['option']]), 0, 0, 'L');
                }
                $fill = !$fill;
                if ($_count % 4 == 0)
                    $this->Ln(10);

                $_count++;
            }
            while ($value = next($category['category_options_21']));
            $this->SetLeftMargin(10);
        endif;
        /* end Indoor amenities */

        /* outdoor amenities */
        if(isset($category['category_options_52'])&&!empty($category['category_options_52'])):
            $this->Ln(15);
            $this->SetFont($fontfamily, 'B', 14);
            $this->Write(6, '' . $option_name['option_52']);
            $this->Ln(10);
            $this->SetLeftMargin(11);

            $this->SetFont($fontfamily, '', 12);
            $_count = 1;
            $value = current($category['category_options_52']);
            do {
                // Create the data cells
                $this->SetTextColor($textColour[0], $textColour[1], $textColour[2]);
                $this->SetFillColor($tableRowFillColour[0], $tableRowFillColour[1], $tableRowFillColour[2]);
                $this->SetFont($fontfamily, '', 12);

                if (file_exists(FCPATH . '/templates/' . $settings["template"] . '/assets/img/icons/option_id/' . key($category['category_options_52']) . '.png'))
                    $this->Cell(50, 10, ('    ' . $option_name[$value['option']] . ' ' . $this->Image(base_url('templates/' . $settings["template"] . '/assets/img/icons/option_id/' . key($category['category_options_52']) . '.png'), $this->GetX(), $this->GetY() + 2.5) . '   '), 0, 0, 'L');
                else {
                    $this->Cell(50, 10, ('' . $option_name[$value['option']]), 0, 0, 'L');
                }
                $fill = !$fill;
                if ($_count % 4 == 0)
                    $this->Ln(10);

                $_count++;
            }
            while ($value = next($category['category_options_52']));
            $this->SetLeftMargin(10);
        endif;
        /* end outdoor amenities */

        /* Distance */
        if(isset($category['category_options_43'])&&!empty($category['category_options_43'])):
            $this->Ln(15);
            $this->SetFont($fontfamily, 'B', 14);
            $this->Write(6, '' . $option_name['option_43']);
            $this->Ln(10);
            $this->SetFont($fontfamily, '', 12);
            $this->SetLeftMargin(11);
            $_count = 1;
            $value = current($category['category_options_43']);
            do {
                // Create the data cells
                $this->SetTextColor($textColour[0], $textColour[1], $textColour[2]);
                $this->SetFillColor($tableRowFillColour[0], $tableRowFillColour[1], $tableRowFillColour[2]);
                $this->SetFont($fontfamily, '', 12);

                if (file_exists(FCPATH . '/templates/' . $settings["template"] . '/assets/img/icons/option_id/' . key($category['category_options_43']) . '.png'))
                    $this->Cell(50, 10, ('    ' . $option_name[$value['option']] . '  ' . $this->Image(base_url('templates/' . $settings["template"] . '/assets/img/icons/option_id/' . key($category['category_options_43']) . '.png'), $this->GetX(), $this->GetY() + 2.5) . '   '), 0, 0, 'L');
                else {
                    $this->Cell(50, 10, ('' . $option_name[$value['option']]), 0, 0, 'L');
                }
                $fill = !$fill;
                if ($_count % 4 == 0)
                    $this->Ln(10);
                $_count++;
            }
            while ($value = next($category['category_options_43']));
        endif;
        /* end Distance */

        // map
        if (!empty($api_key) && !empty($_property->gps)) {
            if($this->GetY()>200)   $this->AddPage(); 
            else {
               $this->Ln(10); 
            }
            $this->Ln(0);
            $this->set_image_by_link('http://www.mapquestapi.com/staticmap/v4/getmap?key=' . $api_key . '&zoom=13&center=' . str_replace(' ', '', $_property->gps) . '&zoom=10&size=720,300&type=map&imagetype=jpeg&pois=1,' . str_replace(' ', '', $_property->gps) . '', $this->GetX() + 0, $this->GetY() + 5);
            $this->Ln(100);
            $this->SetLeftMargin(10);
        }
        
        
     if($this->GetY()>220)       $this->AddPage();  
        $watermark_filename='adminudora-assets/img/stamp.png';
            
        /* check $watermark_filename from settings */
        
        // return true if user have custom watermark
        
        if(isset($settings['watermark_img']))
        {
           if(is_numeric($settings['watermark_img']))
            {
                $files_watermark = $this->CI->file_m->get_by(array('repository_id' => $settings['watermark_img']), TRUE);
                if( is_object($files_watermark) && file_exists(FCPATH.'files/'.$files_watermark->filename))
                {
                    $watermark_filename = 'files/'.$files_watermark->filename;
                }
            }
        }
        /* and check $watermark_filename from settings */
        
        // logo site
        
        $this->setY(-65);
        if(file_exists(FCPATH.$watermark_filename)){
            $this->Image($watermark_filename, $this->GetX() + 155, $this->GetY() + 10, '30');
        }
        // footer

        $agent = $this->CI->user_m->get_agent($property_id);
        // row 1
        $this->SetFont($fontfamily, 'B', 14);
        if($agent)
            $this->Cell(97, 10, ('  ' . lang_check('Agent Details') . '  '), 0, 0, 'L');
        else $this->Cell(97, 10, ('    '), 0, 0, 'L');
        $this->Cell(55, 10, ('' . $this->charset_prepare($lang_code, $settings['websitetitle'] ). '  '), 0, 0, 'R');
        $this->Ln(10);
        // row 2
        $this->SetFont($fontfamily, '', 12);  
        if($agent)
            $this->Cell(97, 10, ('  ' . lang_check('Name') . ': ' . $this->charset_prepare($lang_code, $agent['name_surname'])), 0, 0, 'L');
        else $this->Cell(97, 10, ('    '), 0, 0, 'L');
       
        $this->Cell(55, 10, (' ' . lang_check('Phone') . ': ' . $this->charset_prepare($lang_code, $settings['phone']) . '  '), 0, 0, 'R');
        $this->Ln(10);
        // row 3
        if($agent)
        $this->Cell(97, 10, ('  ' . lang_check('Phone') . ': ' .$this->charset_prepare($lang_code, $agent['phone'])), 0, 0, 'L');
         else $this->Cell(97, 10, ('    '), 0, 0, 'L');
        $this->Cell(55, 10, (' ' . lang_check('Fax') . ': ' .   $this->charset_prepare($lang_code, $settings['fax']) . '  '), 0, 0, 'R');
        $this->Ln(10);
        // row 4
          if($agent)
             $this->Cell(97, 10, ('  ' . lang_check('Mail') . ': ' .$this->charset_prepare($lang_code, $agent['mail'])), 0, 0, 'L');
          else $this->Cell(97, 10, ('    '), 0, 0, 'L');
        
          $this->Cell(55, 10, (' ' . lang_check('Mail') . ': ' . $this->charset_prepare($lang_code, $settings['email']) . '  '), 0, 0, 'R');
        $this->Ln(10);

        $filename='listing_'.$property_id.'_'.$lang_code.'.pdf';
        $this->Output('I',$filename);
    }

}
