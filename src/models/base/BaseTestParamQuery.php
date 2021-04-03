<?php

namespace backend\models\base;
use ActiveGenerator\Criteria;
use backend\models\TestParamQuery;

/**
 * This is the ActiveQuery class for [[backend\models\TestParam]].
 * @method TestParamQuery filterByTestParamId($value, $criteria = null)
 * @method TestParamQuery filterByTestId($value, $criteria = null)
 * @method TestParamQuery filterByName($value, $criteria = null)
 * @method TestParamQuery filterByValue($value, $criteria = null)
  * @method TestParamQuery orderByTestParamId($order = Criteria::ASC)
  * @method TestParamQuery orderByTestId($order = Criteria::ASC)
  * @method TestParamQuery orderByName($order = Criteria::ASC)
  * @method TestParamQuery orderByValue($order = Criteria::ASC)
  * @method TestParamQuery withTest($params = [])
  * @method TestParamQuery joinWithTest($params = null, $joinType = 'LEFT JOIN')
 */
class BaseTestParamQuery extends \yii\db\ActiveQuery
{


    use \ActiveGenerator\base\RichActiveMethods;

    /**
     * @inheritdoc
     * @return \backend\models\TestParam[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \backend\models\TestParam|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @return \backend\models\TestParamQuery     */
    public static function model()
    {
        return new \backend\models\TestParamQuery(\backend\models\TestParam::class);
    }
}
