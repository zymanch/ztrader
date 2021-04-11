<?php
/**
 * @var $model Trader
 * @var $form ActiveForm
 * @var $bayer Base
 */

use app\extensions\yii\helpers\Html;
use backend\components\buyer\Base;
use backend\models\BuyerQuery;
use backend\models\Trader;
use yii\bootstrap\ActiveForm;

?>

<h2>Покупатель для <?=htmlspecialchars($model->name);?></h2>
<div class="form-group">
    <label class="control-label col-sm-3">Тип</label>

    <div class="btn btn-group col-sm-6">
        <?php foreach (BuyerQuery::model()->all() as $type):?>
            <?=Html::a($type->name,['trader/buyer','id'=>$model->trader_id,'buyer_id'=>$type->buyer_id],['class'=>'btn btn-info '.($type->type==$bayer::TYPE?' active':'')]);?>
        <?php endforeach;?>
    </div>
</div>
<?php foreach ($bayer->getAvailableConfigs() as $key => $config):?>
    <?php switch ($config['type']):
        case 'number':?>
            <?php echo $form->field($bayer, $key)->input('number',['min'=>$config['min']??0,'max'=>$config['max']??null,'step'=>$config['step']??1]);?>
            <?php break;
        default:?>
            <?php echo $form->field($bayer, $key)->textInput($config);?>
            <?php endswitch;?>
<?php endforeach;?>
<hr>
<div class="row">
    <div class="col-xs-offset-3">
        <?php echo Html::submitButton('Сохранить',['class'=>'btn btn-primary']);?>
        <?php echo Html::a('Назад',['trader/view','id'=>$model->trader_id],['class'=>'btn btn-link']);?>
    </div>
</div>


