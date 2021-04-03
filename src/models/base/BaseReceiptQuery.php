<?php

namespace backend\models\base;
use ActiveGenerator\Criteria;
use backend\models\ReceiptQuery;

/**
 * This is the ActiveQuery class for [[backend\models\Receipt]].
 * @method ReceiptQuery filterByReceiptId($value, $criteria = null)
 * @method ReceiptQuery filterByUserId($value, $criteria = null)
 * @method ReceiptQuery filterByDate($value, $criteria = null)
 * @method ReceiptQuery filterByAmount($value, $criteria = null)
 * @method ReceiptQuery filterByQrCode($value, $criteria = null)
 * @method ReceiptQuery filterByCreated($value, $criteria = null)
  * @method ReceiptQuery orderByReceiptId($order = Criteria::ASC)
  * @method ReceiptQuery orderByUserId($order = Criteria::ASC)
  * @method ReceiptQuery orderByDate($order = Criteria::ASC)
  * @method ReceiptQuery orderByAmount($order = Criteria::ASC)
  * @method ReceiptQuery orderByQrCode($order = Criteria::ASC)
  * @method ReceiptQuery orderByCreated($order = Criteria::ASC)
  * @method ReceiptQuery withUser($params = [])
  * @method ReceiptQuery joinWithUser($params = null, $joinType = 'LEFT JOIN')
  * @method ReceiptQuery withUserReceipts($params = [])
  * @method ReceiptQuery joinWithUserReceipts($params = null, $joinType = 'LEFT JOIN')
 */
class BaseReceiptQuery extends \yii\db\ActiveQuery
{


    use \ActiveGenerator\base\RichActiveMethods;

    /**
     * @inheritdoc
     * @return \backend\models\Receipt[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \backend\models\Receipt|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @return \backend\models\ReceiptQuery     */
    public static function model()
    {
        return new \backend\models\ReceiptQuery(\backend\models\Receipt::class);
    }
}
