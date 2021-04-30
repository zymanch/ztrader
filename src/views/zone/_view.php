<?php
/**
 * @var DateTimeImmutable[][] $zones
 * @var $currency \backend\models\Currency
 */


?>
<?php foreach ($zones as $zone):?>

<?php
    $currencyCode = $currency->code;
    $from = $zone['from'];
    $to = $zone['to'];
    $right = $to->add(new DateInterval('PT3H'));
    $interval = new DateInterval('PT3H');
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
//$widget->addData(new \app\widgets\course_graph\PercentBar($widget,['currency'=>'BTC','percent'=>1,'points'=>[$from, $to]]));
    $widget->addData(new \app\widgets\course_graph\Zones($widget,['currency'=>'BTC']));
    \app\widgets\CourseGraph::end();
?>
<?php endforeach;?>
