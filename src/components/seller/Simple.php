<?php
namespace backend\components\seller;


use backend\components\repository\Course;

class Simple extends Base {
    const TYPE = 'simple';

    public $price;

    public function getAvailableConfigs():array
    {
        return [
            'price'    => ['type'=>'number','step'=>0.01]
        ];
    }

    public function isSellTime(\DateTimeImmutable $buyTime, \DateTimeImmutable $now):bool {
        $course = new Course;
        return $course->get($this->_currency->code, $now) >= $this->price;
    }

}
