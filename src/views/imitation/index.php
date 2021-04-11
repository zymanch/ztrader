<?php
/**
 * @var $imitations \backend\models\TraderImitation[]
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
                                'Список имитации',
                            ],
                        ]);?>
                        <?=$this->render('_index',['imitations'=>$imitations]);?>
                    </div>
                </div>

            </div>


        </div>
    </div>
</div>
