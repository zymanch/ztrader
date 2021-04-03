<?php
/**
 * @var $model UploadReceiptForm
 */
use app\extensions\yii\helpers\Html;
use backend\models\forms\UploadReceiptForm;
use yii\bootstrap\ActiveForm;

$form = ActiveForm::begin(['method'=>'post','options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="row">
    <div class="col-xs-12">

        <div class="tabs-container">
            <ul class="nav nav-tabs">
                <li class=""><?= Html::a('Список чеков',['receipt/index']);?></li>
                <li class="active"><?= Html::a('Добавить чек',['receipt/create']);?></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane" id="tab-none"></div>
                <div class="tab-pane active" id="tab-create">
                    <div class="panel-body">
                        <?=$this->render('_create',['form'=>$form,'model'=>$model]);?>
                    </div>
                </div>

            </div>


        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
