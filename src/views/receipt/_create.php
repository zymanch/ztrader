<?php

use app\extensions\yii\helpers\Html;
use backend\models\forms\UploadReceiptForm;
use yii\bootstrap\ActiveForm;
use yii\web\View;

/**
 * @var $this View
 * @var $model UploadReceiptForm
 * @var $form ActiveForm
 */
$this->registerJs('$("#uploadreceiptform-receipt").change(function() {
    $("#'.$form->id.'").submit();
});')
?>
<div class="row">
    <div class="col-md-1 hidden-xl"></div>
    <div class="col-md-2">
        <?= Html::fileInput('UploadReceiptForm[receipt]','',['id'=>'uploadreceiptform-receipt','accept'=>'image/*','capture'=>'camera','style'=>'visibility:hidden']);?>
        <label for="uploadreceiptform-receipt" class="btn btn-default" style="cursor: pointer">
            <img src="/images/qr-code.png"/>
        </label>
    </div>
    <div class="col-md-5">
        <h2>Инструкция по применению</h2>
        <ul>
            <li>Кликните на кнопку загрузки чека</li>
            <li>Сфотографируйте часть чека с QR-кодом</li>
            <li>Чек будет распознан и добавлен в систему автоматически</li>
            <li>Вам будет доступен чак для сканирвоания немедленно. Другие участники увидят ваш чек только через час</li>
        </ul>
    </div>
</div>
