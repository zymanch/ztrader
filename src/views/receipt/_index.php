<?php
/**
 * @var $receipt Receipt
 */

use app\extensions\yii\helpers\Html;
use backend\models\Receipt;
use yii\helpers\Url;

?>
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-5">
        <?php if ($receipt):?>
            Дата покупки: <strong><?php echo $receipt->date;?></strong><br>
            Цена покупки: <strong><?=$receipt->amount;?>&#8381;</strong><br>
            <img src="<?= Url::to(['receipt/view','id'=>$receipt->receipt_id]);?>"/><br>
            <?=Html::a('Сканировал',['receipt/scanned','id'=>$receipt->receipt_id],['class'=>'btn btn-success']);?>
            <?=Html::a('Не принимается',['receipt/unusable','id'=>$receipt->receipt_id],['class'=>'btn btn-danger']);?>
            <?=Html::a('Пропустить',['receipt/skip','id'=>$receipt->receipt_id],['class'=>'btn btn-warning']);?>
        <?php else:?>
            <h3>Больше новых чеков нет</h3>
        <?php endif;?>
    </div>
    <div class="col-md-6">
        <h2>Инструкция по применению</h2>
        <ul>
            <li>Сканируйте чек вашим приложением и нажмите кнопку "Сканировал"</li>
            <li>Если чек не принимаеться нажмите кнопку "Не принимается"</li>
            <li>Если вы хотите пропустить чек, нажмите кнопку "Пропустить"</li>
            <li>Один и тот же чек может показывается нескольким пользователям</li>
            <li>Не забудте делиться своими чеками на <?= Html::a('странице добавления чеков',['receipt/create']);?></li>
        </ul>
    </div>
</div>