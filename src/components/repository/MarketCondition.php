<?php
namespace backend\components\repository;


class MarketCondition {


    /**
     * @param $currencyCode
     * @param \DateTimeInterface $from
     * @param \DateTimeInterface $to
     * @return array
     */
    public function getZones($currencyCode, \DateTimeInterface $from, \DateTimeInterface  $to)
    {
        $zoneRepo = new \backend\components\repository\Zone();
        $zoneFrom = \DateTimeImmutable::createFromFormat('U', $from->getTimestamp()-\backend\components\repository\Zone::ZONE_SIZE_SEC, $from->getTimezone());
        $zoneFrom = $zoneFrom->setTimezone($from->getTimezone());
        $zoneTo = \DateTimeImmutable::createFromFormat('U', $to->getTimestamp()+\backend\components\repository\Zone::ZONE_SIZE_SEC, $to->getTimezone());
        $zoneTo = $zoneTo->setTimezone($to->getTimezone());
        $zones = $zoneRepo->find(
            $currencyCode,
            $zoneFrom,
            $zoneTo
        );
        $result = [];
        foreach ($zones as $zone) {
            if (!isset($groups[$zone->group_id])) {
                $result[$zone->group_id] = [
                    'from' => $zone->from_date,
                    'to' => $zone->to_date,
                    'change' => $zone->trend,
                    'size' => $zone->size,
                ];
            }
            $result[$zone->group_id]['to'] = $zone->to_date;
            $result[$zone->group_id]['change']+= $zone->trend;
        }

        foreach ($result as $index => $zone) {
            if ($zone['to']->getTimestamp() > $to->getTimestamp() ) {
                $result[$index]['to'] = clone $to;
            }
            if ($zone['from']->getTimestamp() < $from->getTimestamp() ) {
                $result[$index]['from'] = clone $from;
            }
        }
        return array_values($result);
    }

}