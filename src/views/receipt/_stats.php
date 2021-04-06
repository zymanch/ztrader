<?php
/**
 * @var $users
 */

use app\widgets\InspiniaGrid;
use yii\bootstrap\Html;
use yii\data\ArrayDataProvider;

?>
<?= InspiniaGrid::widget([
    'dataProvider' => new ArrayDataProvider(['allModels'=>$users,'key'=>'user_id']),
    'formatter'    => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
    'tableOptions' => [
        'class' => 'table table-striped table-hover table-pointer fixed-table',
    ],
    'rowOptions' => function($model, $key, $index, $grid) {
        $watchedReceipts = $model['receipts_used_count']+$model['receipts_skipped_count']+$model['receipts_unusable_count'];
        $createdReceipts = $model['receipts_created_count'];
        if ($watchedReceipts > $createdReceipts*5) {
            return ['class'=>'error'];
        }
        if ($watchedReceipts > $createdReceipts*3) {
            return ['class'=>'warning'];
        }
        return [];
    },
    'columns'      => [
        [
            'label'          => 'ID',
            'attribute'      => 'user_id',
            'headerOptions'=>['style'=>'width:100px'],
            'contentOptions'=>['style'=>'width:100px'],

        ],
        [
            'label'          => 'Имя пользователя',
            'attribute'      => 'username',
            'format'         => 'raw',
            'value' => function($user) {
                return Html::a(htmlspecialchars($user['username']),'#');
            },
        ],
        [
            'label'          => 'Загрузил',
            'attribute'      => 'receipts_created_count',
            'headerOptions'=>['style'=>'width:150px'],
            'contentOptions'=>['style'=>'width:150px'],
        ],
        [
            'label'          => 'Использовал',
            'attribute'      => 'receipts_used_count',
            'headerOptions'=>['style'=>'width:150px'],
            'contentOptions'=>['style'=>'width:150px'],
        ],
        [
            'label'          => 'Пропустил',
            'attribute'      => 'receipts_skipped_count',
            'headerOptions'=>['style'=>'width:150px'],
            'contentOptions'=>['style'=>'width:150px'],
        ],
        [
            'label'          => 'Забраковал',
            'attribute'      => 'receipts_unusable_count',
            'headerOptions'=>['style'=>'width:150px'],
            'contentOptions'=>['style'=>'width:150px'],
        ]
    ],
]);?>

