<?php
namespace backend\models\forms;

use backend\components\contract\TestRequest;
use backend\components\Executor;
use backend\components\repository\RequestParamsRepository;
use backend\components\repository\TestRepository;
use backend\models\base\BaseTestPeer;
use backend\models\Test;
use yii\base\Model;

class RunTest extends Model implements TestRequest {


    public $method;
    public $url;
    /** @var RequestParams */
    public $params;

    public $response;
    public $response_code;
    public $response_time;

    /**
     * @var RequestParamsRepository
     */
    private $_paramsRepository;
    /**
     * @var TestRepository
     */
    private $_testRepository;

    public function __construct(TestRepository $testRepository, RequestParamsRepository $paramsRepository)
    {
        parent::__construct();
        $this->_testRepository = $testRepository;
        $this->_paramsRepository = $paramsRepository;
        $this->params = new RequestParams($testRepository, $paramsRepository);
    }


    public function rules()
    {
        return [
            [[BaseTestPeer::METHOD, BaseTestPeer::URL,BaseTestPeer::REQUEST_DATA], 'safe'],
        ];
    }

    public function setAttributes($values, $safeOnly = true) {
        if (isset($values[RequestParams::KEY])) {
            $this->params->setAttributes($values[RequestParams::KEY]);
            unset($values[RequestParams::KEY]);
        }
        return parent::setAttributes($values, $safeOnly);
    }

    public function run() {
        $executor = new Executor();
        $executor->exec($this);
    }


    public function getMethod() {
        return $this->method;
    }

    public function getFullUrl() {
        return $this->url;
    }

    public function getRequestData() {
        return $this->params->getRequestData();
    }

    public function setResponse($response, $httpCode, $durationMs) {
        $this->response = $response;
        $this->response_code = $httpCode;
        $this->response_time = $durationMs;
    }

    public function loadFromTest(Test $test) {
        $this->method = $test->getMethod();
        $this->url = $test->getFullUrl();
        $this->params->loadPrettyFromQuery($test->test_id, $test->request_data);

        $this->response = $test->response;
        $this->response_code = $test->response_code;
        $this->response_time = $test->response_time_ms;


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

    public function getDebugUrl() {
        $url = $this->getFullUrl();
        $url.=strpos($url,'?') ? '&' : '?';
        $url.=$this->getRequestData() . ($this->getRequestData() ? '&' : '');
        if ($this->method !== Test::METHOD_GET) {
            $url.='method='.$this->method;
        }
        return $url;
    }
    public function isResponseJson() {
        return $this->response && $this->response[0]=='{';
    }

    public function formName()
    {
        return '';
    }
}