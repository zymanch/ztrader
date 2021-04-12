<?php

use app\widgets\InspiniaGrid;
use backend\models\TraderHistory;
use backend\models\TraderImitation;
use yii\bootstrap\Html;

/**
 * @var $model TraderImitation
 * @var $history TraderHistory
 * @var $this \yii\web\View
 */
$currencyCode = $model->trader->currency->code;
$sellHistory = $history->sellTraderHistory;
if ($sellHistory) {
    $to = new DateTimeImmutable($sellHistory->date);
    $right = $to->add(new DateInterval('PT1H'));
} else {
    $to = new DateTimeImmutable('now');
    $right = clone $to;
}
$fabric = new \backend\components\buyer\Fabric();
$buyer = $fabric->create($model->trader->buyer_id, $model->trader->currency_id, $model->trader->getBuyerOptions());
$from = new DateTimeImmutable($history->date);
$interval = new DateInterval('PT'.(isset($buyer->range_duration) ? $buyer->range_duration : 3600).'S');
$interval->invert = true;
$left = $from->add($interval);

$course = new \backend\components\repository\Course();
$statistic = $course->statistic($currencyCode, $from, $to);


$this->registerJsFile('/js/moment.js');
$this->registerJsFile('/js/plugins/chartJs/Chart.min.js');


$range = $course->find($currencyCode, $left, $right);
$dataMain = [];
$dataMin  = [];
$dataMax  = [];
$labels = [];
$count = count($range);
$step = max(1,$count/100);
foreach ($range as $index => $value) {
    if ($index%$step === 0) {
        $labels[] = 'new Date("' . $value['date'] . '")';
        $dataMain[] = $value['course'];
        $dataMin[] = round($statistic['avg']*0.99,2);
        $dataMax[] = round($statistic['avg']*1.01,2);
    }
}
$this->registerJs("
var ctx = document.getElementById('course').getContext('2d');
var config = {
  type: 'line',
  data: {
    labels: [".implode(',',$labels)."],
    datasets:[
        {
            type: 'bubble',
            label: 'Покупка',
            backgroundColor: 'rgba(151,187,205,1.0)',
            data: [{x:new Date('".$from->format('Y-m-d H:i:s')."'),y:".$course->get($currencyCode, $from).",r:10}]
        },
        {
            type: 'bubble',
            label: 'Продажа',
            backgroundColor: 'rgba(151,187,205,1.0)',
            data: [{x:new Date('".$to->format('Y-m-d H:i:s')."'),y:".$course->get($currencyCode, $to).",r:10}]
        },
        {
            label:'Курс ".$model->trader->currency->name."',
            data:[".implode(',',$dataMain)."],
            borderColor: 'rgba(26, 179, 148, 1.0)',
            backgroundColor: 'rgba(26, 179, 148, 0.2)'
        },
        {
            label:'Среднее +1%',
            data:[".implode(',',$dataMax)."],
            borderColor: 'rgba(255, 241, 189, 1.0)',
            backgroundColor: 'rgba(255, 241, 189, 0.0)',
            pointRadius	: 0,
            borderWidth	: 1
        },
        {
            label:'Среднее -1%',
            data:[".implode(',',$dataMin)."],
            borderColor: 'rgba(255, 241, 189, 1.0)',
            backgroundColor: 'rgba(255, 241, 189, 1.0)',
            pointRadius	: 0,
            borderWidth	: 1,
            fill: '-1'
        }
    ]
  },
  options: {
    responsive: false,
    legend: {
        labels: {
            filter: function(item, chart) {
                // Logic to remove a particular legend item goes here
                return !item.text.includes('Среднее');
            }
        }
    },
    scales: {
        xAxes: [{
            type: 'time',
            time: {
                format: 'HH:MM:SS',
                tooltipFormat: 'll HH:mm',
                unit: 'hour',
                unitStepSize: 1,
                displayFormats: {
                    'day': 'MM/DD/YYYY',
                    'hour': 'HH:mm'
                }
            }
        }]
    },
    plugins: {
      legend: {
        position: 'top',
      },
      title: {
        display: true,
        text: 'Chart.js Line Chart'
      }
    }
  },
};
var myChart = new Chart(ctx, config);
");

?>
<canvas id='course' style="width: 100%;height:400px;"></canvas>
