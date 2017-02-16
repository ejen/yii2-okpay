<?php

namespace ejen\payment\okpay;

use yii\helpers\Url;

class Payment extends \yii\base\Model
{
    public $component;

    public $receiver;
    public $currency;
    public $invoice;
    public $ipn;

    public $items = [];

    public function rules()
    {
        // @todo Currency check
        // @todo Receiver check
        // @todo Items count check

        return [];
    }

    public function getUrl()
    {
        if (!$this->validate()) return false;

        $params = [
            'ok_receiver' => $this->receiver ? $this->receiver : $this->component->receiver,
            'currency' => $this->currency ? $this->currency : $this->component->currency,
        ];

        foreach($this->items as $i => $item)
        {
            foreach($item as $key => $value)
            {
                $index = $i + 1;
                $params["ok_item_{$index}_{$key}"] = $value;
            }
        }

        if ($this->invoice)
        {
            $params['ok_invoice'] = $this->invoice;
        }

        if ($this->ipn || $this->component->ipn)
        {
            $params['ok_ipn'] = Url::to($this->ipn ? $this->ipn : $this->component->ipn, true);
        }

        return $this->component->baseUrl.'?'.http_build_query($params);
    }
}
