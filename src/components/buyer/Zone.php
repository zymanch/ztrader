<?php
namespace backend\components\buyer;


use backend\components\repository\Course;
use backend\components\repository\Currency;
use backend\components\repository\MarketCondition;

class Zone extends Base {

    const TYPE = 'zone';

    const BUY_TRIGGER_BIGGER_PRICE = 'bigger';
    const BUY_TRIGGER_LESS_PRICE = 'less';

    public $range_duration;
    public $buy_trigger;
    public $diff_percent;
    public $dispersion_min;
    public $dispersion_max;

    public function getAvailableConfigs():array
    {
        return [
            'range_duration' => ['type'=>'number'],
            'buy_trigger'           => ['type'=>'select','values'=>[self::BUY_TRIGGER_BIGGER_PRICE=>'Покупать при цене ниже',self::BUY_TRIGGER_LESS_PRICE=>'Покупать при цене выше']],
            'diff_percent'          => ['type'=>'number','step'=>0.01,'min'=>-100,'max'=>100],
            'dispersion_min'          => ['type'=>'number','step'=>0.01,'min'=>0,'max'=>100],
            'dispersion_max'          => ['type'=>'number','step'=>0.01,'min'=>0,'max'=>100],
        ];
    }

    public function attributeLabels()
    {
        return [
            'range_duration' => 'Длительность среднего, сек',
            'buy_trigger' => 'Когда покупать',
            'diff_percent' => 'Порог покупки, %',
            'dispersion_min' => 'Размах от, %',
            'dispersion_max' => 'Размах до, %',
        ];
    }

    public function isBuyTime(\DateTimeImmutable $now):bool
    {
        $zoneRepo = new \backend\components\repository\Zone();
        $zone = $zoneRepo->get($this->_currency->code, $now->setTimestamp($now->getTimestamp()-\backend\components\repository\Zone::ZONE_SIZE_SEC));
        if (!$this->_isIncZones([$zone])) {
            return false;
        }

        $condition = new MarketCondition;
        $zones = $condition->getZones(
            $this->_currency->code,
            $now->setTimestamp($now->getTimestamp()-2*\backend\components\repository\Zone::ZONE_SIZE_SEC),
            $now->setTimestamp($now->getTimestamp())
        );
        $lastZone = end($zones);
        $previousZone = count($zones) >1 ? $zones[count($zones)-2]: null;
        if (!$previousZone || $previousZone['change']<0 || $lastZone['size'] > 1 || $lastZone['change'] < 0) {
            return false;
        }
        $from = $now->setTimestamp($now->getTimestamp()-$this->range_duration);

        $course = new Course;
        $stats = $course->statistic($this->_currency->code, $from, $now);
        if (!$stats['avg']) {
            // throw new \RuntimeException('Rates not found from period '.$from->format('Y-m-d').' to '.$now->format('Y-m-d'));
            return false;
        }
        if ($this->dispersion_min > 100*$stats['dispersion'] || $this->dispersion_max < 100*$stats['dispersion']) {
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

    /**
     * @param \backend\components\repository\entry\Zone[] $zones
     * @return bool
     */
    private function _isIncZones($zones)
    {
        if (!$zones) {
            return false;
        }
        return reset($zones)->from_course < end($zones)->to_course;
    }



}
