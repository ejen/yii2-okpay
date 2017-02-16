<?php

namespace ejen\payment\okpay;

use Yii;

class IpnAction extends \yii\base\Action
{
    public $verifyUrl = 'https://checkout.okpay.com/ipn-verify';

    public $successCallback;
    public $failCallback;

    public function run()
    {
        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => 'ok_verify=true&'.http_build_query($_POST),
            ],
        ]);
        $response = file_get_contents($this->verifyUrl, false, $context);
        if (($response != 'TEST' && $response != 'VERIFIED') || $_POST['ok_txn_status'] != 'completed')
        {
            if (!$this->failCallback)
            {
                Yii::$app->end();
            }
            return call_user_func_array($this->failCallback, [$_POST]);
        }

        if (!$this->successCallback)
        {
            Yii::$app->end();
        }
        return call_user_func_array($this->successCallback, [$_POST]);
    }
}
