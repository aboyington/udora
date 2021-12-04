<?php

class Qr_code {

    public function read($image)
    {
        $this->CI = &get_instance();
        $this->CI->load->library('MY_Composer');
        $qrcode = new  Zxing\QrReader($image);
        $text = $qrcode->text(); //return decoded text from QR Code
        
        return $text;
    }

}
