<?php

use app\widgets\InspiniaGrid;
use backend\models\TraderHistory;
use backend\models\TraderImitation;
use yii\bootstrap\Html;

/**
 * @var $model TraderImitation
 */
$money = 100;
$lastBuyDate=null;
$lastSellDate=null;
?>
<div class="project-list">
    <h2>Имитация <?=$model->trader->name;?>
        с <?=date('Y-m-d', strtotime($model->from));?>
        до <?=date('Y-m-d', strtotime($model->to));?></h2>

    <?= InspiniaGrid::widget([
          'dataProvider' => new \yii\data\ActiveDataProvider([
              'query'=>$model->getTraderHistories()->filterByAction(\backend\models\TraderHistory::ACTION_BUY)->orderByDate(),
              'pagination'=>false
          ]),
          'formatter'    => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
          'tableOptions' => [
              'class' => 'table table-striped table-hover table-pointer fixed-table',
          ],
          'rowOptions' => function(TraderHistory $model, $key, $index, $grid) {
              if (!$model->sellTraderHistory) {
                  return [];
              }
              if ($model->sellTraderHistory->course < $model->course) {
                  return ['class'=>'danger'];
              }
              if ($model->sellTraderHistory->course < $model->course * 1.001) {
                  return ['class'=>'warning'];
              }
              if ($model->sellTraderHistory->course > $model->course * 1.01) {
                  return ['class'=>'success'];
              }
              return [];
          },
          'columns'      => [
              [
                  'label'          => 'Дата покупки',
                  'attribute'      => 'date',
                  'headerOptions'=>['style'=>'width:160px'],
                  'contentOptions'=>['style'=>'width:160px;text-align:right;'],
                  'value' => function(TraderHistory $history) use (&$lastBuyDate) {
                      $day = substr($history->date,0,10);
                      if ($day != $lastBuyDate) {
                          $lastBuyDate = $day;
                          return $history->date;
                      }
                      return substr($history->date,11);
                  }
              ],
              [
                  'label'          => 'Дата продажи',
                  'attribute'      => 'sellTraderHistory.date',
                  'headerOptions'=>['style'=>'width:160px'],
                  'contentOptions'=>['style'=>'width:160px;text-align:right;'],
                  'value' => function(TraderHistory $history) use (&$lastSellDate) {
                      if (!$history->sellTraderHistory) {
                          return '';
                      }
                      $date = $history->sellTraderHistory->date;
                      $day = substr($date,0,10);
                      if ($day != $lastSellDate) {
                          $lastSellDate = $day;
                          return $date;
                      }
                      return substr($date,11);
                  }
              ],
              [
                  'label'          => 'Цена покупки',
                  'attribute'      => 'course',
                  'value' => function(TraderHistory $history) {
                      return '$'.number_format($history->course, 2);
                  }
              ],
              [
                  'label'          => 'Цена продажи',
                  'attribute'      => 'sellTraderHistory.course',
                  'value' => function(TraderHistory $history) {
                      if (!$history->sellTraderHistory) {
                          return '';
                      }
                      return '$'.number_format($history->sellTraderHistory->course, 2);
                  }
              ],
              [
                  'label'          => 'Комиссия',
                  'attribute'      => 'comission_percent',
                  'value' => function(TraderHistory $history) {
                      $result = $history->comission_percent;
                      if ($history->sellTraderHistory) {
                          $result+=$history->sellTraderHistory->comission_percent;
                      }
                      return number_format($result, 3).'%';
                  },
                  'headerOptions'=>['style'=>'width:100px'],
                  'contentOptions'=>['style'=>'width:100px'],
              ],
              [
                  'label'          => 'Разница',
                  'attribute'      => 'comission_percent',
                  'value' => function(TraderHistory $history) {
                      if (!$history->sellTraderHistory) {
                          return '';
                      }
                      $buy = $history->course * (1+$history->comission_percent/100);
                      $sell = $history->sellTraderHistory->course * (1-$history->sellTraderHistory->comission_percent/100);

                      return number_format(100*$sell/$buy-100, 3).'%';
                  },
                  'headerOptions'=>['style'=>'width:100px'],
                  'contentOptions'=>['style'=>'width:100px'],
              ],
              [
                  'label'          => 'Итого',
                  'attribute'      => 'comission_percent',
                  'value' => function(TraderHistory $history) use (&$money) {
                      if (!$history->sellTraderHistory) {
                          return '';
                      }
                      $buy = $history->course * (1+$history->comission_percent/100);
                      $sell = $history->sellTraderHistory->course * (1-$history->sellTraderHistory->comission_percent/100);
                      $money*=$sell/$buy;
                      return number_format($money, 3).'%';
                  },
                  'headerOptions'=>['style'=>'width:100px'],
                  'contentOptions'=>['style'=>'width:100px'],
              ],
              [
                  'class' => \app\extensions\yii\grid\ActionColumn::class,
                  'template' => '<div class="btn-group">{view}</div>',
                  'buttons' => [
                        'view' => function ($url, TraderHistory $model, $key){
                            $title = 'History';
                            $options = [
                                'title'      => $title,
                                'aria-label' => $title,
                                'data-pjax'  => '0',
                            ];
                            $url = \yii\helpers\Url::to(['imitation/history','id'=>$model->trader_imitation_id,'history_id'=>$model->trader_history_id]);
                            $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-eye-open"]);
                            return Html::a($icon, $url, $options);
                        }
                    ]
              ]
          ],
    ]);?>
    <div class="">
        <?=Html::a('Назад',['imitation/index'],['class'=>'btn btn-primary']);?>
    </div>

</div>
