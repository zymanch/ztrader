<?php
/**
 * Created by PhpStorm.
 * User: Антон
 * Date: 13.07.2018
 * Time: 10:07
 */

namespace app\widgets;

use yii\bootstrap\Html;
use yii\bootstrap\Widget;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\web\View;

class CourseGraph extends Widget
{
    public $type = 'line';
    /** @var \DateTime */
    public $from;
    /** @var \DateTime */
    public $to;
    public $htmlOptions = [];
    /** @var course_graph\Base[] */
    private $_datas = [];

    public function init()
    {
        if ($this->type == 'line') {
            $this->view->registerJsFile('/js/moment.js');
            $this->view->registerJsFile('/js/plugins/chartJs/Chart.min.js');
        } else {
            $this->view->registerJsFile('/js/plugins/chartJs/luxon.js');
            $this->view->registerJsFile('/js/plugins/chartJs/Chart.3.js');
            $this->view->registerJsFile('/js/plugins/chartJs/Chart.adapter.js');
            $this->view->registerJsFile('/js/plugins/chartJs/chart.financial.js');
        }

        if (!is_object($this->from)) {
            $this->from = new \DateTime($this->from);
        }
        if (!is_object($this->to)) {
            $this->to = new \DateTime($this->to);
        }
        $interval = $this->getTickInSec();
        $this->from->setTimestamp(floor($this->from->getTimestamp()/$interval)*$interval);
        $this->to->setTimestamp(ceil($this->to->getTimestamp()/$interval)*$interval-1);
    }

    public function run()
    {
        $this->_registerJs();
        return Html::tag('canvas', '', array_merge(['id'=>$this->getId()], $this->htmlOptions));
    }

    private function _registerJs()
    {

        $this->view->registerJs('
            var config = '.Json::encode($this->_getGraphConfig(), JSON_PRETTY_PRINT).';
            var ctx = document.getElementById("'.$this->getId().'").getContext("2d");
            var myChart = new Chart(ctx, config);
        ', View::POS_END);
    }

    private function _getGraphConfig()
    {
        $config = [
            'type' => $this->type,
            'data' => [
                'labels' => [],
                'datasets' => []
            ],
            'options' => [
                'responsive' => false,
                'scales' => [
                    'xAxes' => [[
                        'type' => 'time',
                        'time' => [
                            'format' => 'HH:MM:SS',
                            'tooltipFormat' => 'll HH:mm',
                            'unit' => 'hour',
                            'unitStepSize' => 1,
                            'displayFormats' => [
                                'day' => 'MM/DD/YYYY',
                                'hour' => 'HH:mm'
                            ]
                        ]
                    ]]
                ],
                'plugins' => [
                    'legend' => [
                        'position' => 'top',
                    ]
                ]
            ],
        ];
        foreach ($this->getDatePeriod() as $date) {
            $config['data']['labels'][] = new JsExpression('new Date("' . $date->format('Y-m-d H:i:s') . '")');
        }
        foreach ($this->_datas as $data) {
            $config['data']['datasets'] = array_merge($config['data']['datasets'], $data->getDatasets());
        }
        return $config;
    }
    public function addData(course_graph\Base $data)
    {
        $this->_datas[] = $data;
    }

    public function getDatePeriod()
    {
        $interval = new \DateInterval('PT'.$this->getTickInSec().'S');
        return new \DatePeriod($this->from, $interval, $this->to);
    }

    public function getTickInSec()
    {
        $diff = $this->to->getTimestamp() - $this->from->getTimestamp();
        switch(true) {
            case $diff < 1200:
                return 1;
            case $diff < 3*3600:
                return 10;
            case $diff < 24*3600:
                return 2*60;
            case $diff < 31*3600:
                return 60*10;
            default:
                return 60*60;
        }
    }


}