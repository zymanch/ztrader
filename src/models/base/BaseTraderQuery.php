<?php

namespace backend\models\base;
use ActiveGenerator\Criteria;
use backend\models\TraderQuery;

/**
 * This is the ActiveQuery class for [[backend\models\Trader]].
 * @method TraderQuery filterByTraderId($value, $criteria = null)
 * @method TraderQuery filterByName($value, $criteria = null)
 * @method TraderQuery filterByBuyerId($value, $criteria = null)
 * @method TraderQuery filterByBuyerOptions($value, $criteria = null)
 * @method TraderQuery filterBySellerId($value, $criteria = null)
 * @method TraderQuery filterBySellerOptions($value, $criteria = null)
 * @method TraderQuery filterByState($value, $criteria = null)
 * @method TraderQuery filterByStateDate($value, $criteria = null)
 * @method TraderQuery filterByStatus($value, $criteria = null)
  * @method TraderQuery orderByTraderId($order = Criteria::ASC)
  * @method TraderQuery orderByName($order = Criteria::ASC)
  * @method TraderQuery orderByBuyerId($order = Criteria::ASC)
  * @method TraderQuery orderByBuyerOptions($order = Criteria::ASC)
  * @method TraderQuery orderBySellerId($order = Criteria::ASC)
  * @method TraderQuery orderBySellerOptions($order = Criteria::ASC)
  * @method TraderQuery orderByState($order = Criteria::ASC)
  * @method TraderQuery orderByStateDate($order = Criteria::ASC)
  * @method TraderQuery orderByStatus($order = Criteria::ASC)
  * @method TraderQuery withBuyer($params = [])
  * @method TraderQuery joinWithBuyer($params = null, $joinType = 'LEFT JOIN')
  * @method TraderQuery withSeller($params = [])
  * @method TraderQuery joinWithSeller($params = null, $joinType = 'LEFT JOIN')
 */
class BaseTraderQuery extends \yii\db\ActiveQuery
{


    use \ActiveGenerator\base\RichActiveMethods;

    /**
     * @inheritdoc
     * @return \backend\models\Trader[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \backend\models\Trader|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @return \backend\models\TraderQuery     */
    public static function model()
    {
        return new \backend\models\TraderQuery(\backend\models\Trader::class);
    }
}
