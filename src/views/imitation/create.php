<?php
/**
 * @var $model \backend\models\forms\ImitationForm
 */
use app\extensions\yii\helpers\Html;
use app\widgets\TraderNavigation;use yii\bootstrap\ActiveForm;
use yii\widgets\Breadcrumbs;

?>
<?php $form = ActiveForm::begin(['method'=>'post','layout'=>'horizontal']); ?>
<?php echo TraderNavigation::widget([
    'menuItemActive' => 'imitations',
    'breadcrumbs' => [
        ['label' => 'Список имитации','url' => ['imitation/index']],
        'Создать имитацию'
    ],
    'content' => $this->render('_create',['model'=>$model,'form'=>$form])
]);?>
<?php ActiveForm::end(); ?>
