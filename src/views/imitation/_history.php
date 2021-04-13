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
$fabric = new \backend\components\buyer\Fabric();
$buyer = $fabric->create($model->trader->buyer_id, $model->trader->currency_id, $model->trader->getBuyerOptions());

$from = new DateTimeImmutable($history->date);
$interval = new DateInterval('PT'.(isset($buyer->range_duration) ? $buyer->range_duration : 3600).'S');
$interval->invert = true;
$left = $from->add($interval);

$sellHistory = $history->sellTraderHistory;
if ($sellHistory) {
    $to = new DateTimeImmutable($sellHistory->date);
    $right = $to->add(new DateInterval('PT10M'));
} else {
    $to = new DateTimeImmutable('now');
    $right = clone $to;
}



$course = new \backend\components\repository\Course();
$sellStatistic = $course->statistic($currencyCode, $from, $to);
$buyStatistic = $course->statistic($currencyCode, $left, $from);
$afterStatistic = $course->statistic($currencyCode, $to, $right);


$this->registerJsFile('/js/moment.js');
$this->registerJsFile('/js/plugins/chartJs/Chart.min.js');


$range = $course->find($currencyCode, $left, $right);
$dataMain = [];
$dataMin1  = [];
$dataMax1  = [];
$dataMin2  = [];
$dataMax2  = [];
$dataAvg = [];
$labels = [];
$count = count($range);
$step = max(1,$count/300);
foreach ($range as $index => $value) {
    if ($index%$step === 0) {
        $labels[] = 'new Date("' . $value['date'] . '")';
        $dataMain[] = $value['course'];
        if ($value['date'] < $from->format('Y-m-d H:i:s')) {
            $dataMin1[] = round($buyStatistic['avg'] * 0.99, 2);
            $dataMax1[] = round($buyStatistic['avg'] * 1.01, 2);
            $dataMin2[] = round($buyStatistic['avg'] * 0.98, 2);
            $dataMax2[] = round($buyStatistic['avg'] * 1.02, 2);
            $dataAvg[] = $buyStatistic['avg'];
        } else if ($value['date'] < $to->format('Y-m-d H:i:s')) {
            $dataMin1[] = round($sellStatistic['avg'] * 0.99, 2);
            $dataMax1[] = round($sellStatistic['avg'] * 1.01, 2);
            $dataMin2[] = round($sellStatistic['avg'] * 0.98, 2);
            $dataMax2[] = round($sellStatistic['avg'] * 1.02, 2);
            $dataAvg[] = $sellStatistic['avg'];
        } else {
            $dataMin1[] = round($afterStatistic['avg'] * 0.99, 2);
            $dataMax1[] = round($afterStatistic['avg'] * 1.01, 2);
            $dataMin2[] = round($afterStatistic['avg'] * 0.98, 2);
            $dataMax2[] = round($afterStatistic['avg'] * 1.02, 2);
            $dataAvg[] = $afterStatistic['avg'];
        }
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
            backgroundColor: 'rgba(26, 179, 148, 1.0)',
            data: [{x:new Date('".$from->format('Y-m-d H:i:s')."'),y:".$course->get($currencyCode, $from).",r:6}]
        },
        {
            type: 'bubble',
            label: 'Продажа',
            backgroundColor: 'rgba(26, 179, 148, 1.0)',
            data: [{x:new Date('".$to->format('Y-m-d H:i:s')."'),y:".$course->get($currencyCode, $to).",r:6}]
        },
        {
            label:'Курс ".$model->trader->currency->name."',
            data:[".implode(',',$dataMain)."],
            borderColor: 'rgba(26, 179, 148, 1.0)',
            backgroundColor: 'rgba(26, 179, 148, 0.2)',
            pointRadius	: 2,
            lineTension: 0,
            cubicInterpolationMode: 'linear'
        },
        {
            label:'Средний курс ".$model->trader->currency->name."',
            data:[".implode(',',$dataAvg)."],
            borderColor: 'rgba(255, 189, 0, 1.0)',
            backgroundColor: 'rgba(255, 189, 0, 0.0)',
            pointRadius	: 0,
            borderWidth	: 1,
            lineTension: 0,
            cubicInterpolationMode: 'linear'
        },
        {
            label:'Среднее +1%',
            data:[".implode(',',$dataMax1)."],
            borderColor: 'rgba(255, 241, 189, 1.0)',
            backgroundColor: 'rgba(255, 241, 189, 0.0)',
            pointRadius	: 0,
            borderWidth	: 1,
            lineTension: 0,
            cubicInterpolationMode: 'linear'
        },
        {
            label:'Среднее -1%',
            data:[".implode(',',$dataMin1)."],
            borderColor: 'rgba(255, 241, 189, 1.0)',
            backgroundColor: 'rgba(255, 241, 189, 1.0)',
            pointRadius	: 0,
            borderWidth	: 1,
            fill: '-1',
            lineTension: 0,
            cubicInterpolationMode: 'linear'
        },
        {
            label:'Среднее +2%',
            data:[".implode(',',$dataMax2)."],
            borderColor: 'rgba(255, 230, 136, 1.0)',
            backgroundColor: 'rgba(255, 230, 136, 0.0)',
            pointRadius	: 0,
            borderWidth	: 1,
            lineTension: 0,
            cubicInterpolationMode: 'linear'
        },
        {
            label:'Среднее -2%',
            data:[".implode(',',$dataMin2)."],
            borderColor: 'rgba(255, 230, 136, 1.0)',
            backgroundColor: 'rgba(255, 230, 136, 1.0)',
            pointRadius	: 0,
            borderWidth	: 1,
            fill: '-1',
            lineTension: 0,
            cubicInterpolationMode: 'linear'
        }
    ]
  },
  options: {
    responsive: true,
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
        display: false
      }
    }
  },
};
var myChart = new Chart(ctx, config);
");

