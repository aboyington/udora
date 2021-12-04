<?php

namespace Omnipay\PayU\Message;

use Omnipay\Common\CreditCard;
use Omnipay\Common\Item;
use Omnipay\Common\Message\AbstractRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * PayU Purchase Request
 */
class PurchaseRequest extends AbstractRequest
{
    /**
     * @var array
     */
    protected $endpoints = array(
        'authorize' => 'https://secure.payu.com.tr/order/alu/v3',
        'purchase' => 'https://secure.payu.com.tr/order/alu/v3',
        'test' => 'http://secure.payu.com.tr/order/alu/v3',
    );
    /**
     * @var array
     */
    protected $identityTypes = array(
        'NCZ',
        'PSPRT',
        'EHLIYET',
    );

    /**
     * @return mixed
     */
    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }

    /**
     * @return mixed
     */
    public function getSecretKey()
    {
        return $this->getParameter('secretKey');
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setSecretKey($value)
    {
        return $this->setParameter('secretKey', $value);
    }
    /**
     * @param $endpoint
     * @return mixed
     */
    public function getEndpoint($endpoint)
    {
        return $this->getTestMode() ? $this->endpoints['test'] : $this->endpoints[$endpoint];
    }

    /**
     * @return mixed
     */
    public function getIdentityNumber(){
        return $this->getParameter('identityNumber');
    }

    /**
     * @param $value
     * @return AbstractRequest
     */
    public function setIdentityNumber($value){
        return $this->setParameter('identityNumber',$value);
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getIdentityType(){
        $type = $this->getParameter('identityType');
        if(!in_array($type,$this->identityTypes)){
            throw new \Exception("Invalid identity type ($type). Available types: ". implode(',',$this->identityTypes));
        }
        return $type;
    }

    /**
     * @param $value
     */
    public function setIdentityType($value){
        $this->setParameter('identityType',$value);
    }

    /**
     * @return int
     * @throws \Exception
     */
    public function getInstallment(){
        $installment = $this->getParameter('installment');
        if(false == $installment){
            return 1;
        }
        if( $installment <1 || $installment >12){
            throw new \Exception('Invalid installment number');
        }
        return $installment;
    }

    /**
     * @param $value
     * @return AbstractRequest
     */
    public function setInstallment($value){
        return $this->setParameter('installment',$value);
    }
    /**
     * The date when the order is initiated in the system, in YYYY-MM-DD HH:MM:SS format (e.g.: "2012-05-01 21:15:45")
     * Important: Date should be UTC standard +/-10 minutes
     * @return mixed
     */
    public function getOrderDate(){
        return $this->getParameter('orderDate');
    }
    /**
     * @param $value
     * @return AbstractRequest
     */
    public function setOrderDate($value){
        return $this->setParameter('orderDate',$value);
    }

    /**
     * @return mixed
     */
    public function getOrderVat(){
        return $this->getParameter('orderVat'); // todo : cana sor
    }

    /**
     * @param $value
     * @return AbstractRequest
     */
    public function setOrderVat($value){
        return $this->setParameter('orderVat',$value);
    }

    /**
     * @return mixed
     */
    public function getOrderPriceType(){
        return $this->getParameter('orderPriceType'); // todo : cana sor
    }
    /**
     * @param $value
     * @return AbstractRequest
     */
    public function setOrderPriceType($value){
        return $this->setParameter('orderPriceType',$value);
    }
    /**
     * @return array
     * @throws \Omnipay\Common\Exception\InvalidCreditCardException
     */
    public function getData()
    {
        $data = array();
        $data['MERCHANT'] = $this->getMerchantId();
        $data['ORDER_REF'] = $this->getTransactionReference();
        $data['ORDER_DATE'] = $this->getOrderDate();
        $data['PAY_METHOD'] = $this->getPaymentMethod();
        $data['BACK_REF'] = $this->getReturnUrl();
        $data['ORDER_TIMEOUT'] = 1000;


        // Product Details
        $items = $this->getItems();
        if( !empty($items)){
            /** @var Item $item */
            foreach ($this->getItems() as $key => $item) {
                $data['ORDER_PNAME[' . $key . ']'] = $item->getName();
                $data['ORDER_PCODE[' . $key . ']'] = $item->getName();
                $data['ORDER_PINFO[' . $key . ']'] = $item->getName();
                $data['ORDER_PRICE[' . $key . ']'] = $item->getPrice();
                $data['ORDER_VAT[' . $key . ']'] = $this->getOrderVat();
                $data['ORDER_PRICE_TYPE[' . $key . ']'] = $this->getParameter('orderPriceType'); // todo : cana sor
                $data['ORDER_QTY[' . $key . ']'] = $item->getQuantity();
            }
        }
        /** @var CreditCard $card */
        $card = $this->getCard();

        // Billing Details
        $data['BILL_LNAME'] = $card->getBillingLastName();
        $data['BILL_FNAME'] = $card->getBillingFirstName();
        $data['BILL_EMAIL'] = $card->getEmail();
        $data['BILL_PHONE'] = $card->getBillingPhone();
        $data['BILL_COUNTRYCODE'] = $card->getBillingCountry();
        $data['BILL_CITYPE'] = $this->getIdentityType();
        $data['BILL_CINUMBER'] = $this->getIdentityNumber();

        // Card Details
        // If card is not valid then throw InvalidCreditCardException.
        $card->validate();
        $data['CC_NUMBER'] = $card->getNumber();
        $data['EXP_MONTH'] = $card->getExpiryMonth();
        $data['EXP_YEAR'] = $card->getExpiryYear();
        $data['CC_CVV'] = $card->getCvv();
        $data['CC_OWNER'] = $card->getName();

        // Other Details
        $data['CLIENT_IP'] = $this->getClientIp();
        $data['SELECTED_INSTALLMENTS_NUMBER'] = $this->getInstallment();
        $data['PRICES_CURRENCY'] = $this->getCurrency();
        // Order Hash
        $data["ORDER_HASH"] = $this->generateHash($data);
        $this->printCurlOutput($data);
        return $data;
    }

    /**
     * @param $data
     * @return Response
     */
    protected function createResponse($data)
    {
        return $this->response = new Response($this, $data);
    }
    /**
     * @param $data
     * @return PurchaseResponse
     */
    public function sendData($data)
    {
        $httpRequest = $this->httpClient->post($this->getEndpoint('test'), null, http_build_query($data));
        //$httpRequest->getCurlOptions()->set(CURLOPT_SSLVERSION, 6); // CURL_SSLVERSION_TLSv1_2 for libcurl < 7.35
        $response = $httpRequest->send();
        $xmlData = json_decode(json_encode($response->xml()),1);
        $data = array();
        foreach($xmlData as $key => $value){
            $data[$key] = empty($value) ? null: $value;
        }
        return new PurchaseResponse($this,$data);
    }

    /**
     * HMAC_MD5 signature applied on all parameters from the request.
     * Source string for HMAC_MD5 will be calculated by adding the length
     * of each field value at the beginning of field value. A common key
     * shared between PayU and the merchant is used for the signature.
     * Find more details on how is HASH generated https://secure.payu.com.tr/docs/alu/v3/#hash
     * @param array $data
     * @return string
     */
    public function generateHash(array $data)
    {
        if ($this->getSecretKey()) {
            //begin HASH calculation
            ksort($data);
            $hashString = "";
            foreach ($data as $key => $val) {
                $hashString .= strlen($val) . $val;
            }
            return hash_hmac("md5", $hashString, $this->getSecretKey());
        }
    }
}