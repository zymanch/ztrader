<?php
namespace backend\components\buyer;


use backend\components\repository\Course;
use backend\components\repository\Currency;

class Fall extends Base {

    const TYPE = 'fall';

    public $range_duration;
    public $min_range_percent;
    public $max_range_percent;
    public $diff_percent;
    public $inc_range;
    public $inc_percent;

    public function getAvailableConfigs():array
    {
        return [
            'range_duration' => ['type'=>'number'],
            'min_range_percent' => ['type'=>'number','step'=>0.01],
            'max_range_percent' => ['type'=>'number','step'=>0.01],
            'diff_percent' => ['type'=>'number','step'=>0.01],
            'inc_range' => ['type'=>'number','step'=>0.01],
            'inc_percent' => ['type'=>'number','step'=>0.01],
        ];
    }

    public function isBuyTime(\DateTimeImmutable $now):bool
    {
        $course = new Course;
        $from = $now->setTimestamp($now->getTimestamp()-$this->range_duration);

        $rates = $course->find($this->_currency->code, $from, $now);
        if (!$rates) {
            // throw new \RuntimeException('Rates not found from period '.$from->format('Y-m-d').' to '.$now->format('Y-m-d'));
            return false;
        }

        $s2 = microtime(1);
        $min = null;
        $max = null;
        $sum = 0;
        foreach ($rates as $rate) {
            if ($min === null || $min > $rate['course']) {
                $min = $rate['course'];
            }
            if ($max === null || $max < $rate['course']) {
                $max = $rate['course'];
            }
            $sum+=$rate['course'];
        }

        $rangePercent = 100*($max/$min-1);
        if ($this->min_range_percent > $rangePercent || $rangePercent > $this->max_range_percent) {
            return false;
        }

        $avg = $sum/count($rates);
        $barrier = $avg * (1-$this->diff_percent/100);

        if ($course->get($this->_currency->code, $now) > $barrier) {
            return false;
        }

        $course = new Course;
        $from = $now->setTimestamp($now->getTimestamp()-$this->inc_range);
        if ($course->get($this->_currency->code, $now) > $course->get($this->_currency->code, $from)*(1+$this->inc_percent/100)) {
            return true;
        }
        return false;
    }



}
