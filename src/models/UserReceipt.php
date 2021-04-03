<?php
namespace backend\models;

use backend\models\base;

class UserReceipt extends base\BaseUserReceipt {
    const STATUS_USED = 'used';
    const STATUS_UNUSABLE = 'unusable';
    const STATUS_SKIPPED = 'skipped';
}