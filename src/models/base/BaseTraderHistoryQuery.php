<?php

namespace backend\models\base;
use ActiveGenerator\Criteria;
use backend\models\TraderHistoryQuery;

/**
 * This is the ActiveQuery class for [[backend\models\TraderHistory]].
 * @method TraderHistoryQuery filterByTraderHistoryId($value, $criteria = null)
 * @method TraderHistoryQuery filterByTraderId($value, $criteria = null)
 * @method TraderHistoryQuery filterByTraderImitationId($value, $criteria = null)
 * @method TraderHistoryQuery filterByBuyTraderHistoryId($value, $criteria = null)
 * @method TraderHistoryQuery filterByDate($value, $criteria = null)
 * @method TraderHistoryQuery filterByCourse($value, $criteria = null)
 * @method TraderHistoryQuery filterByComissionPercent($value, $criteria = null)
 * @method TraderHistoryQuery filterByAction($value, $criteria = null)
 * @method TraderHistoryQuery filterByType($value, $criteria = null)
  * @method TraderHistoryQuery orderByTraderHistoryId($order = Criteria::ASC)
  * @method TraderHistoryQuery orderByTraderId($order = Criteria::ASC)
  * @method TraderHistoryQuery orderByTraderImitationId($order = Criteria::ASC)
  * @method TraderHistoryQuery orderByBuyTraderHistoryId($order = Criteria::ASC)
  * @method TraderHistoryQuery orderByDate($order = Criteria::ASC)
  * @method TraderHistoryQuery orderByCourse($order = Criteria::ASC)
  * @method TraderHistoryQuery orderByComissionPercent($order = Criteria::ASC)
  * @method TraderHistoryQuery orderByAction($order = Criteria::ASC)
  * @method TraderHistoryQuery orderByType($order = Criteria::ASC)
  * @method TraderHistoryQuery withTrader($params = [])
  * @method TraderHistoryQuery joinWithTrader($params = null, $joinType = 'LEFT JOIN')
  * @method TraderHistoryQuery withBuyTraderHistory($params = [])
  * @method TraderHistoryQuery joinWithBuyTraderHistory($params = null, $joinType = 'LEFT JOIN')
  * @method TraderHistoryQuery withTraderHistories($params = [])
  * @method TraderHistoryQuery joinWithTraderHistories($params = null, $joinType = 'LEFT JOIN')
  * @method TraderHistoryQuery withTraderImitation($params = [])
  * @method TraderHistoryQuery joinWithTraderImitation($params = null, $joinType = 'LEFT JOIN')
 */
class BaseTraderHistoryQuery extends \yii\db\ActiveQuery
{


    use \ActiveGenerator\base\RichActiveMethods;

    /**
     * @inheritdoc
     * @return \backend\models\TraderHistory[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \backend\models\TraderHistory|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @return \backend\models\TraderHistoryQuery     */
    public static function model()
    {
        return new \backend\models\TraderHistoryQuery(\backend\models\TraderHistory::class);
    }
}
