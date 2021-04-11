<?php
/**
 * @var $model Trader
 * @var $form ActiveForm
 */

use backend\models\CurrencyQuery;
use backend\models\Trader;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;

?>
<div class="form-group">
    <div class="col-sm-offset-3 col-sm-6">
        <h2>Создание нового инструмента</h2>
    </div>
</div>

<?=$form->field($model,'currency_id')->dropDownList(ArrayHelper::map(CurrencyQuery::model()->orderByPosition()->all(),'currency_id', 'name'));?>
<?=$form->field($model,'name')->textInput();?>
<div class="form-group">
    <div class="col-sm-offset-3">
        <?= Html::submitButton('Создать инструмент',['class'=>'btn btn-primary']);?>
    </div>
</div>
