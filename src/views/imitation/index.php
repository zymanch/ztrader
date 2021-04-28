<?php
/**
 * @var $imitations \backend\models\TraderImitation[]
 */
use app\extensions\yii\helpers\Html;
use app\widgets\TraderNavigation;
use yii\widgets\Breadcrumbs;

?>
<?php echo TraderNavigation::widget([
    'menuItemActive' => 'imitations',
    'breadcrumbs' => [
        'Список имитации',
    ],
    'content' => $this->render('_index',['imitations'=>$imitations])
]);?>
