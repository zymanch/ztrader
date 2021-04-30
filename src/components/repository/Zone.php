<?php
namespace backend\components\repository;

use yii\db\Query;

class Zone {

    const ZONE_SIZE_SEC = 900;
    private static $_cache;

    private function _createTable($tableName)
    {
        if (self::$_cache===null) {
            self::$_cache = \Yii::$app->db->createCommand('show tables like "zone_%"')->queryColumn();
        }
        if (!in_array($tableName, self::$_cache)) {
            \Yii::$app->db->createCommand('CREATE TABLE `'.$tableName.'` (
                `zone_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `from_date` TIMESTAMP NULL,
                `from_course` DECIMAL(16,2) UNSIGNED NOT NULL,
                `to_date` TIMESTAMP NULL,
                `to_course` DECIMAL(16,2) UNSIGNED NOT NULL,
                `min_course` DECIMAL(16,2) UNSIGNED NOT NULL,
                `max_course` DECIMAL(16,2) UNSIGNED NOT NULL,
                `avg_course` DECIMAL(16,2) UNSIGNED NOT NULL,
                `trend` DECIMAL(6,2) NOT NULL,
                `group_id` INT(10) UNSIGNED NOT NULL,
                `group_pos` TINYINT UNSIGNED NOT NULL,
                `size` TINYINT UNSIGNED NOT NULL,
                PRIMARY KEY (`zone_id`),
                INDEX `dates` (`to_date`,`from_date`)
            )')->execute();
            self::$_cache[] = $tableName;
        }
    }

    public function get($currencyCode, \DateTimeImmutable $date)
    {
        $tableName = $this->_getTableName($currencyCode);
        $rate = (new Query)
            ->from($tableName)
            ->where('"'.$date->format('Y-m-d H:i:s').'" between from_date and to_date')
            ->limit(1)
            ->one();
        if ($rate) {
            return entry\Zone::createFromArray($rate);
        }
        return null;
    }

    /**
     * @param $currencyCode
     * @param \DateTimeInterface $from
     * @param \DateTimeInterface $to
     * @return entry\Zone[]
     */
    public function find($currencyCode, \DateTimeInterface $from, \DateTimeInterface $to)
    {
        $zones = (new Query)
            ->from($this->_getTableName($currencyCode))
            ->where('"'.$from->format('Y-m-d H:i:s').'"<to_date and "'.$to->format('Y-m-d H:i:s').'" >= to_date')
            ->orderBy('to_date ASC')
            ->all();
        $result = [];
        foreach ($zones as $zone) {
            $result[] = entry\Zone::createFromArray($zone);
        }
        return $result;
    }

    public function getLastZone($currencyCode)
    {
        $tableName = $this->_getTableName($currencyCode);
        $this->_createTable($tableName);
        $zone = (new Query)
            ->from($tableName)
            ->orderBy('to_date desc')
            ->limit(1)
            ->one();
        if ($zone) {
            return entry\Zone::createFromArray($zone);
        }
        return null;

    }
    public function save($currencyCode, entry\Zone $zone)
    {
        $tableName = $this->_getTableName($currencyCode);
        $this->_createTable($tableName);
        list($size, $groupId, $groupPos, $trend) = $this->_detectGroup($currencyCode, $zone);
        $db = \Yii::$app->db;
        $db->createCommand()->insert($tableName,[
            'from_date' => $zone->from_date->format('Y-m-d H:i:s'),
            'from_course' => round($zone->from_course,2),
            'to_date' => $zone->to_date->format('Y-m-d H:i:s'),
            'to_course' => round($zone->to_course,2),
            'min_course' => round($zone->min_course,2),
            'max_course' => round($zone->max_course,2),
            'avg_course' => round($zone->avg_course,2),
            'size' => $size,
            'group_id' => $groupId,
            'group_pos' => $groupPos,
            'trend' => $trend,
        ])->execute();
    }

    private function _detectGroup($currencyCode, entry\Zone $zone) {

        $lastZones = $this->find(
            $currencyCode,
            $zone->to_date->modify('-'.(self::ZONE_SIZE_SEC*10).' seconds'),
            $zone->to_date->modify('-'.(self::ZONE_SIZE_SEC*1).' seconds')
        );
        $size = 2;
        $groupId = 1;
        $groupPos = 1;
        $trend = 0;
        $lastZone = end($lastZones);
        if (!$lastZone) {
            return [$size, $groupId, $groupPos, $trend];
        }
        $size = $lastZone->size;
        $groupId = $lastZone->group_id;
        $groupPos = $lastZone->group_pos+1;
        $trend = 100*$zone->avg_course/$lastZone->avg_course-100;
        if ($groupPos <= $size) {
            return [$size, $groupId, $groupPos, $trend];
        }
        $groupId++;
        $groupPos = 1;

        $previousTrends = [];
        $previousSize = 0;
        $lastTrends = [];
        $lastSize = $size;
        foreach ($lastZones as $previousZone) {
            if ($previousZone->group_id == $groupId-2) {
                $previousTrends[] = $previousZone->trend;
                $previousSize = $previousZone->size;
            }
            if ($previousZone->group_id == $groupId-1) {
                $lastTrends[] = $previousZone->trend;
            }
        }
        $previousTrend = array_sum($previousTrends);
        $lastTrend = array_sum($lastTrends);

        if ($previousTrend < 0 && $lastTrend < 0 && $previousSize == $lastSize) {
            $size = min(8, $lastSize*2);
        }
        if ($previousTrend > 0 && $lastTrend > 0 && $previousSize == $lastSize) {
            $size = max(1, round($lastSize/2));
        }
        return [$size, $groupId, $groupPos, $trend];
    }

    private function _getTableName($currencyCode)
    {
        return sprintf('zone_%s', strtolower($currencyCode));
    }

}
