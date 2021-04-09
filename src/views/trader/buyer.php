<?php
/**
 * @var $model \backend\models\Trader
 * @var $bayer \backend\components\buyer\Base
 */
use app\extensions\yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<?php $form = ActiveForm::begin(['method'=>'post','layout'=>'horizontal']); ?>
<div class="row">
    <div class="col-xs-12">

        <div class="tabs-container">
            <ul class="nav nav-tabs">
                <li class="active"><?= Html::a('Инструменты',['trader/index']);?></li>
                <li class=""><?= Html::a('Эмитации',['imitation/index']);?></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active">
                    <div class="panel-body">
                        <?=$this->render('_buyer',['model'=>$model,'bayer'=>$bayer,'form'=>$form]);?>
                    </div>
                </div>

            </div>


        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
