<?php

namespace backend\models\base;
use ActiveGenerator\Criteria;
use backend\models\UserReceiptQuery;

/**
 * This is the ActiveQuery class for [[backend\models\UserReceipt]].
 * @method UserReceiptQuery filterByUserReceiptId($value, $criteria = null)
 * @method UserReceiptQuery filterByUserId($value, $criteria = null)
 * @method UserReceiptQuery filterByReceiptId($value, $criteria = null)
 * @method UserReceiptQuery filterByStatus($value, $criteria = null)
 * @method UserReceiptQuery filterByCreated($value, $criteria = null)
  * @method UserReceiptQuery orderByUserReceiptId($order = Criteria::ASC)
  * @method UserReceiptQuery orderByUserId($order = Criteria::ASC)
  * @method UserReceiptQuery orderByReceiptId($order = Criteria::ASC)
  * @method UserReceiptQuery orderByStatus($order = Criteria::ASC)
  * @method UserReceiptQuery orderByCreated($order = Criteria::ASC)
  * @method UserReceiptQuery withReceipt($params = [])
  * @method UserReceiptQuery joinWithReceipt($params = null, $joinType = 'LEFT JOIN')
  * @method UserReceiptQuery withUser($params = [])
  * @method UserReceiptQuery joinWithUser($params = null, $joinType = 'LEFT JOIN')
 */
class BaseUserReceiptQuery extends \yii\db\ActiveQuery
{


    use \ActiveGenerator\base\RichActiveMethods;

    /**
     * @inheritdoc
     * @return \backend\models\UserReceipt[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \backend\models\UserReceipt|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @return \backend\models\UserReceiptQuery     */
    public static function model()
    {
        return new \backend\models\UserReceiptQuery(\backend\models\UserReceipt::class);
    }
}
