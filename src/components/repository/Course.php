<?php
namespace backend\components\repository;

use yii\db\Query;

class Course {

    private static $_cache;

    private function _createTable($tableName)
    {
        if (self::$_cache===null) {
            self::$_cache = \Yii::$app->db->createCommand('show tables like "course_%"')->queryColumn();
        }
        if (!in_array($tableName, self::$_cache)) {
            \Yii::$app->db->createCommand('CREATE TABLE `'.$tableName.'` (
                `course_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `date` TIMESTAMP NOT NULL,
                `course` DECIMAL(16,2) UNSIGNED NOT NULL,
                `volume` SMALLINT(5) UNSIGNED NOT NULL,
                PRIMARY KEY (`course_id`),
                INDEX `date` (`date`)
            )')->execute();
            self::$_cache[] = $tableName;
        }
    }

    public function get($currencyCode, \DateTimeImmutable $date)
    {
        $tableName = $this->_getTableName($currencyCode, $date->format('Y'), $date->format('m'));
        $rate = (new Query)
            ->from($tableName)
            ->where('date<="'.$date->format('Y-m-d H:i:s').'"')
            ->orderBy('date DESC')
            ->limit(1)
            ->one();
        if ($rate) {
            return $rate['course'];
        }
        $interval = new \DateInterval('P1M');
        $interval->invert = true;
        $previous = $date->add($interval);
        $tableName = $this->_getTableName($currencyCode, $previous->format('Y'), $previous->format('m'));
        $rate = (new Query)
            ->from($tableName)
            ->where('date<="'.$date->format('Y-m-d H:i:s').'"')
            ->orderBy('date DESC')
            ->limit(1)
            ->one();

        if (!$rate) {
            throw new \RuntimeException('Missed rate for time');
        }
        return $rate['course'];
    }

    public function find($currencyCode, \DateTimeInterface $from, \DateTimeInterface $to)
    {
        $result = [];
        foreach ($this->_getTableConfigs($currencyCode, $from, $to) as $config) {
            $result[] = (new Query)
                ->from($config['table'])
                ->where('date between "'.$config['from'].'" and "'.$config['to'].'"')
                ->orderBy('date ASC')
                ->all();
        }

        if (!$result) {
            return [];
        }
        if (count($result)==1) {
            return reset($result);
        }
        return array_merge(...$result);
    }

    public function group($currencyCode, \DateTimeInterface $from, \DateTimeInterface $to, $intervalSec)
    {
        $fromTimeZone = $from->getTimezone();
        $toTimeZone = $to->getTimezone();
        $from = \DateTime::createFromFormat('U',floor($from->getTimestamp()/$intervalSec)*$intervalSec, $from->getTimezone());
        $from->setTimezone($fromTimeZone);
        $to = \DateTime::createFromFormat('U',floor($to->getTimestamp()/$intervalSec)*$intervalSec, $to->getTimezone());
        $to->setTimezone($toTimeZone);
        $rows = [];
        \Yii::$app->db->createCommand('SET SESSION group_concat_max_len = 1000000');
        foreach ($this->_getTableConfigs($currencyCode, $from, $to) as $config) {
            $lines = (new Query)
                ->select([
                    'floor(unix_timestamp(date)/'.$intervalSec.')*'.$intervalSec.' as t',
                    'min(course) as min',
                    'max(course) as max',
                    'group_concat(course order by date) as courses'
                ])
                ->from($config['table'])
                ->where('date between "'.$config['from'].'" and "'.$config['to'].'"')
                ->orderBy('date ASC')
                ->groupBy('t')
                ->all();
            foreach ($lines as $line) {
                $courses = explode(',', $line['courses']);
                $rows[$line['t']] = [
                    'x'=>$line['t']*1000,
                    'o' =>(float)reset($courses),
                    'c'=>(float)end($courses),
                    'h'=>(float)$line['max'],
                    'l'=>(float)$line['min'],
                ];
            }
        }
        $result = [];
        $period = new \DatePeriod($from, new \DateInterval('PT'.$intervalSec.'S'), $to);
        $last = reset($rows);
        if (!$last) {
            $last = ['x'=>$from->getTimestamp()*1000,'o'=>0,'c'=>0,'h'=>0,'l'=>0];
        }
        foreach ($period as $date) {
            if (isset($rows[$date->getTimestamp()])) {
                $result[] = $rows[$date->getTimestamp()];
                $last = $rows[$date->getTimestamp()];
            } else {
                $last['x'] = $date->getTimestamp()*1000;
                $result[] = $last;
            }
        }
        return $result;
    }

    public function statistic($currencyCode, \DateTimeInterface $from, \DateTimeInterface $to)
    {
        $min = null;
        $max = null;
        $sum = 0;
        $count = 0;
        foreach ($this->_getTableConfigs($currencyCode, $from, $to) as $config) {
            $stats = (new Query)
                ->select(['count(*) as c','sum(course) as s','min(course) as mn','max(course) as mx'])
                ->from($config['table'])
                ->where('date between "'.$config['from'].'" and "'.$config['to'].'"')
                ->one();
            if (!$stats) {
                continue;
            }
            if ($min === null || $min > $stats['mn']) {
                $min = (float)$stats['mn'];
            }
            if ($max === null || $max < $stats['mx']) {
                $max = (float)$stats['mx'];
            }
            $count+=$stats['c'];
            $sum+=$stats['s'];
        }
        $avg = $count ? $sum / $count : null;
        return [
            'avg' => $avg,
            'min' => $min,
            'max' => $max,
            'dispersion' => $min ? ($max-$min)/$min : null,
            'deviation' => $avg ? max(abs($max-$avg),abs($avg-$min))/$avg : null
        ];
    }

    private function _getTableConfigs($currencyCode, \DateTimeInterface $from, \DateTimeInterface $to)
    {
        $fromYear = $from->format('Y');
        $toYear = $to->format('Y');
        $fromMonth = (int)$from->format('m');
        $toMonth = (int)$to->format('m');

        $fromTime = $from->format('d H:i:s');
        $toTime = $to->format('d H:i:s');


        $result = [];
        for ($year=$fromYear;$year<=$toYear;$year++) {
            for ($month = ($year==$fromYear?$fromMonth:1); $month<=($year==$toYear?$toMonth:12);$month++) {
                $fromDay = $year==$fromYear && $month==$fromMonth ? $fromTime : '01 00:00:00';
                $toDay = $year==$toYear && $month==$toMonth ? $toTime : date('t',strtotime($year.'-'.$month.'-01')).' 23:59:59';
                $tableName = $this->_getTableName($currencyCode, $year, $month);
                $fromDate = sprintf('%04d-%02d-%s', $year, $month, $fromDay);
                $toDate = sprintf('%04d-%02d-%s', $year, $month,$toDay);
                $result[] = ['table'=>$tableName,'from'=>$fromDate,'to'=>$toDate];
            }
        }
        return $result;
    }

    public function save($currencyCode, \DateTimeInterface $date, $course)
    {
        $tableName = $this->_getTableName($currencyCode, $date->format('Y'),$date->format('m'));
//        $exists = (new Query)
//            ->from($tableName)
//            ->where('date="'.$date->format('Y-m-d H:i:s').'"')
//            ->andWhere('course='.round($course, 2))
//            ->count();
//        if ($exists) {
//            return;
//        }
        $db = \Yii::$app->db;
        $db->createCommand()->insert($tableName,['date'=>$date->format('Y-m-d H:i:s'),'course'=>round($course,2)])->execute();
    }

    public function saveMulti($currencyCode, &$rows)
    {
        $firstRow = reset($rows);
        $date = new \DateTime($firstRow['date']);
        $tableName = $this->_getTableName($currencyCode, $date->format('Y'),$date->format('m'));
        $this->_createTable($tableName);
        foreach ($rows as $index => $row) {
            $rows[$index] = sprintf('(null,"%s",%s,%s)', $row['date'],$row['course'], $row['volume']);
        }
        $db = \Yii::$app->db;
        $db->createCommand('insert into '.$tableName.' values '.implode(',',$rows))->execute();
    }

    private function _getTableName($currencyCode, $year, $month)
    {
        return sprintf('course_%s_%s_%02d', strtolower($currencyCode), $year, $month);
    }

}
