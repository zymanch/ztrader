<?php

namespace backend\models\base;
use ActiveGenerator\Criteria;
use backend\models\BuyerQuery;

/**
 * This is the ActiveQuery class for [[backend\models\Buyer]].
 * @method BuyerQuery filterByBuyerId($value, $criteria = null)
 * @method BuyerQuery filterByType($value, $criteria = null)
 * @method BuyerQuery filterByName($value, $criteria = null)
  * @method BuyerQuery orderByBuyerId($order = Criteria::ASC)
  * @method BuyerQuery orderByType($order = Criteria::ASC)
  * @method BuyerQuery orderByName($order = Criteria::ASC)
  * @method BuyerQuery withTraders($params = [])
  * @method BuyerQuery joinWithTraders($params = null, $joinType = 'LEFT JOIN')
 */
class BaseBuyerQuery extends \yii\db\ActiveQuery
{


    use \ActiveGenerator\base\RichActiveMethods;

    /**
     * @inheritdoc
     * @return \backend\models\Buyer[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \backend\models\Buyer|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @return \backend\models\BuyerQuery     */
    public static function model()
    {
        return new \backend\models\BuyerQuery(\backend\models\Buyer::class);
    }
}
