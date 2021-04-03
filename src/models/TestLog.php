<?php
namespace backend\models;

use backend\models\base;

class TestLog extends base\BaseTestLog {

    const STATUS_OK = 'ok';
    const STATUS_ERROR = 'error';

    public function getResponseAsHtml() {
        if (!$this->response) {
            return '';
        }
        if ($this->response[0]=='{') {
            return json_encode(json_decode($this->response, 1), JSON_PRETTY_PRINT);
        }
        return $this->response;
    }

}