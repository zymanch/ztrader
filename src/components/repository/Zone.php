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
        $trend = $this->_getTrend3($currencyCode, $zone, $lastZone);
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

    // Отношщение положительных и отрицательных тиков
    private function _getTrend($currencyCode, entry\Zone $currentZone, entry\Zone $previousZone) {
        $repo = new Course();
        $tickets = $repo->find(
            $currencyCode,
            $currentZone->from_date,
            $currentZone->to_date
        );
        $last = null;
        $incs = 0;
        $decs = 0;
        foreach ($tickets as $ticket) {
            if ($last !== null) {
                if ($ticket['course'] > $last) {
                    $incs++;
                } else if ($ticket['course'] < $last) {
                    $decs++;
                }
            }
            $last = $ticket['course'];
        }
        return $decs ? 100*$incs/$decs - 100 : 100;
    }

    // отношение среднего в первой половине и второй
    private function _getTrend3($currencyCode, entry\Zone $currentZone, entry\Zone $previousZone) {
        $repo = new Course();
        $ticks = $repo->find(
            $currencyCode,
            $currentZone->from_date,
            $currentZone->to_date
        );
        $courses = array_map(function($tick) {
            return $tick['course'];
        }, $ticks);
        $firstCourses = array_splice($courses, 0,round(count($courses)/2));

        $firstAvg = array_sum($firstCourses)/count($firstCourses);
        $lastAvg = array_sum($courses)/count($courses);
        return 100*$lastAvg/$firstAvg - 100;
    }


    // минимум и максимум сместились в одну сторону
    private function _getTrend2($currencyCode, entry\Zone $currentZone, entry\Zone $previousZone) {
        //return 100*$currentZone->avg_course/$previousZone->avg_course-100;
        $isMinIncreased = $currentZone->min_course > $previousZone->min_course;
        $isMaxIncreased = $currentZone->max_course > $previousZone->max_course;
        if ($isMaxIncreased !== $isMinIncreased) {
            return 0; //100*$currentZone->to_course / $currentZone->from_course - 100;
        }
        // Восходящий тренд
        if ($isMinIncreased) {
            return abs(100 * $currentZone->min_course / $previousZone->min_course - 100);
        }
        // Низходящий тренд
        return -abs(100 * $currentZone->max_course / $previousZone->max_course - 100);
    }


    // недоделаная попытка с экстремумами
    private function _getTrend4($currencyCode, entry\Zone $currentZone, entry\Zone $previousZone) {
        $repo = new Course();
        $tickets = $repo->find(
            $currencyCode,
            $currentZone->from_date,
            $currentZone->to_date
        );
        $extremums = [];
        $lastCourse = reset($tickets)['course'];
        $lastExtremum = reset($tickets)['course'];
        $isIncrease = $tickets[2]['course'] > $lastCourse;
        for ($i = 0; $i<count($tickets); $i+=60) {
            $course = $tickets[$i]['course'];
            if ($isIncrease) {
                if ($course < $lastCourse) {
                    $extremums[] = $lastCourse/$lastExtremum - 1;
                    $lastExtremum = $lastCourse;
                    $isIncrease = false;
                }
            } else {
                if ($course > $lastCourse) {
                    $extremums[] = $lastCourse/$lastExtremum - 1;
                    $lastExtremum = $lastCourse;
                    $isIncrease = true;
                }
            }
            $lastCourse = $course;
        }
        $extremums[] = $lastCourse/$lastExtremum - 1;

        $extremums = $this->_collapseExtremums($extremums);
        //$extremums = array_values($extremums);
        print implode("\n",$extremums);die();
    }

    private function _collapseExtremums($extremums) {
        $isCollapsed = false;

        for ($i=2;$i<count($extremums);$i++) {
            if ((abs($extremums[$i-1]) < 0.5*abs($extremums[$i-2])) && (abs($extremums[$i-1]) < 0.5*abs($extremums[$i]))) {
                $extremums[$i]=(1+$extremums[$i-2])*(1+$extremums[$i-1])*(1+$extremums[$i])-1;
                unset($extremums[$i-1]);
                unset($extremums[$i-2]);
                $isCollapsed = true;
            }
        }
        $extremums=array_values($extremums);
        for ($i=1;$i<count($extremums);$i++) {
            if (($extremums[$i]>0) ===($extremums[$i-1]>0)) {
                $extremums[$i]=(1+$extremums[$i-1])*(1+$extremums[$i])-1;
                unset($extremums[$i-1]);
            }
        }
        $extremums=array_values($extremums);
        return $isCollapsed ? $this->_collapseExtremums($extremums) : $extremums;
    }

    private function _getTableName($currencyCode)
    {
        return sprintf('zone_%s', strtolower($currencyCode));
    }

}
