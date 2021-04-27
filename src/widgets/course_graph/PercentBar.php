<?php
namespace app\widgets\course_graph;
use backend\components\repository\Course;
use backend\components\repository\Currency;
use yii\helpers\ArrayHelper;

class PercentBar extends Base {

    public $percent;
    public $currency;
    public $borderColor = 'rgba(255, 241, 189, 1.0)';
    public $backgroundColor = 'rgba(255, 241, 189, 1.0)';
    /** @var \DateTimeInterface[]  */
    public $points = [];

    private $_stats;

    public function getDatasets()
    {

        return [
            [
                'label' => 'Среднее +'.$this->percent.'%',
                'data'  => $this->_getDataMax(),
                'borderColor' => $this->borderColor,
                'backgroundColor' => 'rgba(255, 241, 189, 0.0)',
                'yAxisID' => 'price',
                'pointRadius'	=> 0,
                'borderWidth'	=> 1
            ],
            [
                'label'=>'Среднее -'.$this->percent.'%',
                'data' => $this->_getDataMin(),
                'borderColor' => $this->borderColor,
                'backgroundColor' => $this->backgroundColor,
                'yAxisID' => 'price',
                'pointRadius'	=> 0,
                'borderWidth'	=> 1,
                'fill' => '-1'
            ]
        ];
    }

    private function _getDataMin()
    {
        $interval = new \DateInterval('PT'.$this->graph->getTickInSec().'S');
        $period = new \DatePeriod($this->graph->from, $interval, $this->graph->to);
        $result = [];
        foreach ($period as $date) {
            $result[] = round($this->_getStats($date)*(100-$this->percent)/100);
        }
        return $result;
    }

    private function _getDataMax()
    {
        $interval = new \DateInterval('PT'.$this->graph->getTickInSec().'S');
        $period = new \DatePeriod($this->graph->from, $interval, $this->graph->to);
        $result = [];
        foreach ($period as $date) {
            $result[] = round($this->_getStats($date)*(100+$this->percent)/100);
        }
        return $result;
    }

    private function _getStats(\DateTimeInterface  $date)
    {
        if ($this->_stats === null) {
            $this->_stats = [];
            $repo = new Course();
            $points = array_merge([$this->graph->from], $this->points,[$this->graph->to]);
            foreach ($points as $index => $point) {
                if (!isset($points[$index+1])) {
                    continue;
                }
                $this->_stats[] = [
                    'from' => $point->getTimestamp(),
                    'to' => $points[$index+1]->getTimestamp(),
                    'stats' => $repo->statistic($this->currency, $point, $points[$index+1])
                ];
            }
        }
        foreach ($this->_stats as $point) {
            if ($point['from'] <=$date->getTimestamp() && $date->getTimestamp() <= $point['to']) {
                return $point['stats']['avg'];
            }
        }
        return 0;
    }
}