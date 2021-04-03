<?php
namespace backend\models\forms;

use backend\components\Memorize;
use backend\components\repository\RequestParamsRepository;
use backend\components\repository\TestRepository;
use backend\components\test_param\command\SaveParams;
use backend\components\test_param\Service;
use backend\models\base\BaseTestParamPeer;
use backend\models\TestParamQuery;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class RequestParams extends Model {

    use Memorize;

    const KEY = 'params';

    const SOURCE = 'source';
    const RAW    = 'raw';
    const PARAMS = 'params';

    const SOURCE_RAW    = 'raw';
    const SOURCE_PRETTY = 'pretty';

    const TYPE_LOCAL  = 'local';
    const TYPE_GLOBAL = 'global';

    const KEY_TYPE     = 'type';
    const KEY_SELECTED = 'selected';

    public $source;
    public $raw;
    public $params;
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
    }

    public function rules()
    {
        return [
            [[self::SOURCE,self::PARAMS,self::RAW], 'safe'],
        ];
    }

    public function getRequestData() {
        if ($this->source == self::SOURCE_RAW) {
            return $this->raw;
        }
        return $this->_getRequestDataByPretty();
    }

    private function _getRequestDataByPretty() {
        $result = [];
        foreach ($this->params as $key => $param) {
            $type = $param['type'];
            $result[$key] =  $param[$type];
        }
        return http_build_query($result);
    }

    public function loadRawFromQuery(string $params) {
        $this->source = self::SOURCE_RAW;
        $this->raw = $params;
    }

    public function loadPrettyFromQuery(int $testId, string $params) {
        $this->source = self::SOURCE_PRETTY;
        $this->params = [];
        $this->_fillParamsByQuery($params);
        $this->_fillParamsByGlobal();
        $this->_fillParamsByLocal($testId);
        $this->_fillRawByPretty();
    }

    private function _fillParamsByQuery(string $query) {
        if (!$query) {
            return;
        }
        parse_str($query, $output);
        foreach ($output as $key => $value) {
            $this->params[$key] = [
                self::KEY_TYPE     => self::TYPE_LOCAL,
                self::KEY_SELECTED => $value,
                self::TYPE_LOCAL   => $value,
                self::TYPE_GLOBAL  => null
            ];
        }
    }

    private function _fillParamsByGlobal() {
        $globals = $this->_paramsRepository->getGlobalParams();
        $globals = ArrayHelper::getColumn($globals, BaseTestParamPeer::VALUE);
        foreach ($globals as $key => $value) {
            if (!isset($this->params[$key])) {
                continue;
            }
            $this->params[$key][self::KEY_TYPE] = self::TYPE_GLOBAL;
            $this->params[$key][self::TYPE_GLOBAL] = $value;
            $this->params[$key][self::TYPE_GLOBAL] = $value;
        }
    }
    private function _fillParamsByLocal(int $testId) {
        $locals = $this->_paramsRepository->getLocalParams($testId);
        $locals = ArrayHelper::getColumn($locals, BaseTestParamPeer::VALUE);
        foreach ($locals as $key => $value) {
            if (!isset($this->params[$key])) {
                continue;
            }
            $this->params[$key][self::KEY_TYPE] = self::TYPE_LOCAL;
            $this->params[$key][self::KEY_SELECTED] = $value;
            $this->params[$key][self::TYPE_LOCAL] = $value;
        }
    }

    private function _fillRawByPretty() {
        $this->raw = $this->_getRequestDataByPretty();
    }


    public function save($testId) {
        if ($this->source == self::SOURCE_PRETTY) {
            $service = new Service($this->_testRepository, $this->_paramsRepository);
            $service->saveTestParams($testId, $this->params);
        }
    }

}