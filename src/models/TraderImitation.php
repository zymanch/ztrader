<?php
namespace backend\models;

use backend\models\base;

class TraderImitation extends base\BaseTraderImitation {

    const STATUS_WAITING = 'waiting';
    const STATUS_PROCESSING = 'processing';
    const STATUS_FINISHED = 'finished';
    const STATUS_FAILED = 'failed';

    public function getMonthlyIncome() {
        $result = 0;
        $histories = $this->getTraderHistories()->orderByDate()->all();
        if (count($histories) <=1) {
            return null;
        }
        $buy = null;
        foreach ($histories as $history) {
            if ($history->action == TraderHistory::ACTION_BUY) {
                $buy = $history->course * (1+$history->comission_percent/100);
            } else {
                $result+= $history->course * (1-$history->comission_percent/100)/$buy-1;
            }
        }
        $from = new \DateTime(reset($histories)->date);
        $to = new \DateTime(end($histories)->date);
        $duration = $from->diff($to)->days + 1;
        return round(100 * $result * 30 / $duration,2);
    }
}