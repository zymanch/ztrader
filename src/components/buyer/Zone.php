<?php
namespace backend\components\buyer;


use backend\components\repository\Course;
use backend\components\repository\Currency;

class Zone extends Base {

    const TYPE = 'zone';

    public $range_duration;
    public $min_dispersion_percent;
    public $max_dispersion_percent;
    public $min_deviation_percent;
    public $max_deviation_percent;
    public $diff_percent;

    public function getAvailableConfigs():array
    {
        return [
            'range_duration' => ['type'=>'number'],

            'min_dispersion_percent' => ['type'=>'number','step'=>0.01],
            'max_dispersion_percent' => ['type'=>'number','step'=>0.01],

            'min_deviation_percent' => ['type'=>'number','step'=>0.01],
            'max_deviation_percent' => ['type'=>'number','step'=>0.01],

            'diff_percent' => ['type'=>'number','step'=>0.01],
        ];
    }

    public function attributeLabels()
    {
        return [
            'range_duration' => 'Длительность среднего, сек',

            'min_dispersion_percent' => 'Минимальная дисперсия, %',
            'max_dispersion_percent' => 'Максимальная дисперсия, %',

            'min_deviation_percent' => 'Минимальное расхождение, %',
            'max_deviation_percent' => 'МАксмальное расхождение, %',

            'diff_percent' => 'Порог покупки, %',
        ];
    }

    public function isBuyTime(\DateTimeImmutable $now):bool
    {
        $from = $now->setTimestamp($now->getTimestamp()-$this->range_duration);

        $course = new Course;
        $stats = $course->statistic($this->_currency->code, $from, $now);
        if (!$stats['avg']) {
            // throw new \RuntimeException('Rates not found from period '.$from->format('Y-m-d').' to '.$now->format('Y-m-d'));
            return false;
        }

        $dispersionPercent = $stats['dispersion'];
        if ($this->min_dispersion_percent > $dispersionPercent || $dispersionPercent > $this->max_dispersion_percent) {
            return false;
        }
        $deviationPercent = $stats['deviation'];
        if ($this->min_deviation_percent > $deviationPercent || $deviationPercent > $this->max_deviation_percent) {
            return false;
        }
        $barrier = $stats['avg'] * (1-$this->diff_percent/100);

        if ($course->get($this->_currency->code, $now) > $barrier) {
            return false;
        }

        return true;
    }



}
