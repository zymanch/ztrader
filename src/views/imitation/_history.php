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


?>
<?php $widget = \app\widgets\CourseGraph::begin([

    'from' => $left,
    'to' => $right,
    'htmlOptions' => ['style'=>'width: 100%;height:400px;'],
]);
//$widget->addData(new \app\widgets\course_graph\Bubble($widget,['currency'=>'BTC','date'=>$from,'label'=>'Покупка']));
//$widget->addData(new \app\widgets\course_graph\Bubble($widget,['currency'=>'BTC','date'=>$to,'label'=>'Продажа']));
$widget->addData(new \app\widgets\course_graph\CourseLine($widget,['currency'=>'BTC']));
//$widget->addData(new \app\widgets\course_graph\PercentBar($widget,['currency'=>'BTC','percent'=>1]));
\app\widgets\CourseGraph::end();