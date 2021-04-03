<?php
namespace backend\models\forms;

use backend\components\command\Run;
use backend\components\repository\ApplicationRepository;
use backend\components\repository\RequestParamsRepository;
use backend\components\repository\TestRepository;
use backend\models\base\BaseTestPeer;
use backend\models\Test;
use yii\base\Model;

class SaveTest extends Model {

    public $method;
    public $url;
    /** @var RequestParams */
    public $params;
    /** @var Validation */
    public $validation;
    public $name;
    /**
     * @var TestRepository
     */
    private $_testRepository;
    /**
     * @var RequestParamsRepository
     */
    private $_paramsRepository;

    public function __construct(TestRepository $testRepository, RequestParamsRepository $paramsRepository)
    {
        parent::__construct();
        $this->_testRepository = $testRepository;
        $this->_paramsRepository = $paramsRepository;

        $this->params = new RequestParams($this->_testRepository, $this->_paramsRepository);
        $this->validation = new Validation;
    }


    public function rules()
    {
        return [
            [[BaseTestPeer::METHOD, BaseTestPeer::URL,BaseTestPeer::REQUEST_DATA,BaseTestPeer::NAME], 'safe'],
        ];
    }

    public function setAttributes($values, $safeOnly = true) {
        if (isset($values[RequestParams::KEY])) {
            $this->params->setAttributes($values[RequestParams::KEY]);
            unset($values[RequestParams::KEY]);
        }
        if (isset($values[Validation::KEY])) {
            $this->validation->setAttributes($values[Validation::KEY]);
            unset($values[Validation::KEY]);
        }
        return parent::setAttributes($values, $safeOnly);
    }

    public function save($testId) {
        $test = $this->_testRepository->getOne($testId);
        $this->_save($test);
        $this->_refillResponse($test);
    }

    private function _save(Test $test) {
        $test->method = $this->method;
        $test->url = $this->_getRelativeUrl($test);
        $test->request_data = $this->params->getRequestData();
        if ($this->name) {
            $test->name = $this->name;
        }
        if (!$test->save()) {
            throw new \InvalidArgumentException('Failed save test: '.json_encode($test->getErrors()));
        }
        $this->validation->save($test);
        $this->params->save($test->test_id);
    }

    private function _refillResponse(Test $test) {
        $command = new Run($this->_testRepository, $test->test_id);
        $command->execute();
    }

    private function _getRelativeUrl(Test $test) {
        $repository = new ApplicationRepository();
        $website = $repository->getOne($test->application);
        $websiteUrl = rtrim($website->url,'/').'/';
        if(strpos($this->url, $websiteUrl)!==0) {
            throw new \InvalidArgumentException('Url "'.$this->url.'" not from "'.$test->application.'" application');
        }
        return substr($this->url, strlen($websiteUrl));
    }

    public function loadFromTest(Test $test) {
        $this->method = $test->getMethod();
        $this->url = $test->getFullUrl();
        $this->name = $test->name;
        $this->params->loadPrettyFromQuery($test->test_id, $test->request_data);
        $this->validation->loadFromTest($test);
    }

    public function formName()
    {
        return '';
    }
}