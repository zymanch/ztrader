<?php
namespace backend\components\seller;


use backend\models\Currency;

abstract class Base {


    /**
     * @var Currency
     */
    protected $_currency;

    public function __construct(Currency $currency, array $options)
    {
        $this->_currency = $currency;
        foreach ($options as $key => $value) {
            $this->$key = $value;
        }
    }

    abstract public function getAvailableConfigs():array;

    abstract public function isSellTime(\DateTimeImmutable $buyTime, \DateTimeImmutable $now):bool;

}
