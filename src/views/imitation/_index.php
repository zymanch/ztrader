<?php

use app\widgets\InspiniaGrid;
use backend\models\TraderImitation;
use yii\bootstrap\Html;
use yii\data\ArrayDataProvider;

/**
 * @var $imitations TraderImitation[]
 */
?>
<div class="text-right">
    <?=Html::a('Создать имитацию',['imitation/create'],['class'=>'btn btn-primary']);?>
</div>
<br>
<div class="project-list">
    <?= InspiniaGrid::widget([
          'dataProvider' => new ArrayDataProvider(['allModels'=>$imitations,'key'=>'trader_imitation_id']),
          'formatter'    => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
          'tableOptions' => [
              'class' => 'table table-striped table-hover table-pointer fixed-table',
          ],
          'rowOptions' => function(TraderImitation $model, $key, $index, $grid) {
              if ($model->status == TraderImitation::STATUS_PROCESSING) {
                  return ['class'=>'warning'];
              }
              return [];
          },
          'columns'      => [
              [
                  'label'          => 'Имя инструмента',
                  'attribute'      => 'name',
                  'format'         => 'raw',
                  'value' => function(TraderImitation $imitation) {
                      return Html::a(htmlspecialchars($imitation->trader->name),['imitation/view','id'=>$imitation->trader_imitation_id]);
                  }
              ],
              [
                  'label'          => 'Состояние',
                  'attribute'      => 'status',
                  'value' => function(TraderImitation $imitation) {
                      switch ($imitation->status) {
                          case TraderImitation::STATUS_PROCESSING:
                              return 'В процессе';
                          case TraderImitation::STATUS_WAITING:
                              return 'В очереди';
                      }
                  },
                  'headerOptions'=>['style'=>'width:200px'],
                  'contentOptions'=>['style'=>'width:200px'],
              ],
              [
                  'label'          => 'Прогресс',
                  'attribute'      => 'progress',
                  'value' => function(TraderImitation $imitation) {
                      if ($imitation->status != TraderImitation::STATUS_PROCESSING) {
                          return;
                      }
                      return number_format($imitation->progress,2).'%';
                  },
                  'headerOptions'=>['style'=>'width:200px'],
                  'contentOptions'=>['style'=>'width:200px'],
              ]
          ],
    ]);?>


</div>
