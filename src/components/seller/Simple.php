<?php
namespace backend\components\seller;


use backend\components\repository\Course;

class Simple extends Base {
    const TYPE = 'simple';

    protected $currency;
    protected $price;

    public function getAvailableConfigs():array
    {
        return [
            'currency' => ['type'=>'currency'],
            'price'    => ['type'=>'money']
        ];
    }

    public function isSellTime(\DateTimeImmutable $buyTime, \DateTimeImmutable $now):bool {
        $course = new Course;
        return $course->get($this->currency, $now) >= $this->price;
    }

}
