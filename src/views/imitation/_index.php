<?php

use app\widgets\InspiniaGrid;
use backend\models\TraderImitation;
use yii\bootstrap\Html;
use yii\data\ArrayDataProvider;

/**
 * @var $imitations TraderImitation[]
 * @var $this \yii\web\View
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
                  'label'          => 'Доходность в месяц',
                  'format'         => 'raw',
                  'value' => function(TraderImitation $imitation) {
                      $income = $imitation->getMonthlyIncome();
                      $class = 'label ';
                      if ($income ===null) {

                      } else if ($income < 0) {
                          $class.='label-danger';
                      } else if ($income < 10) {
                          $class.='label-warning';
                      } else {
                          $class.='label-success';
                      }
                      return '<span id="imitation-income-'.$imitation->trader_imitation_id.'" class="'.$class.'">'.$income.'%</span>';
                  }
              ],
              [
                  'label'          => 'Состояние',
                  'attribute'      => 'status',
                  'format'=>'raw',
                  'value' => function(TraderImitation $imitation) {
                      $text = '';
                      switch ($imitation->status) {
                          case TraderImitation::STATUS_PROCESSING:
                              $text = 'В процессе';break;
                          case TraderImitation::STATUS_WAITING:
                              $text = 'В очереди';break;
                          case TraderImitation::STATUS_FAILED:
                              $text =  'Ошибка';break;
                          case TraderImitation::STATUS_FINISHED:
                              $text =  'Завершен';break;
                      }
                      return '<span id="imitation-status-'.$imitation->trader_imitation_id.'">'.$text.'</span>';
                  },
                  'headerOptions'=>['style'=>'width:200px'],
                  'contentOptions'=>['style'=>'width:200px'],
              ],
              [
                  'label'          => 'Прогресс',
                  'attribute'      => 'progress',
                  'format'=>'raw',
                  'value' => function(TraderImitation $imitation) {
                      if ($imitation->status != TraderImitation::STATUS_PROCESSING) {
                          $progress = '';
                      } else{
                          $progress = number_format($imitation->progress).'%';
                      }
                      return '<span id="imitation-progress-'.$imitation->trader_imitation_id.'">'.$progress.'</span>';
                  },
                  'headerOptions'=>['style'=>'width:200px'],
                  'contentOptions'=>['style'=>'width:200px'],
              ]
          ],
    ]);?>


</div>
<?php
$this->registerJs("var imitationTimer = function() {
    setTimeout(function() {
        $.get('/imitation/status',function(result) {
            $.each(result.items,function() {
                var id = this.imitation_id,
                    \$income = $('#imitation-income-'+id),
                    \$status = $('#imitation-status-'+id),
                    \$progress = $('#imitation-progress-'+id);
                \$income.removeClass('danger warning success');
                if (this.income < 0) {
                      \$income.addClass('label-danger');
                  } else if (this.income < 10) {
                      \$income.addClass('label-warning');
                  } else {
                      \$income.addClass('label-success');
                  }
                \$income.html(Math.round(this.income*1000)/1000+'%');
                \$status.html();
                switch (this.status) {
                      case 'processing':
                          \$status.html('В процессе');break;
                      case 'waiting':
                          \$status.html('В очереди');break;
                      case 'failed':
                          \$status.html('Ошибка');break;
                      case 'finished':
                          \$status.html('Завершен');break;
                }
                \$progress.html(this.status=='processing'?Math.round(this.progress*100)/100+'%':'');
            });
            imitationTimer();
        });
    },2000);
}
imitationTimer();");