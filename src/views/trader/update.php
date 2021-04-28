<?php
/**
 * @var $model \backend\models\Trader
 */
use app\extensions\yii\helpers\Html;
use app\widgets\TraderNavigation;
use yii\bootstrap\ActiveForm;
use yii\widgets\Breadcrumbs;

?>
<?php $form = ActiveForm::begin(['method'=>'post','layout'=>'horizontal']); ?>
<?php echo TraderNavigation::widget([
    'menuItemActive' => 'tools',
    'breadcrumbs' => [
        ['label' => 'Список инструментов','url' => ['trader/index']],
        'Настройки '.$model->name,
    ],
    'content' => $this->render('_update',['model'=>$model,'form'=>$form])
]);?>
<?php ActiveForm::end(); ?>