<?php
namespace backend\models;

use backend\models\base;
use backend\models\forms\RequestParams;

class TestParam extends base\BaseTestParam {

    public $use_count;

    public function getType() {
        return $this->test_id ? RequestParams::TYPE_LOCAL : RequestParams::TYPE_GLOBAL;
    }
}