<?php
namespace backend\components\buyer;


use backend\components\repository\Course;
use backend\components\repository\Currency;

class Fall extends Base {

    const TYPE = 'fall';

    public $range_duration;
    public $min_dispersion_percent;
    public $max_dispersion_percent;
    public $diff_percent;
    public $inc_range;
    public $inc_percent;

    public function getAvailableConfigs():array
    {
        return [
            'range_duration' => ['type'=>'number'],
            'min_dispersion_percent' => ['type'=>'number','step'=>0.01],
            'max_dispersion_percent' => ['type'=>'number','step'=>0.01],
            'diff_percent' => ['type'=>'number','step'=>0.01,],
            'inc_range' => ['type'=>'number','step'=>0.01],
            'inc_percent' => ['type'=>'number','step'=>0.01],
        ];
    }

    public function attributeLabels()
    {
        return [
            'range_duration' => 'Длительность среднего, сек',
            'min_dispersion_percent' => 'Минимальная дисперсия, %',
            'max_dispersion_percent' => 'Максимальная дисперсия, %',
            'diff_percent' => 'Порог покупки, %',
            'inc_range' => 'Длительность возрастания, сек',
            'inc_percent' => 'Скорость роста, %',
        ];
    }

    public function isBuyTime(\DateTimeImmutable $now):bool
    {
        $course = new Course;
        $from = $now->setTimestamp($now->getTimestamp()-$this->range_duration);

        $stats = $course->statistic($this->_currency->code, $from, $now);
        if (!$stats['avg']) {
            // throw new \RuntimeException('Rates not found from period '.$from->format('Y-m-d').' to '.$now->format('Y-m-d'));
            return false;
        }

        $dispersionPercent = 100* $stats['dispersion'];
        if ($this->min_dispersion_percent > $dispersionPercent || $dispersionPercent > $this->max_dispersion_percent) {
            return false;
        }

        $barrier = $stats['avg'] * (1-$this->diff_percent/100);

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
