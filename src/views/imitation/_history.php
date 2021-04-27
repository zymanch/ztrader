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
$from = new DateTimeImmutable($history->date);
$sellHistory = $history->sellTraderHistory;
if ($sellHistory) {
    $to = new DateTimeImmutable($sellHistory->date);
    $diff = $to->getTimestamp() - $from->getTimestamp();
    $right = $to->add(new DateInterval('PT'.max(1800, round($diff/2)).'S'));
} else {
    $to = new DateTimeImmutable('now');
    $right = clone $to;
}
$fabric = new \backend\components\buyer\Fabric();
$buyer = $fabric->create($model->trader->buyer_id, $model->trader->currency_id, $model->trader->getBuyerOptions());
$interval = new DateInterval('PT'.max(3600, round(($to->getTimestamp() - $from->getTimestamp())/2)).'S');
$interval->invert = true;
$left = $from->add($interval);

?>
<?php $widget = \app\widgets\CourseGraph::begin([
    //'type' => 'candlestick',
    'from' => $left,
    'to' => $right,
    'htmlOptions' => ['style'=>'width: 100%;height:400px;'],
]);
$widget->addData(new \app\widgets\course_graph\Bubble($widget,['currency'=>'BTC','date'=>$from,'label'=>'Покупка']));
$widget->addData(new \app\widgets\course_graph\Bubble($widget,['currency'=>'BTC','date'=>$to,'label'=>'Продажа']));
$widget->addData(new \app\widgets\course_graph\CourseLine($widget,['currency'=>'BTC']));
$widget->addData(new \app\widgets\course_graph\PercentBar($widget,['currency'=>'BTC','percent'=>1,'points'=>[$from, $to]]));
$widget->addData(new \app\widgets\course_graph\Zones($widget,['currency'=>'BTC']));
\app\widgets\CourseGraph::end();