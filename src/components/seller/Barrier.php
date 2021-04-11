<?php
namespace backend\components\seller;


use backend\components\repository\Course;

class Barrier extends Base {
    const TYPE = 'barrier';

    public $diff_percent;
    public $max_loss_percent;

    public function getAvailableConfigs():array
    {
        return [
            'diff_percent' => ['type'=>'number','step'=>0.01],
            'max_loss_percent' => ['type'=>'number','step'=>0.01],
        ];
    }

    public function attributeLabels()
    {
        return [
            'diff_percent' => 'Продавать при росте, %',
            'max_loss_percent' => 'Максимальный слив, %',
        ];

    }

    public function isSellTime(\DateTimeImmutable $buyTime, \DateTimeImmutable $now):bool
    {
        $course = new Course;
        $buyCourse     = $course->get($this->_currency->code, $buyTime);
        $currentCourse = $course->get($this->_currency->code, $now);

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
