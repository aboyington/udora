<?php

namespace Omnipay\Payu\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\Common\Message\RequestInterface;

/**
 * PayU Purchase Response
 */
class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    public function isRedirect()
    {
        return $this->data->RETURN_CODE == '3DS_ENROLLED';
    }

    public function isSuccessful()
    {
        //$this->validateResponse();
        if(!isset($this->data['STATUS'])){
            return false;
        }
        return $this->data['STATUS'] == 'SUCCESS';
    }

    public function getMessage()
    {
        if($this->isSuccessful()){
            return $this->data['RETURN_MESSAGE'];
        }
        return null;
    }

    public function getRedirectUrl()
    {
        return $this->data['URL_3DS'];
    }

    public function getRedirectMethod()
    {
        return 'POST';
    }

    public function getRedirectData()
    {
        return $this->data;
    }
    private function validateResponse(){
        ksort($this->data);
        $hash = $this->request->generateHash($this->data);
        if($hash !== $this->data["HASH"]){
            throw new \Exception('Invalid response');
        }
    }
}
