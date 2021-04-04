<?php
namespace backend\components\seller;


use backend\components\repository\Course;

class Avg extends Base {
    const TYPE = 'avg';

    protected $currency;
    protected $diff_percent;
    protected $max_loss_percent;

    public function getAvailableConfigs():array
    {
        return [
            'currency' => ['type'=>'currency'],
            'diff_percent' => ['type'=>'decimal','digits'=>2],
            'max_loss_percent' => ['type'=>'decimal','digits'=>2],
        ];
    }

    public function isSellTime(\DateTimeImmutable $buyTime, \DateTimeImmutable $now):bool
    {
        $course = new Course;
        $buyCourse     = $course->get($this->currency, $buyTime);
        $currentCourse = $course->get($this->currency, $now);

        $barrier = $buyCourse * (1+$this->diff_percent/100);
        if ($currentCourse>=$barrier) {
            return true;
        }
        $barrier = $buyCourse * (1-$this->max_loss_percent/100);

        if ($currentCourse<=$barrier) {
            return true;
        }
        return false;
    }

}
