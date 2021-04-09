<?php
/**
 * @var $model Trader
 * @var $form \yii\bootstrap\ActiveForm
 * @var $bayer \backend\components\buyer\Base
 */

use app\extensions\yii\helpers\Html;
use backend\models\Trader;

?>

<h2>Покупатель для <?=htmlspecialchars($model->name);?></h2>

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
        <?php echo Html::submitButton('Сохранить',['class'=>'btn btn-success']);?>
        <?php echo Html::a('Назад',['trader/view','id'=>$model->trader_id],['class'=>'btn btn-link']);?>
    </div>
</div>


