<?php
namespace backend\models;

use backend\models\base;

class TraderImitation extends base\BaseTraderImitation {

    const STATUS_WAITING = 'waiting';
    const STATUS_PROCESSING = 'processing';
    const STATUS_FINISHED = 'finished';
    const STATUS_FAILED = 'failed';
}