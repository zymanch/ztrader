<?php
namespace backend\components\buyer;


use backend\components\repository\Course;
use backend\components\repository\Currency;

class Zone extends Base {

    const TYPE = 'zone';

    const BUY_TRIGGER_BIGGER_PRICE = 'bigger';
    const BUY_TRIGGER_LESS_PRICE = 'less';

    public $range_duration;
    public $min_dispersion_percent;
    public $max_dispersion_percent;
    public $min_deviation_percent;
    public $max_deviation_percent;
    public $buy_trigger;
    public $diff_percent;

    public function getAvailableConfigs():array
    {
        return [
            'range_duration' => ['type'=>'number'],

            'min_dispersion_percent' => ['type'=>'number','step'=>0.01],
            'max_dispersion_percent' => ['type'=>'number','step'=>0.01],

            'min_deviation_percent' => ['type'=>'number','step'=>0.01],
            'max_deviation_percent' => ['type'=>'number','step'=>0.01],

            'buy_trigger'           => ['type'=>'select','values'=>[self::BUY_TRIGGER_BIGGER_PRICE=>'Покупать при цене выше',self::BUY_TRIGGER_LESS_PRICE=>'Покупать при цене ниже']],
            'diff_percent'          => ['type'=>'number','step'=>0.01,'min'=>-100,'max'=>100],
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

            'buy_trigger' => 'Когда покупать',
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

        $dispersionPercent = 100*$stats['dispersion'];
        if ($this->min_dispersion_percent > $dispersionPercent || $dispersionPercent > $this->max_dispersion_percent) {
            return false;
        }
        $deviationPercent = 100*$stats['deviation'];
        if ($this->min_deviation_percent > $deviationPercent || $deviationPercent > $this->max_deviation_percent) {
            return false;
        }

        $interval = new \DateInterval('PT4M');
        $interval->invert = true;
        $from2 = $now->add($interval);
        $lastStat = $course->statistic($this->_currency->code, $from2, $now);

        if ($lastStat['max']*0.999 > $course->get($this->_currency->code, $now)) {
            return false;
        }

        $barrier = $stats['avg'] * (1+$this->diff_percent/100);

        if ($this->buy_trigger == self::BUY_TRIGGER_LESS_PRICE) {
            if ($course->get($this->_currency->code, $now) <= $barrier) {
                return true;
            }
        } else {
            if ($course->get($this->_currency->code, $now) > $barrier) {
                return true;
            }
        }


        return false;
    }



}