?>
<canvas id='course' style="width: 100%;height:400px;"></canvas>
<div class="row">
    <div class="col-xs-8">
        <table class="table table-striped table-bordered">
            <tr>
                <th></th>
                <th style="width: 200px">Покупка</th>
                <th style="width: 200px">Продажа</th>
                <th style="width: 200px">После</th>
            </tr>
            <tr>
                <td>Курс</td>
                <td>$<?=number_format($course->get($currencyCode, $from),2);?></td>
                <td>$<?=number_format($course->get($currencyCode, $to),2);?></td>
                <td>$<?=number_format($course->get($currencyCode, $right),2);?></td>
            </tr>
            <tr>
                <td>Минимум курса</td>
                <td>$<?=number_format($buyStatistic['min'],2);?></td>
                <td>$<?=number_format($sellStatistic['min'],2);?></td>
                <td>$<?=number_format($afterStatistic['min'],2);?></td>
            </tr>
            <tr>
                <td>Максимум курса</td>
                <td>$<?=number_format($buyStatistic['min'],2);?></td>
                <td>$<?=number_format($sellStatistic['min'],2);?></td>
                <td>$<?=number_format($afterStatistic['min'],2);?></td>
            </tr>
            <tr>
                <td>Флуктуация</td>
                <td><?=number_format(100*$buyStatistic['max']/$buyStatistic['min']-100,2);?>%</td>
                <td><?=number_format(100*$sellStatistic['max']/$sellStatistic['min']-100,2);?>%</td>
                <td><?=number_format(100*$afterStatistic['max']/$afterStatistic['min']-100,2);?>%</td>
            </tr>
            <tr>
                <td>Среднее</td>
                <td>$<?=number_format($buyStatistic['avg'],2);?></td>
                <td>$<?=number_format($sellStatistic['avg'],2);?></td>
                <td>$<?=number_format($afterStatistic['avg'],2);?></td>
            </tr>
        </table>
    </div>
    <div class="col-xs-4">
        <table class="table table-striped table-bordered">
            <tr>
                <th>Метрика</th>
                <th>Значение</th>
            </tr>
            <tr>
                <td>Длительность</td>
                <td><?=gmdate('H:i:s', $to->getTimestamp()-$from->getTimestamp());?></td>
            </tr>
            <tr>
                <td>Разница курса</td>
                <td>$<?=number_format($course->get($currencyCode, $to)-$course->get($currencyCode, $from),2);?></td>
            </tr>
            <tr>
                <td>Разница курса</td>
                <td><?=number_format(100*$course->get($currencyCode, $to)/$course->get($currencyCode, $from)-100,2);?>%</td>
            </tr>
        </table>
    </div>
</div>