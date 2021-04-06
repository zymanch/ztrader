<?php
/**
 * @var $model ImitationForm
 * @var $form ActiveForm
 */

use backend\models\forms\ImitationForm;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;

?>
<div class="form-group">
    <div class="col-sm-offset-3 col-sm-6">
        <h2>Создание новой имитации</h2>
        <div class="alert alert-warning">
            Генерация имитации может занять много времени
        </div>
    </div>
</div>

<?=$form->field($model,'trader_id')->dropDownList(ArrayHelper::map(\backend\models\TraderQuery::model()->all(),'trader_id', 'name'));?>
<?=$form->field($model,'from')->widget(DatePicker::class,[
    'dateFormat' => 'php:Y-m-d',
    'options' => ['class' => 'form-control'],
]);?>
<?=$form->field($model,'to')->widget(DatePicker::class,[
    'dateFormat' => 'php:Y-m-d',
    'options' => ['class' => 'form-control'],
]);?>
<?=$form->field($model,'tick_size')->input('number',['options'=>['min'=>1]]);?>

<div class="form-group">
    <div class="col-sm-offset-3">
        <?= Html::submitButton('Сгенерировать эмитацию',['class'=>'btn btn-primary']);?>
    </div>
</div>
