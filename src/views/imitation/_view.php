<?php

use app\widgets\InspiniaGrid;
use backend\models\TraderHistory;
use backend\models\TraderImitation;
use yii\bootstrap\Html;

/**
 * @var $model TraderImitation
 */
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
                  'headerOptions'=>['style'=>'width:200px'],
                  'contentOptions'=>['style'=>'width:200px'],
              ],
              [
                  'label'          => 'Дата продажи',
                  'attribute'      => 'sellTraderHistory.date',
                  'headerOptions'=>['style'=>'width:200px'],
                  'contentOptions'=>['style'=>'width:200px'],
              ],
              [
                  'label'          => 'Цена покупки',
                  'attribute'      => 'course',
                  'value' => function(TraderHistory $history) {
                      return '$'.number_format($history->course, 2);
                  },
                  'headerOptions'=>['style'=>'width:200px'],
                  'contentOptions'=>['style'=>'width:200px'],
              ],
              [
                  'label'          => 'Цена продажи',
                  'attribute'      => 'sellTraderHistory.course',
                  'value' => function(TraderHistory $history) {
                      if (!$history->sellTraderHistory) {
                          return '';
                      }
                      return '$'.number_format($history->sellTraderHistory->course, 2);
                  },
                  'headerOptions'=>['style'=>'width:200px'],
                  'contentOptions'=>['style'=>'width:200px'],
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
                  'headerOptions'=>['style'=>'width:200px'],
                  'contentOptions'=>['style'=>'width:200px'],
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

                      return number_format(100*$sell/$buy, 3).'%';
                  },
                  'headerOptions'=>['style'=>'width:200px'],
                  'contentOptions'=>['style'=>'width:200px'],
              ]
          ],
    ]);?>
    <div class="">
        <?=Html::a('Назад',['imitation/index'],['class'=>'btn btn-primary']);?>
    </div>

</div>
