<?php
namespace backend\components\repository\entry;

class Zone {

    /** @var \DateTimeImmutable */
    public $from_date;
    public $from_course;
    /** @var \DateTimeImmutable */
    public $to_date;
    public $to_course;
    public $min_course;
    public $max_course;
    public $avg_course;

    public static function createFromArray(array $data)
    {
        $result = new self();
        $result->from_date = new \DateTimeImmutable($data['from_date']);
        $result->from_course = $data['from_course'];
        $result->to_date = new \DateTimeImmutable($data['to_date']);
        $result->to_course = $data['to_course'];
        $result->min_course = $data['min_course'];
        $result->max_course = $data['max_course'];
        $result->avg_course = $data['avg_course'];
        return $result;
    }
}