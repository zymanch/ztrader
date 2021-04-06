<?php
/**
 * @var $traders \backend\models\Trader[]
 */
use app\extensions\yii\helpers\Html;
?>
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
                        <?=$this->render('_index',['traders'=>$traders]);?>
                    </div>
                </div>

            </div>


        </div>
    </div>
</div>
