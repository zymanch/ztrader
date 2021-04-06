<?php
namespace backend\components\seller;


use backend\components\repository\Course;

class Simple extends Base {
    const TYPE = 'simple';

    protected $price;

    public function getAvailableConfigs():array
    {
        return [
            'price'    => ['type'=>'money']
        ];
    }

    public function isSellTime(\DateTimeImmutable $buyTime, \DateTimeImmutable $now):bool {
        $course = new Course;
        return $course->get($this->_currency->code, $now) >= $this->price;
    }

}
