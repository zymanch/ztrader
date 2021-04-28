<?php
/**
 * @var $model \backend\models\TraderImitation
 * @var $history \backend\models\TraderHistory
 *
 *
 */
use app\extensions\yii\helpers\Html;
use app\widgets\TraderNavigation;
use yii\widgets\Breadcrumbs;

?>
<?php echo TraderNavigation::widget([
    'menuItemActive' => 'imitations',
    'breadcrumbs' => [
        ['label' => 'Список имитации','url' => ['imitation/index']],
        'Имитация №'.$model->trader_imitation_id,
    ],
    'content' => $this->render('_history',['model'=>$model,'history'=>$history])
]);?>