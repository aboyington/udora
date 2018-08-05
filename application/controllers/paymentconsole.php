<?php

class Paymentconsole extends CI_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('settings_m');
        $this->load->library('MY_Composer');
    }
    
    public function index()
    {
        echo 'test here';
    }
    
    private function _check_login()
    {        
        $this->load->library('session');
        $this->load->model('user_m');
        
        // Login check
        if($this->user_m->loggedin() == FALSE)
        {
            redirect('frontend/login/'.$this->data['lang_code']);
        }
    }
    
    public function authorize_payment($lang_code, $price, $currency_code, $reference_id, $reference_code)
    {
        $this->_check_login();
        
        $user_id = $this->session->userdata('id');
        $user_type = $this->session->userdata('type');
        $user = $this->user_m->get($user_id);
        $price = number_format($price, 2, '.', '');
        
        $invoice_num = $reference_id.'_'.$reference_code.'_'.$user_id.'_'.$price.'_'.date('w');
        $description = $reference_code.' '.$reference_id;
        
        if($reference_code == 'PAC')
        {
            $description = 'Package '.$reference_id;
        }
        else if($reference_code == 'RES')
        {
            $description = 'Reservation '.$reference_id;
        }
        else if($reference_code == 'ACT')
        {
            $description = 'Activate listing '.$reference_id;
        }
        else if($reference_code == 'FEA')
        {
            $description = 'Featured listing '.$reference_id;
        }
        
        $api_login_id = config_db_item('authorize_api_login_id');
        $api_hash_secret = config_db_item('authorize_api_hash_secret');
        $api_transaction_key = config_db_item('authorize_api_transaction_key');
        
        if(empty($api_login_id) || empty($api_hash_secret) || empty($api_transaction_key))
        {
            echo lang_check('Authorize.net not configured');
            exit();
        }
        
        $gateway = Omnipay\Omnipay::create('AuthorizeNet_SIM');
        $gateway->setApiLoginId($api_login_id);
        $gateway->setHashSecret($api_hash_secret);
        $gateway->setTransactionKey($api_transaction_key);
        $gateway->setDeveloperMode(ENVIRONMENT == 'development');
        
        $formData = array();
        
        $response = $gateway->purchase(array('amount' => $price, 
                                        'currency' => $currency_code,
                                        'transactionId' => $invoice_num,
                                        'description'=>$description,
                                        'returnUrl' => site_url('paymentconsole/authorize_payment_return/'.$lang_code.'/'.$currency_code), 
                                        'card' => $formData))->send();
        
        if ($response->isSuccessful()) {
            // payment was successful: update database
            print_r($response);
        } elseif ($response->isRedirect()) {
            // redirect to offsite payment gateway
            $response->redirect();
        } else {
            // payment failed: display message to customer
            echo $response->getMessage();
        }

    }
    
    public function authorize_payment_return($lang_code, $currency_code)
    {
/*
        print_r($_POST);
        
        Array
        (
            [x_response_code] => 1
            [x_response_reason_code] => 1
            [x_response_reason_text] => (TESTMODE) This transaction has been approved.
            [x_avs_code] => P
            [x_auth_code] => 000000
            [x_trans_id] => 0
            [x_method] => CC
            [x_card_type] => Visa
            [x_account_number] => XXXX8888
            [x_first_name] => Pero
            [x_last_name] => Peri
            [x_company] => 
            [x_address] => 
            [x_city] => 
            [x_state] => 
            [x_zip] => 
            [x_country] => 
            [x_phone] => 
            [x_fax] => 
            [x_email] => 
            [x_invoice_num] => 99
            [x_description] => test description
            [x_type] => auth_capture
            [x_cust_id] => 
            [x_ship_to_first_name] => 
            [x_ship_to_last_name] => 
            [x_ship_to_company] => 
            [x_ship_to_address] => 
            [x_ship_to_city] => 
            [x_ship_to_state] => 
            [x_ship_to_zip] => 
            [x_ship_to_country] => 
            [x_amount] => 10.00
            [x_tax] => 0.00
            [x_duty] => 0.00
            [x_freight] => 0.00
            [x_tax_exempt] => FALSE
            [x_po_num] => 
            [x_MD5_Hash] => 0FF95CF7E01262AA14E110656A04E9DD
            [x_cvv2_resp_code] => 
            [x_cavv_response] => 
            [x_test_request] => true
            [x_method_available] => true
        )
*/
        
        $received_post = $this->input->post();
        $inv_ex = explode('_', $received_post['x_invoice_num']);
        
        if(count($inv_ex)<3)
        {
            print_r($_POST);
            exit('wrong request');
        }
        
        $reference_code = $inv_ex[1];
        $reference_id = $inv_ex[0];
        
        $data = array();
        $data['invoice_num'] = $received_post['x_invoice_num'];
        $data['date_paid'] = date('Y-m-d H:i:s');
        $data['data_post'] = serialize($received_post);
        $data['payer_id'] = $received_post['x_account_number'];
        $data['txn_id'] = $received_post['x_trans_id'];
        $data['paid'] = $received_post['x_amount'];
        $data['currency_code'] = $currency_code;
        $data['payer_email'] = '';
        $data['payment_gateway'] = 'AuthorizeNET';
        $data['user_id'] = $inv_ex[2];
        $data['listing_id'] = '';
        $data['package_id'] = '';
        $data['reservation_id'] = '';
        
        $this->load->model('payments_m');
        $this->payments_m->save($data);

        if($inv_ex[1] == 'RES'){
            $table_id = $inv_ex[0];
            
            // Set reservations paid
            $this->load->model('reservations_m');
            $reservation = $this->reservations_m->get_array_by(array('id'=>$table_id), TRUE);
            
            $data_r = array();
            
            if(empty($reservation['total_paid']))
                $reservation['total_paid'] = 0;
    
            $data_r['total_paid'] = $reservation['total_paid'] + $data['paid'];
            
            if($data_r['total_paid'] >= $reservation['total_price'])
            {
                $data_r['date_paid_total'] = date('Y-m-d H:i:s');
            }
            else
            {
                $data_r['date_paid_advance'] = date('Y-m-d H:i:s');
            }
            
            $data_r['is_confirmed'] = '1';
            
            $this->reservations_m->save($data_r, $table_id);
            
            // redirect to myreservations
            redirect_html('frontend/myreservations/'.$lang_code);
            
        }
        else if($inv_ex[1] == 'PAC')
        {
            $table_id = $inv_ex[2];
            $package_id = $inv_ex[0];
            
            // check if extend or buy
            $user = $this->user_m->get($table_id);
            $from_time = time();
            if(strtotime($user->package_last_payment) > $from_time)
                $from_time = strtotime($user->package_last_payment);
            
            $this->load->model('packages_m');
            $package = $this->packages_m->get($package_id);
            $days_extend = $package->package_days;
            
            // Set package paid
            $data_r = array();
            $data_r['package_last_payment'] = date('Y-m-d H:i:s', $from_time + 86400*intval($days_extend));
            $data_r['package_id'] = $package_id;
            
            $this->user_m->save($data_r, $table_id);
            
            // redirect to myproperties
            if($user_type == 'AGENT')
            {
                redirect_html('admin/packages/mypackage');
            }
            else
            {
                redirect_html('frontend/myproperties/'.$lang_code);
            }
        }
        else if($inv_ex[1] == 'ACT')
        {
            $table_id = $inv_ex[2];
            $property_id = $inv_ex[0];
            
            // check if extend or buy
            $this->load->model('estate_m');
            $estate = $this->estate_m->get($property_id);
            
            // Set package paid
            $data_r = array();
            $data_r['is_activated'] = '1';
            $data_r['activation_paid_date'] = date('Y-m-d H:i:s');
            
            $this->estate_m->save($data_r, $property_id);
            
            // redirect to myproperties
            redirect_html('frontend/myproperties/'.$lang_code);
        }
        else if($inv_ex[1] == 'FEA')
        {
            $table_id = $inv_ex[2];
            $property_id = $inv_ex[0];
            
            // check if extend or buy
            $this->load->model('estate_m');
            $estate = $this->estate_m->get($property_id);
            
            // Set package paid
            $data_r = array();
            $data_r['is_featured'] = '1';
            $data_r['featured_paid_date'] = date('Y-m-d H:i:s');
            
            $this->estate_m->save($data_r, $property_id);
            
            // redirect to myproperties
            redirect_html('frontend/myproperties/'.$lang_code);
        }
        
        exit(lang_check('Thank you very much on your payment!'));
    }
    
    public function payu_payment($lang_code, $price, $currency_code, $reference_id, $reference_code)
    {
        $this->_check_login();
        
        $user_id = $this->session->userdata('id');
        $user_type = $this->session->userdata('type');
        $user = $this->user_m->get($user_id);
        $price = number_format($price, 2, '.', '');
        
        $invoice_num = $reference_id.'_'.$reference_code.'_'.$user_id.'_'.$price.'_'.date('w');
        $description = $reference_code.' '.$reference_id;
        
        if($reference_code == 'PAC')
        {
            $description = 'Package '.$reference_id;
        }
        else if($reference_code == 'RES')
        {
            $description = 'Reservation '.$reference_id;
        }
        else if($reference_code == 'ACT')
        {
            $description = 'Activate listing '.$reference_id;
        }
        else if($reference_code == 'FEA')
        {
            $description = 'Featured listing '.$reference_id;
        }
        
        $api_login_id = config_db_item('payu_api_pos_id');
        $api_hash_secret = config_db_item('payu_api_key_2');
        $api_transaction_key = config_db_item('payu_api_auth_key');
        
        if(empty($api_login_id) || empty($api_hash_secret) /*|| empty($api_transaction_key)*/)
        {
            echo lang_check('Payu not configured');
            exit();
        }
        
        $gateway = Omnipay\Omnipay::create('PayU');
        $gateway->setMerchantId($api_login_id);
        $gateway->setSecretKey($api_hash_secret);
        //$gateway->setTransactionKey($api_transaction_key);
        $gateway->setTestMode(ENVIRONMENT == 'development');
        
        $formData = array();
        
        $response = $gateway->purchase(array('amount' => $price, 
                                        'currency' => $currency_code,
                                        'transactionId' => $invoice_num,
                                        'description'=>$description,
                                        'returnUrl' => site_url('frontend/myproperties/'.$lang_code),
                                        'notifyUrl' => site_url('paymentconsole/payu_payment_return/'.$lang_code.'/'.$currency_code), 
                                        'card' => $formData))->send();
        
        if ($response->isSuccessful()) {
            // payment was successful: update database
            print_r($response);
        } elseif ($response->isRedirect()) {
            // redirect to offsite payment gateway
            $response->redirect();
        } else {
            // payment failed: display message to customer
            echo $response->getMessage();
        }

    }
    
    public function payu_payment_return($lang_code, $currency_code)
    {
/*
$entityBody = file_get_contents('php://input');
$responseUpay = json_decode($entityBody, true);
var_dump($responseUpay);

array(2) {
  ["order"]=>
  array(11) {
    ["orderId"]=>
    string(27) "CPLWBTVS3M150827GUEST000P01"
    ["extOrderId"]=>
    string(22) "344_ACT_18_49.00_4_220"
    ["orderCreateDate"]=>
    string(29) "2015-08-27T15:25:22.713+02:00"
    ["notifyUrl"]=>
    string(81) "http://celorocnimobilheimy.cz/index.php/paymentconsole/payu_payment_return/en/CZK"
    ["customerIp"]=>
    string(13) "93.139.238.76"
    ["merchantPosId"]=>
    string(6) "194430"
    ["description"]=>
    string(20) "Activate listing 344"
    ["currencyCode"]=>
    string(3) "CZK"
    ["totalAmount"]=>
    string(4) "4900"
    ["status"]=>
    string(7) "PENDING"
    ["products"]=>
    array(1) {
      [0]=>
      array(3) {
        ["name"]=>
        string(20) "Activate listing 344"
        ["unitPrice"]=>
        string(4) "4900"
        ["quantity"]=>
        string(1) "1"
      }
    }
  }
  ["properties"]=>
  array(0) {
  }
}
*/
        $entityBody = file_get_contents('php://input');
        $responseUpay = json_decode($entityBody, true);
        
        if(!isset($responseUpay['order']))
        {
            header( 'HTTP/1.1 400 BAD REQUEST' );
            log_message('error', 'empty order array');
            exit('wrong request');
        }
        
        
        $received_post = $responseUpay['order'];
        $inv_ex = explode('_', $received_post['extOrderId']);

        // 8_PAC_18_390.00_2
        
        if(count($inv_ex)<3)
        {
            header( 'HTTP/1.1 400 BAD REQUEST' );
            print_r($_POST);
            exit('wrong request');
        }
        
        if($received_post['status'] != 'COMPLETED')
        {
            exit('OK');
        }
        
        $reference_code = $inv_ex[1];
        $reference_id = $inv_ex[0];
        
        if(empty($received_post['orderId']))
            $received_post['orderId'] = $received_post['extOrderId'];
        
        if(empty($received_post['amount']))
            $received_post['amount'] = $inv_ex[3];
        
        $data = array();
        $data['invoice_num'] = $received_post['extOrderId'];
        $data['date_paid'] = date('Y-m-d H:i:s');
        $data['data_post'] = serialize($received_post);
        $data['payer_id'] = NULL;
        $data['txn_id'] = $received_post['orderId'];
        $data['paid'] = _ch($received_post['amount'], NULL);
        $data['currency_code'] = $currency_code;
        $data['payer_email'] = '';
        $data['payment_gateway'] = 'PayU';
        $data['user_id'] = $inv_ex[2];
        $data['listing_id'] = '';
        $data['package_id'] = '';
        $data['reservation_id'] = '';
        
        $this->load->model('payments_m');
        $this->load->model('user_m');
        $this->payments_m->save($data);

        if($inv_ex[1] == 'RES'){
            $table_id = $inv_ex[0];
            
            // Set reservations paid
            $this->load->model('reservations_m');
            $reservation = $this->reservations_m->get_array_by(array('id'=>$table_id), TRUE);
            
            $data_r = array();
            
            if(empty($reservation['total_paid']))
                $reservation['total_paid'] = 0;
    
            $data_r['total_paid'] = $reservation['total_paid'] + $data['paid'];
            
            if($data_r['total_paid'] >= $reservation['total_price'])
            {
                $data_r['date_paid_total'] = date('Y-m-d H:i:s');
            }
            else
            {
                $data_r['date_paid_advance'] = date('Y-m-d H:i:s');
            }
            
            $data_r['is_confirmed'] = '1';
            
            $this->reservations_m->save($data_r, $table_id);
            
            // redirect to myreservations
            redirect_html('frontend/myreservations/'.$lang_code);
            
        }
        else if($inv_ex[1] == 'PAC')
        {
            $table_id = $inv_ex[2];
            $package_id = $inv_ex[0];
            
            // check if extend or buy
            $user = $this->user_m->get($table_id);
            $from_time = time();
            if(strtotime($user->package_last_payment) > $from_time)
                $from_time = strtotime($user->package_last_payment);
            
            $this->load->model('packages_m');
            $package = $this->packages_m->get($package_id);
            $days_extend = $package->package_days;
            
            // Set package paid
            $data_r = array();
            $data_r['package_last_payment'] = date('Y-m-d H:i:s', $from_time + 86400*intval($days_extend));
            $data_r['package_id'] = $package_id;
            
            $this->user_m->save($data_r, $table_id);
            
            $user_type = $user->type;
            
            // redirect to myproperties
            if($user_type == 'AGENT')
            {
                redirect_html('admin/packages/mypackage');
            }
            else
            {
                redirect_html('frontend/myproperties/'.$lang_code);
            }
        }
        else if($inv_ex[1] == 'ACT')
        {
            $table_id = $inv_ex[2];
            $property_id = $inv_ex[0];
            
            // check if extend or buy
            $this->load->model('estate_m');
            $estate = $this->estate_m->get($property_id);
            
            // Set package paid
            $data_r = array();
            $data_r['is_activated'] = '1';
            $data_r['activation_paid_date'] = date('Y-m-d H:i:s');
            
            $this->estate_m->save($data_r, $property_id);
            
            // redirect to myproperties
            redirect_html('frontend/myproperties/'.$lang_code);
        }
        else if($inv_ex[1] == 'FEA')
        {
            $table_id = $inv_ex[2];
            $property_id = $inv_ex[0];
            
            // check if extend or buy
            $this->load->model('estate_m');
            $estate = $this->estate_m->get($property_id);
            
            // Set package paid
            $data_r = array();
            $data_r['is_featured'] = '1';
            $data_r['featured_paid_date'] = date('Y-m-d H:i:s');
            
            $this->estate_m->save($data_r, $property_id);
            
            // redirect to myproperties
            redirect_html('frontend/myproperties/'.$lang_code);
        }
        
        exit('OK');
    }
    
    public function invoice_payment($lang_code, $price, $currency_code, $reference_id, $reference_code)
    {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p class="alert alert-danger">', '</p>');
        
        $this->_check_login();
        
        $this->data['settings'] = $this->settings_m->get_fields();
        
        $this->load->model('language_m');
        $lang_id = $this->language_m->get_id($lang_code);
        $lang_name = $this->language_m->get_name($lang_id);
        $this->lang->load('frontend_template', $lang_name, FALSE, TRUE, FCPATH.'templates/'.$this->data['settings']['template'].'/');
        
        $user_id = $this->session->userdata('id');
        $user_type = $this->session->userdata('type');
        $user = $this->user_m->get($user_id);
        $price = number_format($price, 2, '.', '');
        
        $this->data['user'] = $user;
        
        $invoice_num = $reference_id.'_'.$reference_code.'_'.$user_id.'_'.$price.'_'.date('w');
        $description = $reference_code.' '.$reference_id;
        
        if($reference_code == 'PAC')
        {
            $description = 'Package '.$reference_id;
        }
        else if($reference_code == 'RES')
        {
            $description = 'Reservation '.$reference_id;
        }
        else if($reference_code == 'ACT')
        {
            $description = 'Activate listing '.$reference_id;
        }
        else if($reference_code == 'FEA')
        {
            $description = 'Featured listing '.$reference_id;
        }
        
        $rules = $this->user_m->rules_billing;
        
        $this->form_validation->set_rules($rules);
        
        // Process the form
        if($this->form_validation->run() == TRUE)
        {
            $data = $this->user_m->array_from_rules($rules);
            $this->user_m->save($data, $user_id);

            redirect("paymentconsole/invoice_print/$lang_code/$price/$currency_code/$reference_id/$reference_code");
        }

        $output = $this->load->view($this->data['settings']['template'].'/invoice_form.php', $this->data, TRUE);
        echo str_replace('assets/', base_url('templates/'.$this->data['settings']['template']).'/assets/', $output);
    }
    
    public function invoice_print($lang_code, $price, $currency_code, $reference_id, $reference_code)
    {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p class="alert alert-danger">', '</p>');
        
        $this->_check_login();
        
        $this->data['settings'] = $this->settings_m->get_fields();
        
        $this->load->model('language_m');
        $lang_id = $this->language_m->get_id($lang_code);
        $lang_name = $this->language_m->get_name($lang_id);
        $this->lang->load('frontend_template', $lang_name, FALSE, TRUE, FCPATH.'templates/'.$this->data['settings']['template'].'/'); 
        
        $user_id = $this->session->userdata('id');
        $user_type = $this->session->userdata('type');
        $user = $this->user_m->get($user_id);
        $this->data['price'] = number_format($price, 2, '.', '');
        
        $this->data['user'] = $user;
        $this->data['lang_code'] = $lang_code;
        
        $this->data['invoice_num'] = $reference_id.'_'.$reference_code.'_'.$user_id.'_'.$this->data['price'].'_'.date('w');
        $this->data['description'] = $reference_code.' '.$reference_id;
        $this->data['reference_id'] = $reference_id;
        $this->data['reference_code'] = $reference_code;
        $this->data['currency_code'] = $currency_code;

        if($reference_code == 'PAC')
        {
            $this->data['description'] = 'Package '.$reference_id;
        }
        else if($reference_code == 'RES')
        {
            $this->data['description'] = 'Reservation '.$reference_id;
        }
        else if($reference_code == 'ACT')
        {
            $this->data['description'] = 'Activate listing '.$reference_id;
        }
        else if($reference_code == 'FEA')
        {
            $this->data['description'] = 'Featured listing '.$reference_id;
        }
        
        if($this->input->get('confirmed') == 'true')
        {
            // Save invoice into DB
            $this->load->model('invoice_m');
            
            $data_invoice = array();
            $data_invoice['invoice_num'] = $this->data['invoice_num'];
            $data_invoice['date_created'] = date('Y-m-d H:i:s');
            $data_invoice['user_id'] = $user_id;
            $data_invoice['description'] = $this->data['description'];
            $data_invoice['reference_id'] = $reference_id;
            $data_invoice['week'] = date('w');
            $data_invoice['price'] = $this->data['price'];
            $data_invoice['currency_code'] = $currency_code;
            $data_invoice['is_confirmed'] = 1;
            $data_invoice['is_paid'] = 0;
            $data_invoice['is_activated'] = 0;
            $data_invoice['data_json'] = json_encode($this->data);

            if(config_db_item('invoice_auto_activate') == TRUE)
            {
                $data_invoice['is_activated'] = 1;
            }
            
            $invoice_id = $this->invoice_m->save($data_invoice, NULL);

            // [START] Send alert email to administrator
            $config_mail = array();
            $config_mail['mailtype'] = 'html';
            $this->load->library('email');
            $this->email->initialize($config_mail);
            if(!empty($this->data['settings']['email']) && ENVIRONMENT != 'development')
            {
                $this->email->from($this->data['settings_noreply'], lang_check('Web page'));
                $this->email->to($this->data['settings']['email']);
                $this->email->subject(lang_check('Message from real-estate web'));
                
                $data_email = $data_invoice;
                $data_email['name_surname'] = $user->name_surname;
                $data_email['mail'] = $user->mail;
                $data_email['invoice_id'] = $invoice_id;
                //unset($data_email['data_json']);
                
                $message = $this->load->view('email/email_invoice_required', array('data'=>$data_email), TRUE);
                $this->email->message($message);
                $this->email->send();                      
            }
            // [END] Send alert email to administrator

            $this->session->set_flashdata('message', 
                    '<p class="alert alert-success">'.lang_check('Invoice received').'</p>');
            
            if(config_db_item('invoice_auto_activate') == TRUE)
            {
                $this->_activate_invoice($lang_code, $currency_code, $this->data['invoice_num']);
            }
            
            redirect('frontend/myproperties/'.$lang_code);
        }

        $output = $this->load->view($this->data['settings']['template'].'/invoice_print.php', $this->data, TRUE);
        echo str_replace('assets/', base_url('templates/'.$this->data['settings']['template']).'/assets/', $output);
    }
    
    private function _activate_invoice($lang_code, $currency_code, $invoice_num)
    {
        $inv_ex = explode('_', $invoice_num);
        
        if(count($inv_ex)<3)
        {
            print_r($_POST);
            exit('wrong request');
        }
        
        $reference_code = $inv_ex[1];
        $reference_id = $inv_ex[0];

        if($inv_ex[1] == 'RES'){
            $table_id = $inv_ex[0];
            
            // Set reservations paid
            $this->load->model('reservations_m');
            $reservation = $this->reservations_m->get_array_by(array('id'=>$table_id), TRUE);
            
            $data_r = array();
            
            if(empty($reservation['total_paid']))
                $reservation['total_paid'] = 0;
    
            $data_r['total_paid'] = $reservation['total_paid'] + $data['paid'];
            
            if($data_r['total_paid'] >= $reservation['total_price'])
            {
                $data_r['date_paid_total'] = date('Y-m-d H:i:s');
            }
            else
            {
                $data_r['date_paid_advance'] = date('Y-m-d H:i:s');
            }
            
            $data_r['is_confirmed'] = '1';
            
            $this->reservations_m->save($data_r, $table_id);
            
            // redirect to myreservations
            redirect_html('frontend/myreservations/'.$lang_code);
            
        }
        else if($inv_ex[1] == 'PAC')
        {
            $table_id = $inv_ex[2];
            $package_id = $inv_ex[0];
            
            // check if extend or buy
            $user = $this->user_m->get($table_id);
            $from_time = time();
            if(strtotime($user->package_last_payment) > $from_time)
                $from_time = strtotime($user->package_last_payment);
            
            $this->load->model('packages_m');
            $package = $this->packages_m->get($package_id);
            $days_extend = $package->package_days;
            
            // Set package paid
            $data_r = array();
            $data_r['package_last_payment'] = date('Y-m-d H:i:s', $from_time + 86400*intval($days_extend));
            $data_r['package_id'] = $package_id;
            
            $this->user_m->save($data_r, $table_id);
            
            // redirect to myproperties
            if($user_type == 'AGENT')
            {
                redirect_html('admin/packages/mypackage');
            }
            else
            {
                redirect_html('frontend/myproperties/'.$lang_code);
            }
        }
        else if($inv_ex[1] == 'ACT')
        {
            $table_id = $inv_ex[2];
            $property_id = $inv_ex[0];
            
            // check if extend or buy
            $this->load->model('estate_m');
            $estate = $this->estate_m->get($property_id);
            
            // Set package paid
            $data_r = array();
            $data_r['is_activated'] = '1';
            $data_r['activation_paid_date'] = date('Y-m-d H:i:s');
            
            $this->estate_m->save($data_r, $property_id);
            
            // redirect to myproperties
            redirect_html('frontend/myproperties/'.$lang_code);
        }
        else if($inv_ex[1] == 'FEA')
        {
            $table_id = $inv_ex[2];
            $property_id = $inv_ex[0];
            
            // check if extend or buy
            $this->load->model('estate_m');
            $estate = $this->estate_m->get($property_id);
            
            // Set package paid
            $data_r = array();
            $data_r['is_featured'] = '1';
            $data_r['featured_paid_date'] = date('Y-m-d H:i:s');
            
            $this->estate_m->save($data_r, $property_id);
            
            // redirect to myproperties
            redirect_html('frontend/myproperties/'.$lang_code);
        }
        
        exit(lang_check('Thank you very much on your payment!'));
    }
    
}

?>