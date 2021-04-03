<?php
namespace backend\models;

use backend\components\Memorize;
use backend\models\base;
use backend\models\base\BaseWebsitePeer;

/**
 * Class Website
 * @package backend\models
 * @property Test[] $tests
 */
class Website extends base\BaseWebsite {

    use Memorize;

    const TYPE_SERVICE = 'service';
    const TYPE_PAYSITE = 'paysite';
    const ENGINE_PHP = 'php';

    public $tests_count = 0;
    public $tests_enabled = 0;
    public $tests_failed = 0;

    /**
     * @return TestQuery
     */
    public function getTests() {
        return $this->hasMany(\backend\models\Test::className(), [base\BaseTestPeer::APPLICATION => BaseWebsitePeer::SHORTNAME]);
    }

    public function getActiveTestsCount() {
        return $this->_memorize('active_test_count',$this->website_id, function() {
            return $this->getTests()->filterByEnabled(Test::ENABLED_YES)->count();
        });
    }

    public function getTotalTestsCount() {
        return $this->_memorize('total_test_count',$this->website_id, function() {
            return $this->getTests()->count();
        });
    }

    public function getFailedTestsCount() {
        return $this->_memorize('false_test_count',$this->website_id, function() {
            return $this->getTests()->filterByStatus(Test::STATUS_ERROR)->count();
        });
    }
}