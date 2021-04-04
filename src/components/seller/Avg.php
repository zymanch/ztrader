<?php
namespace backend\components\seller;


use backend\components\repository\Course;

class Avg extends Base {
    const TYPE = 'avg';

    protected $currency;
    protected $duration;
    protected $diff_percent;
    protected $max_loss_percent;

    public function getAvailableConfigs():array
    {
        return [
            'currency' => ['type'=>'currency'],
            'duration' => ['type'=>'integer'],
            'diff_percent' => ['type'=>'decimal','digits'=>2],
            'max_loss_percent' => ['type'=>'decimal','digits'=>2],
        ];
    }

    public function isSellTime(\DateTimeImmutable $buyTime, \DateTimeImmutable $now):bool
    {
        $course = new Course;
        $from = $now->setTimestamp($now->getTimestamp()-$this->duration);
        $rates = $course->find($this->currency, $from, $now);
        if (!$rates) {
            throw new \RuntimeException('Rates not found');
        }
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
        $barrier = $avg * (1+$this->diff_percent/100);

        $currentCourse =$course->get($this->currency, $now);
        if ($currentCourse>=$barrier) {
            return true;
        }
        $barrier = $course->get($this->currency, $buyTime) * (1-$this->max_loss_percent/100);

        if ($currentCourse<=$barrier) {
            return true;
        }
        return false;
    }

}
