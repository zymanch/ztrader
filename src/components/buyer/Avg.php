<?php
namespace backend\components\buyer;


use backend\components\repository\Course;
use backend\components\repository\Currency;

class Avg extends Base {

    const TYPE = 'avg';

    public $duration;
    public $diff_percent;
    public $inc_duration;

    public function getAvailableConfigs():array
    {
        return [
            'duration' => ['type'=>'number'],
            'diff_percent' => ['type'=>'number','step'=>0.01],
            'inc_duration' => ['type'=>'number'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'duration'=>'Длительность среднего, сек',
            'diff_percent' => 'Порог покупки, %',
            'inc_duration' => 'Длительность роста, сек',
        ];
    }

    public function isBuyTime(\DateTimeImmutable $now):bool
    {
        $course = new Course;
        $from = $now->setTimestamp($now->getTimestamp()-$this->duration);

        $stats = $course->statistic($this->_currency->code, $from, $now);
        if (!$stats['avg']) {
            // throw new \RuntimeException('Rates not found from period '.$from->format('Y-m-d').' to '.$now->format('Y-m-d'));
            return false;
        }

        $barrier = $stats['avg'] * (1-$this->diff_percent/100);

        if ($course->get($this->_currency->code, $now) > $barrier) {
            return false;
        }
        $inc = 0;
        $desc = 0;
        $old = null;

        $from = $now->setTimestamp($now->getTimestamp()-$this->inc_duration);
        $rates = $course->find($this->_currency->code, $from, $now);
        foreach ($rates as $rate) {
            if ($old===null) {

            } else if ($rate['course'] > $old) {
                $inc++;
            }else if ($rate['course'] < $old) {
                $desc++;
            }
            $old = $rate['course'];
        }
        return $inc/2 > $desc/2;
    }

}
