<?php

namespace ejen\payment;

use yii\base\InvalidConfigException;

class Okpay extends \yii\base\Component
{
    public $wallet;

    public function init()
    {
        parent::init();

        if (!$this->wallet)
        {
            throw new InvalidConfigException("`wallet` is required");
        }
    }
}
