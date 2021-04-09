<?php
/**
 * @var $model Trader
 */

use app\extensions\yii\helpers\Html;
use backend\models\Trader;

?>
<div class="row">
    <div class="col-xs-6">
        <h2><?=htmlspecialchars($model->name);?></h2>
    </div>
    <div class="col-md-6 text-right">
        <?php echo Html::a('Покупатель',['trader/buyer','id'=>$model->trader_id],['class'=>'btn btn-lg btn-primary']);?>

        <?php echo Html::a('Продавец',['trader/seller','id'=>$model->trader_id],['class'=>'btn btn-lg btn-primary']);?>

        <?php echo Html::a('Настройки',['trader/update','id'=>$model->trader_id],['class'=>'btn btn-lg btn-info']);?>


    </div>
</div>

