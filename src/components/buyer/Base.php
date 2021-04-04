<?php
namespace backend\components\buyer;


abstract class Base {

    public function __construct(array $options)
    {
        foreach ($options as $key => $value) {
            $this->$key = $value;
        }
    }

    abstract public function getAvailableConfigs():array;

    abstract public function isBuyTime(\DateTimeImmutable $now):bool;

}
