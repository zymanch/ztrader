<?php
namespace backend\components\buyer;


use backend\components\repository\Course;

class Avg extends Base {

    const TYPE = 'avg';

    protected $currency;
    protected $duration;
    protected $diff_percent;

    public function getAvailableConfigs():array
    {
        return [
            'currency' => ['type'=>'currency'],
            'duration' => ['type'=>'integer'],
            'diff_percent' => ['type'=>'decimal','digits'=>2]
        ];
    }

    public function isBuyTime(\DateTimeImmutable $now):bool
    {
        $course = new Course;
        $from = $now->setTimestamp($now->getTimestamp()-$this->duration);

        $rates = $course->find($this->currency, $from, $now);
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
        $avg = $sum/count($rates);
        $barrier = $avg * (1-$this->diff_percent/100);

        if ($course->get($this->currency, $now) > $barrier) {
            return false;
        }
        $inc = 0;
        $desc = 0;
        $old = null;
        foreach (array_slice($rates,-20) as $rate) {
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
