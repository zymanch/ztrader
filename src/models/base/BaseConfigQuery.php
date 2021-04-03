<?php

namespace backend\models\base;
use ActiveGenerator\Criteria;
use backend\models\ConfigQuery;

/**
 * This is the ActiveQuery class for [[backend\models\Config]].
 * @method ConfigQuery filterByConfigId($value, $criteria = null)
 * @method ConfigQuery filterByWebsiteId($value, $criteria = null)
 * @method ConfigQuery filterByConstant($value, $criteria = null)
 * @method ConfigQuery filterByValue($value, $criteria = null)
 * @method ConfigQuery filterByDescription($value, $criteria = null)
  * @method ConfigQuery orderByConfigId($order = Criteria::ASC)
  * @method ConfigQuery orderByWebsiteId($order = Criteria::ASC)
  * @method ConfigQuery orderByConstant($order = Criteria::ASC)
  * @method ConfigQuery orderByValue($order = Criteria::ASC)
  * @method ConfigQuery orderByDescription($order = Criteria::ASC)
  * @method ConfigQuery withWebsite($params = [])
  * @method ConfigQuery joinWithWebsite($params = null, $joinType = 'LEFT JOIN')
 */
class BaseConfigQuery extends \yii\db\ActiveQuery
{


    use \ActiveGenerator\base\RichActiveMethods;

    /**
     * @inheritdoc
     * @return \backend\models\Config[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \backend\models\Config|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @return \backend\models\ConfigQuery     */
    public static function model()
    {
        return new \backend\models\ConfigQuery(\backend\models\Config::class);
    }
}
