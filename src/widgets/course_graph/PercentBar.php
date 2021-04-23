<?php
namespace app\widgets\course_graph;
use backend\components\repository\Course;
use backend\components\repository\Currency;
use yii\helpers\ArrayHelper;

class PercentBar extends Base {

    public $percent;
    public $currency;
    public $borderColor = 'rgba(255, 241, 189, 1.0)';
    public $backgroundColor = 'rgba(255, 241, 189, 0.0)';

    public function getDatasets()
    {
        return [
            [
                'label' => 'Среднее +'.$this->percent.'%',
                'data'  => $this->_getDataMin(),
                'borderColor' => $this->borderColor,
                'backgroundColor' => $this->backgroundColor,
                'pointRadius'	=> 0,
                'borderWidth'	=> 1
            ],
            [
                'label'=>'Среднее -'.$this->percent.'%',
                'data' => $this->_getDataMax(),
                'borderColor' => $this->borderColor,
                'backgroundColor' => $this->backgroundColor,
                'pointRadius'	=> 0,
                'borderWidth'	=> 1,
                'fill' => '-1'
            ]
        ];
    }

    private function _getDataMin()
    {
        $repo = new Course();
        $data = $repo->group($this->currency, $this->graph->from, $this->graph->to, $this->graph->getTickInSec());
        return ArrayHelper::getColumn($data, 'l');
    }

    private function _getDataMax()
    {
        $repo = new Course();
        $data = $repo->group($this->currency, $this->graph->from, $this->graph->to, $this->graph->getTickInSec());
        return ArrayHelper::getColumn($data, 'h');
    }
}