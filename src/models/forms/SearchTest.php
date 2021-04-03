<?php
namespace backend\models\forms;

use backend\components\contract\SearchTestParams;
use backend\components\repository\TestRepository;
use backend\models\base\BaseTestPeer;
use backend\models\Test;
use yii\base\Model;
use yii\data\ArrayDataProvider;

class SearchTest extends Model implements SearchTestParams{

    public $application;
    public $enabled;
    public $status;
    public $name;
    public $method;

    public function rules()
    {
        return [
            [[BaseTestPeer::APPLICATION, BaseTestPeer::ENABLED,BaseTestPeer::STATUS,BaseTestPeer::NAME,BaseTestPeer::METHOD], 'safe'],
        ];
    }

    public function search() {
        $repository = new TestRepository;
        $models = $repository->search($this);
        return new ArrayDataProvider([
            'allModels' => $models,
            'pagination' => false,
            'sort'  => [
                'attributes'   => [
                    BaseTestPeer::STATUS,
                    BaseTestPeer::TEST_ID,
                    BaseTestPeer::APPLICATION => [
                        'asc' => [BaseTestPeer::APPLICATION => SORT_ASC, BaseTestPeer::STATUS => SORT_DESC, BaseTestPeer::NAME => SORT_ASC],
                        'desc' => [BaseTestPeer::APPLICATION => SORT_DESC, BaseTestPeer::STATUS => SORT_DESC, BaseTestPeer::NAME => SORT_ASC],
                    ],
                    BaseTestPeer::NAME,
                    BaseTestPeer::METHOD
                ],
                'defaultOrder' => [
                    BaseTestPeer::STATUS => SORT_ASC,
                ],
            ],
        ]);
    }


    public function getApplications() {
        return array_filter(explode(',', $this->application));
    }

    public function getTestIds() {
        return [];
    }

    public function getEnabled() {
        return $this->enabled ? ($this->enabled == Test::ENABLED_YES) : null;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getPartOfName() {
        return $this->name;
    }

    public function getSort() {
        return [];
    }
}