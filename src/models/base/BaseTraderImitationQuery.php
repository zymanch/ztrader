<?php

namespace backend\models\base;
use ActiveGenerator\Criteria;
use backend\models\TraderImitationQuery;

/**
 * This is the ActiveQuery class for [[backend\models\TraderImitation]].
 * @method TraderImitationQuery filterByTraderImitationId($value, $criteria = null)
 * @method TraderImitationQuery filterByTraderId($value, $criteria = null)
 * @method TraderImitationQuery filterByFrom($value, $criteria = null)
 * @method TraderImitationQuery filterByTo($value, $criteria = null)
 * @method TraderImitationQuery filterByTickSize($value, $criteria = null)
 * @method TraderImitationQuery filterByStatus($value, $criteria = null)
 * @method TraderImitationQuery filterByProgress($value, $criteria = null)
  * @method TraderImitationQuery orderByTraderImitationId($order = Criteria::ASC)
  * @method TraderImitationQuery orderByTraderId($order = Criteria::ASC)
  * @method TraderImitationQuery orderByFrom($order = Criteria::ASC)
  * @method TraderImitationQuery orderByTo($order = Criteria::ASC)
  * @method TraderImitationQuery orderByTickSize($order = Criteria::ASC)
  * @method TraderImitationQuery orderByStatus($order = Criteria::ASC)
  * @method TraderImitationQuery orderByProgress($order = Criteria::ASC)
  * @method TraderImitationQuery withTraderHistories($params = [])
  * @method TraderImitationQuery joinWithTraderHistories($params = null, $joinType = 'LEFT JOIN')
  * @method TraderImitationQuery withTrader($params = [])
  * @method TraderImitationQuery joinWithTrader($params = null, $joinType = 'LEFT JOIN')
 */
class BaseTraderImitationQuery extends \yii\db\ActiveQuery
{


    use \ActiveGenerator\base\RichActiveMethods;

    /**
     * @inheritdoc
     * @return \backend\models\TraderImitation[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \backend\models\TraderImitation|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @return \backend\models\TraderImitationQuery     */
    public static function model()
    {
        return new \backend\models\TraderImitationQuery(\backend\models\TraderImitation::class);
    }
}
