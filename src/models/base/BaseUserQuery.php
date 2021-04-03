<?php

namespace backend\models\base;
use ActiveGenerator\Criteria;
use backend\models\UserQuery;

/**
 * This is the ActiveQuery class for [[backend\models\User]].
 * @method UserQuery filterByUserId($value, $criteria = null)
 * @method UserQuery filterByUsername($value, $criteria = null)
 * @method UserQuery filterByRole($value, $criteria = null)
 * @method UserQuery filterByEmail($value, $criteria = null)
 * @method UserQuery filterByPassword($value, $criteria = null)
 * @method UserQuery filterByAuthKey($value, $criteria = null)
 * @method UserQuery filterByCreated($value, $criteria = null)
  * @method UserQuery orderByUserId($order = Criteria::ASC)
  * @method UserQuery orderByUsername($order = Criteria::ASC)
  * @method UserQuery orderByRole($order = Criteria::ASC)
  * @method UserQuery orderByEmail($order = Criteria::ASC)
  * @method UserQuery orderByPassword($order = Criteria::ASC)
  * @method UserQuery orderByAuthKey($order = Criteria::ASC)
  * @method UserQuery orderByCreated($order = Criteria::ASC)
  * @method UserQuery withReceipts($params = [])
  * @method UserQuery joinWithReceipts($params = null, $joinType = 'LEFT JOIN')
  * @method UserQuery withUserReceipts($params = [])
  * @method UserQuery joinWithUserReceipts($params = null, $joinType = 'LEFT JOIN')
 */
class BaseUserQuery extends \yii\db\ActiveQuery
{


    use \ActiveGenerator\base\RichActiveMethods;

    /**
     * @inheritdoc
     * @return \backend\models\User[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \backend\models\User|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @return \backend\models\UserQuery     */
    public static function model()
    {
        return new \backend\models\UserQuery(\backend\models\User::class);
    }
}
