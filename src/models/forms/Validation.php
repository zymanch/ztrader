<?php
namespace backend\models\forms;

use backend\components\Memorize;
use backend\models\Test;
use yii\base\Model;

class Validation extends Model {

    use Memorize;

    const KEY = 'validation';

    const STRATEGY               = 'strategy';
    const DATA_EQUAL             = 'data_equal';
    const DATA_CONTAINS          = 'data_contains';
    const DATA_JSON              = 'data_json';
    const MAX_EXECUTION_TIME_MS  = 'max_execution_time_ms';
    const EXPECTED_RESPONSE_CODE = 'expected_response_code';

    public $strategy;
    public $data_equal;
    public $data_contains;
    public $data_json;

    public $max_execution_time_ms;
    public $expected_response_code;


    public function rules()
    {
        return [
            [[self::STRATEGY,self::DATA_EQUAL,self::DATA_CONTAINS,self::DATA_JSON,self::MAX_EXECUTION_TIME_MS, self::EXPECTED_RESPONSE_CODE], 'safe'],
        ];
    }


    public function loadFromTest(Test $test) {
        $this->strategy = $test->response_data_check_strategy;
        $this->data_equal = $test->response_data_check;
        $this->data_contains = $test->response_data_check;
        $this->data_json = $test->response_data_check;

        $this->max_execution_time_ms = $test->max_execution_time_ms;
        $this->expected_response_code = $test->expected_response_code;
    }

    public function save(Test $test) {
        $test->max_execution_time_ms = $this->max_execution_time_ms;
        $test->expected_response_code = $this->expected_response_code;

        $test->response_data_check_strategy = $this->strategy;
        switch ($this->strategy) {
            case Test::CHECK_STRATEGY_NONE:
                $test->response_data_check = null;
                break;
            case Test::CHECK_STRATEGY_EQUAL:
                $test->response_data_check = $this->data_equal;
                break;
            case Test::CHECK_STRATEGY_CONTAINS:
                $test->response_data_check = $this->data_contains;
                break;
            case Test::CHECK_STRATEGY_JSON_PROPERTY_EQUAL:
                $test->response_data_check = $this->data_json;
                break;
        }
        if (!$test->save()) {
            throw new \InvalidArgumentException('Failed save test validation: '.json_encode($test->getErrors()));
        }
    }

}