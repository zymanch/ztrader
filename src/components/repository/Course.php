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
        $fromYear = $from->format('Y');
        $toYear = $to->format('Y');
        $fromMonth = (int)$from->format('m');
        $toMonth = (int)$to->format('m');
        $result = [];
        $fromTime = $from->format('d H:i:s');
        $toTime = $to->format('d H:i:s');


        for ($year=$fromYear;$year<=$toYear;$year++) {
            for ($month = ($year==$fromYear?$fromMonth:1); $month<=($year==$toYear?$toMonth:12);$month++) {
                $fromDay = $year==$fromYear && $month==$fromMonth ? $fromTime : '01 00:00:00';
                $toDay = $year==$toYear && $month==$toMonth ? $toTime : date('t',strtotime($year.'-'.$month.'-01')).' 23:59:59';
                $tableName = $this->_getTableName($currencyCode, $year, $month);
                $fromDate = sprintf('%04d-%02d-%s', $year, $month, $fromDay);
                $toDate = sprintf('%04d-%02d-%s', $year, $month,$toDay);
                $result[] = (new Query)
                    ->from($tableName)
                    ->where('date between "'.$fromDate.'" and "'.$toDate.'"')
                    ->orderBy('date ASC')
                    ->all();
            }
        }

        if (!$result) {
            return [];
        }
        if (count($result)==1) {
            return reset($result);
        }
        return array_merge(...$result);
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
