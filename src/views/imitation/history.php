<?php
/**
 * @var $model \backend\models\TraderImitation
 * @var $history \backend\models\TraderHistory
 *
 *
 */
use app\extensions\yii\helpers\Html;
use yii\widgets\Breadcrumbs;

?>
<div class="row">
    <div class="col-xs-12">

        <div class="tabs-container">
            <ul class="nav nav-tabs">
                <li class=""><?= Html::a('Инструменты',['trader/index']);?></li>
                <li class="active"><?= Html::a('Эмитации',['imitation/index']);?></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active">
                    <div class="panel-body">
                        <?php echo Breadcrumbs::widget([
                            'links' => [
                                ['label' => 'Список имитации','url' => ['imitation/index']],
                                'Имитация №'.$model->trader_imitation_id,
                            ],
                        ]);?>
                        <?=$this->render('_history',['model'=>$model,'history'=>$history]);?>
                    </div>
                </div>

            </div>


        </div>
    </div>
</div>
