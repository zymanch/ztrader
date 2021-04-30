<?php

use backend\models\Currency;
use backend\models\CurrencyQuery;

$currencies = CurrencyQuery::model()->filterByActive(Currency::ACTIVE_YES)->all();
?>
<hr>
<?php foreach ($currencies as $currency):?>
<div class="form-group">
    <div class="col-xs-2"><?=$currency->name;?>:</div>
    <div class="col-xs-10">
        <?php for ($year = date('Y');$year <=date('Y');$year++):?>
             <?=$year;?> год, месяц
            <?php for ($month='01'; $month < date('m');$month=sprintf('%02d',$month+1)):?>
                <?=\app\extensions\yii\helpers\Html::a(
                        date('F', strtotime($year.'-'.$month.'-01')),
                        ['zone/view','id'=>$currency->currency_id,'date'=>'2021-'.$month]
                );?>,
            <?php endfor;?>
        <?php endfor;?>
    </div>
</div>
<?php endforeach;?>