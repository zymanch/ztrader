<?php
namespace backend\models;

use backend\models\base;

class Trader extends base\BaseTrader {

    public function getBuyerOptions()
    {
        return json_decode($this->buyer_options,1);
    }


    public function getSellerOptions()
    {
        return json_decode($this->seller_options,1);
    }
}