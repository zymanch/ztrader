<?php

namespace backend\models\base;
use ActiveGenerator\Criteria;
use backend\models\TestLogQuery;

/**
 * This is the ActiveQuery class for [[backend\models\TestLog]].
 * @method TestLogQuery filterByTestLogId($value, $criteria = null)
 * @method TestLogQuery filterByTestId($value, $criteria = null)
 * @method TestLogQuery filterByResponseCode($value, $criteria = null)
 * @method TestLogQuery filterByResponseTimeMs($value, $criteria = null)
 * @method TestLogQuery filterByResponse($value, $criteria = null)
 * @method TestLogQuery filterByStatus($value, $criteria = null)
 * @method TestLogQuery filterByErrorMessage($value, $criteria = null)
 * @method TestLogQuery filterByCreated($value, $criteria = null)
  * @method TestLogQuery orderByTestLogId($order = Criteria::ASC)
  * @method TestLogQuery orderByTestId($order = Criteria::ASC)
  * @method TestLogQuery orderByResponseCode($order = Criteria::ASC)
  * @method TestLogQuery orderByResponseTimeMs($order = Criteria::ASC)
  * @method TestLogQuery orderByResponse($order = Criteria::ASC)
  * @method TestLogQuery orderByStatus($order = Criteria::ASC)
  * @method TestLogQuery orderByErrorMessage($order = Criteria::ASC)
  * @method TestLogQuery orderByCreated($order = Criteria::ASC)
  * @method TestLogQuery withTest($params = [])
  * @method TestLogQuery joinWithTest($params = null, $joinType = 'LEFT JOIN')
 */
class BaseTestLogQuery extends \yii\db\ActiveQuery
{


    use \ActiveGenerator\base\RichActiveMethods;

    /**
     * @inheritdoc
     * @return \backend\models\TestLog[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \backend\models\TestLog|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @return \backend\models\TestLogQuery     */
    public static function model()
    {
        return new \backend\models\TestLogQuery(\backend\models\TestLog::class);
    }
}
