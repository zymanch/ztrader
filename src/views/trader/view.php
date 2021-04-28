<?php
/**
 * @var $model \backend\models\Trader
 */
use app\extensions\yii\helpers\Html;
use app\widgets\TraderNavigation;
use yii\widgets\Breadcrumbs;

?>
<?php echo TraderNavigation::widget([
    'menuItemActive' => 'tools',
    'breadcrumbs' => [
        ['label' => 'Список инструментов','url' => ['trader/index']],
        'Инструмент '.$model->name,
    ],
    'content' => $this->render('_view',['model'=>$model])
]);?>
