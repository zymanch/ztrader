<?php
/**
 * @var $model \backend\models\Trader
 */
use app\extensions\yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\Breadcrumbs;

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
                        <?php echo Breadcrumbs::widget([
                            'links' => [
                                ['label' => 'Список инструментов','url' => ['trader/index']],
                                'Настройки '.$model->name,
                            ],
                        ]);?>
                        <?=$this->render('_update',['model'=>$model,'form'=>$form]);?>
                    </div>
                </div>

            </div>


        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>