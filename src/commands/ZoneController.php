<?php
namespace backend\commands;

use backend\components\repository\Course;
use backend\components\repository\Zone;
use backend\models\Currency;
use backend\models\CurrencyQuery;
use yii\console\Controller;

class ZoneController extends Controller {

    public function actionFill()
    {
        foreach ($this->_getCurrencies() as $currency) {
            try {
                $this->stdout('Processing '.$currency->code);
                $this->_fillCurrency($currency);
            } catch (\Throwable $e) {
                $this->stdout(' > failed with error: '>$e->getMessage());
            }
        }
    }

    /**
     * @return Currency[]
     */
    private function _getCurrencies()
    {
        return CurrencyQuery::model()
            ->filterByActive(Currency::ACTIVE_YES)
            ->all();
    }

    private function _fillCurrency(Currency $currency)
    {
        $zoneSize = Zone::ZONE_SIZE_SEC;
        $repo = new Zone();
        $courseRepo = new Course();
        $zone = $repo->getLastZone($currency->code);
        if ($zone) {
            $from = $zone->to_date->add(new \DateInterval('PT1S'));
        } else {
            $first = $courseRepo->getFirstCurrencyDate($currency->code);
            $from = new \DateTimeImmutable;
            $from = $from->setTimestamp(ceil($first->getTimestamp()/$zoneSize)*$zoneSize);
        }
        $to = new \DateTimeImmutable();
        $to = $to->setTimestamp(floor($to->getTimestamp()/$zoneSize)*$zoneSize-1);
        $interval =  new \DateInterval('PT'.$zoneSize.'S');
        $period = new \DatePeriod($from, $interval, $to);
        /** @var \DateTime $date */
        foreach ($period as $date) {
            $end =  $date->setTimestamp($date->getTimestamp()+$zoneSize-1);
            $stat = $courseRepo->statistic($currency->code, $date, $end);
            if (!$stat['avg']) {
                continue;
            }
            $entry = new \backend\components\repository\entry\Zone();
            $entry->from_date = $date;
            $entry->to_date = $end;
            $entry->min_course = $stat['min'];
            $entry->max_course = $stat['max'];
            $entry->avg_course = $stat['avg'];
            $entry->from_course = $courseRepo->get($currency->code, $date);
            $entry->to_course = $courseRepo->get($currency->code, $end);
            $repo->save($currency->code, $entry);
        }
    }
}