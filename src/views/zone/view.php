<?php
/**
 * @var $currency \backend\models\Currency
 * @var $date
 * @var array $zones
 */
use app\extensions\yii\helpers\Html;
use app\widgets\TraderNavigation;
use yii\widgets\Breadcrumbs;

?>
<?php echo TraderNavigation::widget([
    'menuItemActive' => 'zone',
    'breadcrumbs' => [
        ['label' => 'Список валют','url' => ['zone/index']],
        'Зоны '.$currency->name.' для '.$date,
    ],
    'content' => $this->render('_view',['currency'=>$currency, 'zones'=>$zones])
]);?>