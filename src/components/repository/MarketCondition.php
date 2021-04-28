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
        $zoneFrom = \DateTimeImmutable::createFromFormat('U', $from->getTimestamp()-100*\backend\components\repository\Zone::ZONE_SIZE_SEC, $from->getTimezone());
        $zoneFrom = $zoneFrom->setTimezone($from->getTimezone());
        $zoneTo = \DateTimeImmutable::createFromFormat('U', $to->getTimestamp()+\backend\components\repository\Zone::ZONE_SIZE_SEC, $to->getTimezone());
        $zoneTo = $zoneTo->setTimezone($to->getTimezone());
        $zones = $zoneRepo->find(
            $currencyCode,
            $zoneFrom,
            $zoneTo
        );
        $pos = 0;
        $lastZoneIsInc = false;
        $lastZoneSize = 1;
        $zoneSize = 1;
        $result = [];
        while ($pos < count($zones)) {
            $currentZones = array_slice($zones, $pos, $zoneSize);
            $changeZonesSize = $this->_getChangeZonesSize($currentZones);
            $fromDate = reset($currentZones)->from_date;
            $toDate = end($currentZones)->to_date;
            if ($toDate->getTimestamp() > $from->getTimestamp()) {
                $result[] = [
                    'from' => $fromDate->getTimestamp() < $from->getTimestamp() ? $from : $fromDate,
                    'to' => $toDate->getTimestamp() > $to->getTimestamp() ? $to : $toDate,
                    'change' => $changeZonesSize,
                    'size' => $zoneSize,
                    'is_full' => count($currentZones) == $zoneSize
                ];
            }
            $oldZoneSize = $zoneSize;
            if ($changeZonesSize > 0) {
                if ($lastZoneIsInc && $zoneSize == $lastZoneSize) {
                    $zoneSize = round(max(1, $zoneSize/2));
                }
                $lastZoneIsInc = true;
            } else {
                if (!$lastZoneIsInc && $zoneSize == $lastZoneSize) {
                    $zoneSize = round(min(8, $zoneSize*2));
                }
                $lastZoneIsInc = false;
            }

            $lastZoneSize = $oldZoneSize;
            $pos+=$zoneSize;
        }
        return $result;
    }


    /**
     * @param \backend\components\repository\entry\Zone[] $zones
     * @return bool
     */
    private function _getChangeZonesSize($zones)
    {
        if (!$zones) {
            return 0;
        }
        $from = reset($zones)->from_course;
        $to = end($zones)->to_course;
        return 100*($to-$from)/$from;
    }
}