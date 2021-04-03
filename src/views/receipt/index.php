<?php
/**
 * @var $receipt \backend\models\Receipt
 */
use app\extensions\yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-xs-12">

        <div class="tabs-container">
            <ul class="nav nav-tabs">
                <li class="active"><?= Html::a('Список чеков',['receipt/index']);?></li>
                <li class=""><?= Html::a('Добавить чек',['receipt/create']);?></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active">
                    <div class="panel-body">
                        <?=$this->render('_index',['form'=>$form,'receipt'=>$receipt,'qr_code'=>$qr_code]);?>
                    </div>
                </div>

            </div>


        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
