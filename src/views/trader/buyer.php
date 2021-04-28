<?php
/**
 * @var $model \backend\models\Trader
 * @var $bayer \backend\components\buyer\Base
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
        'Покупатель',
    ],
    'content' => $this->render('_buyer',['model'=>$model,'bayer'=>$bayer,'form'=>$form])
]);?>
<?php ActiveForm::end(); ?>
