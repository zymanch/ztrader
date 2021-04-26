<?php

namespace backend\models\base;
use ActiveGenerator\Criteria;
use backend\models\CurrencyQuery;

/**
 * This is the ActiveQuery class for [[backend\models\Currency]].
 * @method CurrencyQuery filterByCurrencyId($value, $criteria = null)
 * @method CurrencyQuery filterByCode($value, $criteria = null)
 * @method CurrencyQuery filterByName($value, $criteria = null)
 * @method CurrencyQuery filterByPosition($value, $criteria = null)
 * @method CurrencyQuery filterByActive($value, $criteria = null)
  * @method CurrencyQuery orderByCurrencyId($order = Criteria::ASC)
  * @method CurrencyQuery orderByCode($order = Criteria::ASC)
  * @method CurrencyQuery orderByName($order = Criteria::ASC)
  * @method CurrencyQuery orderByPosition($order = Criteria::ASC)
  * @method CurrencyQuery orderByActive($order = Criteria::ASC)
  * @method CurrencyQuery withTraders($params = [])
  * @method CurrencyQuery joinWithTraders($params = null, $joinType = 'LEFT JOIN')
 */
class BaseCurrencyQuery extends \yii\db\ActiveQuery
{


    use \ActiveGenerator\base\RichActiveMethods;

    /**
     * @inheritdoc
     * @return \backend\models\Currency[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \backend\models\Currency|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @return \backend\models\CurrencyQuery     */
    public static function model()
    {
        return new \backend\models\CurrencyQuery(\backend\models\Currency::class);
    }
}
