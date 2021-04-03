<?php

namespace app\widgets;

use Yii;
use yii\helpers\Html;

class DateRangePicker extends \yii\base\Widget
{
    public $id;
    public $name;
    public $value;
    public $format = 'YYYY-MM-DD';
    public $options = [];

    public function run()
    {
        $this->id = '_' . md5(uniqid(rand(), true));

        echo $this->render("//widget/_daterangepicker", [
            'id'      => $this->id,
            'name'    => $this->name,
            'value'   => $this->value,
            'options' => $this->options,
            'format'  => $this->format,
        ]);
    }
}
