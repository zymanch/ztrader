<?php
namespace backend\components\repository;

use backend\models\base\BaseCurrencyPeer;
use backend\models\CurrencyQuery;
use yii\db\Query;

class Currency {

    /** @var null|\backend\models\Currency[] */
    private static $_cache;


    public function getByCode($currencyCode)
    {
        $this->_preload();
        foreach (self::$_cache as $currency) {
            if ($currency->code == $currencyCode) {
                return $currency;
            }
        }
        throw new \InvalidArgumentException('Валюта не найдена');
    }

    public function getById($currencyId)
    {
        $this->_preload();
        if (!isset(self::$_cache[$currencyId])) {
            throw new \InvalidArgumentException('Валюта не найдена');
        }
        return self::$_cache[$currencyId];
    }

    public function getAll()
    {
        $this->_preload();
        return self::$_cache;
    }
    private function _preload()
    {
        if (self::$_cache === null) {
            self::$_cache = CurrencyQuery::model()->orderByPosition()->indexBy(BaseCurrencyPeer::CURRENCY_ID)->all();
        }
    }

}
