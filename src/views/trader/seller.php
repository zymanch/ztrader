<?php
/**
 * @var $model \backend\models\Trader
 * @var $seller \backend\components\seller\Base
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
        ['label' => 'Инструмент '.$model->name,'url' => ['trader/view','id'=>$model->trader_id]],
        'Продавец',
    ],
    'content' => $this->render('_seller',['model'=>$model,'seller'=>$seller,'form'=>$form])
]);?>
<?php ActiveForm::end(); ?>
