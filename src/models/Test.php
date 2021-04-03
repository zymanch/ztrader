<?php
namespace backend\models;

use backend\components\contract\TestRequest;
use backend\components\Memorize;
use backend\components\repository\ApplicationRepository;
use backend\components\repository\RequestParamsRepository;
use backend\components\repository\TestRepository;
use backend\components\test_param\Service;
use backend\models\base;

class Test extends base\BaseTest implements TestRequest{

    use Memorize;

    const ENABLED_YES = 'yes';
    const ENABLED_NO = 'no';

    const STATUS_OK = 'ok';
    const STATUS_ERROR = 'error';


    const STATUSES = [
        self::STATUS_OK,
        self::STATUS_ERROR,
    ];

    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_DELETE = 'DELETE';

    const METHODS = [
        self::METHOD_GET,
        self::METHOD_POST,
        self::METHOD_PUT,
        self::METHOD_DELETE
    ];

    const CHECK_STRATEGY_NONE = 'none';
    const CHECK_STRATEGY_EQUAL = 'equal';
    const CHECK_STRATEGY_CONTAINS = 'contains';
    const CHECK_STRATEGY_JSON_PROPERTY_EQUAL = 'json_property_equal';

    const CHECK_STRATEGIES = [
        self::CHECK_STRATEGY_NONE,
        self::CHECK_STRATEGY_EQUAL,
        self::CHECK_STRATEGY_CONTAINS,
        self::CHECK_STRATEGY_JSON_PROPERTY_EQUAL,

    ];
    const ENGINE_REST = 'rest';
    const ENGINE_API = 'api';
    const ENGINE_CONTROLLER = 'controller';


    public function getFullUrl() {
        if (str_starts_with($this->url, 'http')) {
            return $this->url;
        }
        $repository = new ApplicationRepository();
        $website = $repository->getOne($this->application);

        if(!$website->url){
            throw new \RuntimeException('Application ' . $this->application . ' does not contain url');
        }

        return trim($website->url,'/').'/'.ltrim($this->url,'/');
    }

    public function isAlreadyChecked() {
        if (!$this->last_checked) {
            return false;
        }
        return strtotime($this->last_checked) + $this->check_period_minutes*60 > time();
    }

    public function getDebugUrl() {
        $url = $this->getFullUrl();
        $url.=strpos($url,'?') ? '&' : '?';
        $url.=$this->getRequestData() . ($this->request_data ? '&' : '');
        if ($this->method !== self::METHOD_GET) {
            $url.='method='.$this->method;
        }
        return $url;
    }


    public function saveToLog() {
        $log = new TestLog();
        $log->test_id = $this->test_id;
        $log->response = $this->response;
        $log->response_code = $this->response_code;
        $log->response_time_ms = $this->response_time_ms;
        $log->status = $this->status;
        $log->error_message = $this->error_message;
        if (!$log->save()) {
            throw new \InvalidArgumentException('Error durring save log: ' . json_encode(array_filter($log->getErrors())));
        }
        return $log->test_log_id;
    }

    public function getResponseAsHtml() {
        if (!$this->response) {
            return '';
        }
        if ($this->response[0]=='{') {
            return json_encode(json_decode($this->response, 1), JSON_PRETTY_PRINT);
        }
        return $this->response;
    }

    public function attributeLabels() {
        return array_merge(
            parent::attributeLabels(),
            [
                base\BaseTestPeer::REQUEST_DATA => 'Request Params'
            ]
        );
    }

    public static function getApplicationVariants() {
        return self::_memorizeStatic('applications',[],function(){
            $repository = new ApplicationRepository();
            $result = [];
            foreach ($repository->getAllWithTests() as $website) {
                $result[] = $website->shortname;
            }
            sort($result);
            return $result;
        });
    }

    public function getMethod() {
        return $this->method;
    }

    public function getRequestData() {
        $testRepository = new TestRepository;
        $paramsRepository = new RequestParamsRepository;
        $service = new Service($testRepository, $paramsRepository);
        return $service->getTestParamsAsQuery($this->test_id);
    }

    public function getRequestDataAsArray() {
        if (!$this->request_data) {
            return [];
        }
        parse_str($this->request_data, $result);
        return is_array($result) ? $result : [];
    }

    public function setResponse($response, $httpCode, $durationMs) {

        $this->last_checked = date('Y-m-d H:i:s');
        $this->response = $response ? $response : 'empty';
        $this->response_time_ms = $durationMs;
        if (2*$this->max_execution_time_ms > $durationMs) {
            $this->total_execution_count++;
            $this->total_execution_time += $durationMs;
        }
        $this->response_code = $httpCode;
    }

    public function isResponseJson() {
        return $this->response && $this->response[0]=='{';
    }
}