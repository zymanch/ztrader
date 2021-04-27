<?php
namespace app\widgets\course_graph;
use backend\components\repository\Course;
use backend\components\repository\Currency;

class CourseCandlestick extends Base {

    public $currency;
    public $borderColor = 'rgba(26, 179, 148, 1.0)';
    public $backgroundColor = 'rgba(26, 179, 148, 0.2)';

    public function getDatasets()
    {
        $repo = new Currency;
        $currency = $repo->getByCode($this->currency);
        return [[

            'label' => 'Курс '.$currency->name,
            'data' => $this->_getData(),
            'yAxisID' => 'price',
            'borderColor' => $this->borderColor,
            'backgroundColor'=> $this->backgroundColor
        ]];
    }

    private function _getData()
    {
        $repo = new Course();
        return $repo->group($this->currency, $this->graph->from, $this->graph->to, $this->graph->getTickInSec());
    }
}