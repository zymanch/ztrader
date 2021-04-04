<?php
namespace backend\components\seller;


abstract class Base {

    public function __construct(array $options)
    {
        foreach ($options as $key => $value) {
            $this->$key = $value;
        }
    }

    abstract public function getAvailableConfigs():array;

    abstract public function isSellTime(\DateTimeImmutable $buyTime, \DateTimeImmutable $now):bool;

}
