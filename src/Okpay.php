<?php

namespace ejen\payment;

use ejen\payment\okpay\Payment; 

class Okpay extends \yii\base\Component
{
    public $baseUrl = 'https://checkout.okpay.com/';

    public $receiver;
    public $currency;
    public $ipn;

    public function createPayment($params)
    {
        $params['component'] = $this;
        return new Payment($params);
    }
}
