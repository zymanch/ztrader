<?php
namespace backend\models;

use backend\models\base;

class TraderHistory extends base\BaseTraderHistory {

    const ACTION_SALE = 'sale';
    const ACTION_BUY = 'buy';

    const TYPE_VIRTUAL = 'virtual';
    const TYPE_REAL = 'real';
}