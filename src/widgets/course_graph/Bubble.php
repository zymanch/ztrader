<?php
namespace app\widgets\course_graph;
use backend\components\repository\Course;
use backend\components\repository\Currency;
use yii\web\JsExpression;

class Bubble extends Base {

    public $label;
    public $currency;
    public $date;
    public $borderColor = 'rgba(151,187,205,1.0)';
    public $backgroundColor = 'rgba(151,187,205,1.0)';

    public function getDatasets()
    {
        $repo = new Course;
        $course = $repo->get($this->currency, $this->date);
        return [[
            'type'=> 'bubble',
            'label' => $this->label,
            'data' => [['x' => new JsExpression('new Date("'.$this->date->format('Y-m-d H:i:s').'")'),'y'=>$course,'r' => 10]],
            'yAxisID' => 'price',
            'borderColor' => $this->borderColor,
            'backgroundColor'=> $this->backgroundColor
        ]];
    }

}