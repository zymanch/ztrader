<?php

use app\widgets\InspiniaGrid;
use backend\models\Trader;
/**
 * @var $traders \backend\models\Trader[]
 */
?>
<div class="project-list">
    <?= InspiniaGrid::widget([
          'dataProvider' => new \yii\data\ArrayDataProvider(['allModels'=>$traders,'key'=>'trader_id']),
          'formatter'    => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
          'tableOptions' => [
              'class' => 'table table-striped table-hover table-pointer fixed-table',
          ],
          'rowOptions' => function(Trader $model, $key, $index, $grid) {
              if ($model->status == Trader::STATUS_ENABLED) {
                  return ['class'=>'success'];
              }
              if ($model->status == Trader::STATUS_PAUSED) {
                  return ['class'=>'warning'];
              }
          },
          'columns'      => [
              [
                  'label'          => 'Имя инструмента',
                  'attribute'      => 'name',
                  'format'         => 'raw',
                  'value' => function(Trader $trader) {
                      return \yii\bootstrap\Html::a(htmlspecialchars($trader->name),['trader/view','id'=>$trader->trader_id]);
                  }
              ],
              [
                  'label'          => 'Доходность в месяц',
                  'format' => 'raw',
                  'value' => function(Trader $trader) {
                      $income = $trader->getMonthlyIncome();
                      if ($income ===null) {
                          return '';
                      }
                      if ($income < 0) {
                          return '<span class="label label-danger">'.$income.'</span>';
                      }
                      if ($income < 10) {
                          return '<span class="label label-warning">'.$income.'</span>';
                      }
                      return '<span class="label label-success">'.$income.'</span>';
                  },
                  'headerOptions'=>['style'=>'width:200px'],
                  'contentOptions'=>['style'=>'width:200px'],

              ],
              [
                  'label'          => 'Покупатель',
                  'attribute'      => 'buyer_id',
                  'value' => function(Trader $trader) {
                      return $trader->buyer->name;
                  },
                  'headerOptions'=>['style'=>'width:200px'],
                  'contentOptions'=>['style'=>'width:200px'],

              ],
              [
                  'label'          => 'Продавец',
                  'attribute'      => 'seller_id',
                  'value' => function(Trader $trader) {
                      return $trader->seller->name;
                  },
                  'headerOptions'=>['style'=>'width:200px'],
                  'contentOptions'=>['style'=>'width:200px'],
              ],
              [
                  'label'          => 'Состояние',
                  'attribute'      => 'state',
                  'value' => function(Trader $trader) {
                      return $trader->state == Trader::STATE_BUYING ? 'Покупает' : 'Продает';
                  },
                  'headerOptions'=>['style'=>'width:200px'],
                  'contentOptions'=>['style'=>'width:200px'],
              ],
              [
                  'label'          => 'Дата последней операции',
                  'attribute'      => 'state',
                  'value' => function(Trader $trader) {
                      return $trader->state_date;
                  },
                  'headerOptions'=>['style'=>'width:200px'],
                  'contentOptions'=>['style'=>'width:200px'],
              ]
          ],
    ]);?>


</div>
