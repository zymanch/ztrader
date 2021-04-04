<?php
namespace backend\components\buyer;


use backend\components\repository\Course;

class Simple extends Base {
    const TYPE = 'simple';

    protected $currency;
    protected $price;

    public function getAvailableConfigs():array
    {
        return [
            'currency' => ['type'=>'currency'],
            'price'    => ['type'=>'decimal','digits'=>2]
        ];
    }

    public function isBuyTime(\DateTimeImmutable $now):bool
    {
        $course = new Course;
        return $course->get($this->currency, $now) <= $this->price;
    }

}
