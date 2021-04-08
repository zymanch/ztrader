<?php
namespace backend\models;

use backend\models\base;

class Trader extends base\BaseTrader {

    const STATUS_ENABLED = 'enabled';
    const STATUS_DISABLED = 'disabled';
    const STATUS_PAUSED = 'paused';

    const STATE_SELLING = 'selling';
    const STATE_BUYING = 'buying';

    public function getBuyerOptions()
    {
        return json_decode($this->buyer_options,1);
    }


    public function getSellerOptions()
    {
        return json_decode($this->seller_options,1);
    }

    public function getMonthlyIncome() {
        $result = 0;
        $histories = TraderHistoryQuery::model()->orderByDate()->all();
        if (count($histories) <=1) {
            return null;
        }
        $buy = null;
        foreach ($histories as $history) {
            if ($history->action == TraderHistory::ACTION_BUY) {
                $buy = $history->course * (1+$history->comission_percent/100);
            } else {
                $result += $history->course * (1-$history->comission_percent/100)/$buy;
            }
        }
        $from = new \DateTime(reset($histories)->date);
        $to = new \DateTime(end($histories)->date);
        $duration = $from->diff($to)->days + 1;
        return round(100 * $result * 30 / $duration,2);
    }
}