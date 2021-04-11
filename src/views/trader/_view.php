<?php
/**
 * @var $model Trader
 */

use app\extensions\yii\helpers\Html;
use backend\models\Trader;

?>
<div class="row">
    <div class="col-xs-6">
        <h2>Инструмент <?=htmlspecialchars($model->name);?></h2>
    </div>
</div>
<div class="row">
    <div class="col-xs-2">
        <a href="<?=\yii\helpers\Url::to(['trader/buyer','id'=>$model->trader_id]);?>" class="btn btn-primary btn-block">
            <br><strong>Настроить<br>Покупателя</strong><br><br>
        </a>
    </div>

    <div class="col-xs-2">
        <a href="<?=\yii\helpers\Url::to(['trader/seller','id'=>$model->trader_id]);?>" class="btn btn-primary btn-block">
            <br><strong>Настроить<br>Продавца</strong><br><br>
        </a>
    </div>


    <div class="col-xs-2">
        <a href="<?=\yii\helpers\Url::to(['trader/update','id'=>$model->trader_id]);?>" class="btn btn-info btn-block">
            <br><strong>Настройки</strong><br><br><br>
        </a>
    </div>
    <div class="col-xs-2">
        <a href="<?=\yii\helpers\Url::to(['imitation/create','trader_id'=>$model->trader_id]);?>" class="btn btn-warning btn-block">
            <br><strong>Создать<br>Имитацию</strong><br><br>
        </a>
    </div>
    <div class="col-xs-2">
        <a href="<?=\yii\helpers\Url::to(['trader/delete','id'=>$model->trader_id]);?>" class="btn btn-danger btn-block">
            <br><strong>Удалить<br>Инструмент</strong><br><br>
        </a>
    </div>
</div>
