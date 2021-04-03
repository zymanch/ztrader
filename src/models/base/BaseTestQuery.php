<?php

namespace backend\models\base;
use ActiveGenerator\Criteria;
use backend\models\TestQuery;

/**
 * This is the ActiveQuery class for [[backend\models\Test]].
 * @method TestQuery filterByTestId($value, $criteria = null)
 * @method TestQuery filterByApplication($value, $criteria = null)
 * @method TestQuery filterByEngine($value, $criteria = null)
 * @method TestQuery filterByName($value, $criteria = null)
 * @method TestQuery filterByMethod($value, $criteria = null)
 * @method TestQuery filterByUrl($value, $criteria = null)
 * @method TestQuery filterByRequestData($value, $criteria = null)
 * @method TestQuery filterByCheckPeriodMinutes($value, $criteria = null)
 * @method TestQuery filterByExpectedResponseCode($value, $criteria = null)
 * @method TestQuery filterByResponseCode($value, $criteria = null)
 * @method TestQuery filterByMaxExecutionTimeMs($value, $criteria = null)
 * @method TestQuery filterByResponseTimeMs($value, $criteria = null)
 * @method TestQuery filterByMemoryUsageMb($value, $criteria = null)
 * @method TestQuery filterByTotalExecutionCount($value, $criteria = null)
 * @method TestQuery filterByTotalExecutionTime($value, $criteria = null)
 * @method TestQuery filterByResponseDataCheckStrategy($value, $criteria = null)
 * @method TestQuery filterByResponseDataCheck($value, $criteria = null)
 * @method TestQuery filterByResponse($value, $criteria = null)
 * @method TestQuery filterByEnabled($value, $criteria = null)
 * @method TestQuery filterByStatus($value, $criteria = null)
 * @method TestQuery filterByErrorMessage($value, $criteria = null)
 * @method TestQuery filterByLastChecked($value, $criteria = null)
 * @method TestQuery filterByCreated($value, $criteria = null)
 * @method TestQuery filterByHash($value, $criteria = null)
  * @method TestQuery orderByTestId($order = Criteria::ASC)
  * @method TestQuery orderByApplication($order = Criteria::ASC)
  * @method TestQuery orderByEngine($order = Criteria::ASC)
  * @method TestQuery orderByName($order = Criteria::ASC)
  * @method TestQuery orderByMethod($order = Criteria::ASC)
  * @method TestQuery orderByUrl($order = Criteria::ASC)
  * @method TestQuery orderByRequestData($order = Criteria::ASC)
  * @method TestQuery orderByCheckPeriodMinutes($order = Criteria::ASC)
  * @method TestQuery orderByExpectedResponseCode($order = Criteria::ASC)
  * @method TestQuery orderByResponseCode($order = Criteria::ASC)
  * @method TestQuery orderByMaxExecutionTimeMs($order = Criteria::ASC)
  * @method TestQuery orderByResponseTimeMs($order = Criteria::ASC)
  * @method TestQuery orderByMemoryUsageMb($order = Criteria::ASC)
  * @method TestQuery orderByTotalExecutionCount($order = Criteria::ASC)
  * @method TestQuery orderByTotalExecutionTime($order = Criteria::ASC)
  * @method TestQuery orderByResponseDataCheckStrategy($order = Criteria::ASC)
  * @method TestQuery orderByResponseDataCheck($order = Criteria::ASC)
  * @method TestQuery orderByResponse($order = Criteria::ASC)
  * @method TestQuery orderByEnabled($order = Criteria::ASC)
  * @method TestQuery orderByStatus($order = Criteria::ASC)
  * @method TestQuery orderByErrorMessage($order = Criteria::ASC)
  * @method TestQuery orderByLastChecked($order = Criteria::ASC)
  * @method TestQuery orderByCreated($order = Criteria::ASC)
  * @method TestQuery orderByHash($order = Criteria::ASC)
  * @method TestQuery withTestLogs($params = [])
  * @method TestQuery joinWithTestLogs($params = null, $joinType = 'LEFT JOIN')
  * @method TestQuery withTestParams($params = [])
  * @method TestQuery joinWithTestParams($params = null, $joinType = 'LEFT JOIN')
 */
class BaseTestQuery extends \yii\db\ActiveQuery
{


    use \ActiveGenerator\base\RichActiveMethods;

    /**
     * @inheritdoc
     * @return \backend\models\Test[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \backend\models\Test|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @return \backend\models\TestQuery     */
    public static function model()
    {
        return new \backend\models\TestQuery(\backend\models\Test::class);
    }
}
