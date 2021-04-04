<?php

namespace backend\models\base;
use ActiveGenerator\Criteria;
use backend\models\SellerQuery;

/**
 * This is the ActiveQuery class for [[backend\models\Seller]].
 * @method SellerQuery filterBySellerId($value, $criteria = null)
 * @method SellerQuery filterByType($value, $criteria = null)
 * @method SellerQuery filterByName($value, $criteria = null)
  * @method SellerQuery orderBySellerId($order = Criteria::ASC)
  * @method SellerQuery orderByType($order = Criteria::ASC)
  * @method SellerQuery orderByName($order = Criteria::ASC)
  * @method SellerQuery withTraders($params = [])
  * @method SellerQuery joinWithTraders($params = null, $joinType = 'LEFT JOIN')
 */
class BaseSellerQuery extends \yii\db\ActiveQuery
{


    use \ActiveGenerator\base\RichActiveMethods;

    /**
     * @inheritdoc
     * @return \backend\models\Seller[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \backend\models\Seller|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @return \backend\models\SellerQuery     */
    public static function model()
    {
        return new \backend\models\SellerQuery(\backend\models\Seller::class);
    }
}
