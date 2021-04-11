<?php
namespace backend\components\seller;


use backend\components\repository\Course;

class Grow extends Base {
    const TYPE = 'grow';

    public $max_loss_percent;

    public function getAvailableConfigs():array
    {
        return [
            'max_loss_percent' => ['type'=>'number','step'=>0.01],
        ];
    }

    public function attributeLabels()
    {
        return [
            'max_loss_percent' => 'Продать при падении на, %',
        ];
    }

    public function isSellTime(\DateTimeImmutable $buyTime, \DateTimeImmutable $now):bool
    {
        $course = new Course;

        $stats = $course->statistic($this->_currency->code, $buyTime, $now);

        $barrier = $stats['max'] * (1-$this->max_loss_percent/100);
        $currentCourse = $course->get($this->_currency->code, $now);
        if ($currentCourse<$barrier) {
            return true;
        }
        return false;
    }

}
