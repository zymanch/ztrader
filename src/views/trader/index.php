<?php
/**
 * @var $traders \backend\models\Trader[]
 */
use app\extensions\yii\helpers\Html;
use app\widgets\TraderNavigation;
use yii\widgets\Breadcrumbs;

?>
<?php echo TraderNavigation::widget([
    'menuItemActive' => 'tools',
    'breadcrumbs' => [
        'Список инструментов',
    ],
    'content' => $this->render('_index',['traders'=>$traders])
]);?>