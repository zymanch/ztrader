<?php

use app\widgets\InspiniaGrid;

/**
 * @var array $applications
 */
?>
<?php echo InspiniaGrid::widget([
        'dataProvider' => new \yii\data\ArrayDataProvider(['key'=>'test_id','pagination'=>false,'allModels'=>$models]),
        'formatter'    => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
        'tableOptions' => [
            'class' => 'table table-striped table-hover table-pointer toggle-arrow-tiny default fixed-table payments-table',
        ],
        'rowOptions'   => function (\backend\models\Test $model, $key, $index, $grid) {
            $class = '';
            if ($model->enabled == \backend\models\Test::ENABLED_NO) {

            } else if ($model->status == \backend\models\Test::STATUS_ERROR) {
                $class = 'danger';
            } else  if ($model->status == \backend\models\Test::STATUS_OK) {
                $class = 'success';
            }
            return [
                'class' => $class,
            ];
        },
        'columns'      => [
            [
                'label' => 'ID',
                'attribute' => 'test_id',
                'contentOptions' => ['style'=>'width:100px'],
                'headerOptions' => ['style'=>'width:100px'],
            ],
            [
                'label' => '',
                'format' => 'raw',
                'contentOptions' => ['style'=>'width:60px'],
                'headerOptions' => ['style'=>'width:60px'],
                'value' => function(\backend\models\Test  $test) {
                    return '<small><strong>'.$test->method.'</strong></small>';
                },
            ],
            [
                'label' => 'Name',
                'format' => 'raw',
                'value' => function(\backend\models\Test  $test) {
                    return \yii\bootstrap\Html::a($test->name,['tests/view','id'=>$test->test_id]);
                },
            ],
            [
                'label' => 'Status',
                'attribute' => 'status',
                'contentOptions' => ['style'=>'width:100px','class'=>'text-center'],
                'headerOptions' => ['style'=>'width:100px','class'=>'text-center'],
                'format' => 'raw',
                'value' => function (\backend\models\Test $test) {
                    if ($test->status == \backend\models\Test::STATUS_OK) {
                        return 'passed';
                    }
                    return 'failed';
                }
            ],
            [
                'label' => 'Actions',
                'format'=>'raw',
                'contentOptions' => ['style'=>'width:150px'],
                'headerOptions' => ['style'=>'width:150px'],
                'value' => function(\backend\models\Test $test) {
                    $buttons = [
                        \yii\bootstrap\Html::a('View',['tests/view','id' => $test->test_id],['class'=>'btn btn-xs btn-primary']),
                        \yii\bootstrap\Html::a('Run',['tests/run','id' => $test->test_id],['class'=>'btn btn-xs btn-warning']),
                    ];
                    if ($test->enabled == \backend\models\Test::ENABLED_YES) {
                        $buttons[] = \yii\bootstrap\Html::a('Disable',['tests/disable','id' => $test->test_id],['class'=>'btn btn-xs btn-default']);
                    } else {
                        $buttons[] = \yii\bootstrap\Html::a('Enable',['tests/enable','id' => $test->test_id],['class'=>'btn btn-xs btn-info']);
                    }
                    return implode(' ', $buttons);
                }
            ]
        ],
    ]);