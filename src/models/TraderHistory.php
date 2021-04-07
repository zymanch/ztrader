<?php
namespace backend\models;

use backend\models\base;
use backend\models\base\BaseTraderHistoryPeer;

/**
 * Class TraderHistory
 * @package backend\models
 * @property TraderHistory|null $sellTraderHistory
 */
class TraderHistory extends base\BaseTraderHistory {

    const ACTION_SALE = 'sale';
    const ACTION_BUY = 'buy';

    const TYPE_VIRTUAL = 'virtual';
    const TYPE_REAL = 'real';

    /**
     * @return \backend\models\TraderHistoryQuery
     */
    public function getSellTraderHistory() {
        return $this->hasOne(\backend\models\TraderHistory::className(), [BaseTraderHistoryPeer::BUY_TRADER_HISTORY_ID => BaseTraderHistoryPeer::TRADER_HISTORY_ID]);
    }
}