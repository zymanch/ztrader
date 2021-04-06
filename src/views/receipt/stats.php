<?php
/**
 * @var $users
 */
use app\extensions\yii\helpers\Html;
use yii\bootstrap\ActiveForm;
 ?>
<div class="row">
    <div class="col-xs-12">

        <div class="tabs-container">
            <ul class="nav nav-tabs">
                <li class=""><?= Html::a('Список чеков',['receipt/index']);?></li>
                <li class=""><?= Html::a('Добавить чек',['receipt/create']);?></li>
                <li class="active"><?= Html::a('Статистика',['receipt/stats']);?></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active">
                    <div class="panel-body">
                        <?=$this->render('_stats',['users'=>$users]);?>
                    </div>
                </div>

            </div>


        </div>
    </div>
</div>
