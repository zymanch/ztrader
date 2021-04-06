<?php
/**
 * @var $receipt Receipt
 */

use app\extensions\yii\helpers\Html;
use backend\models\Receipt;
use yii\helpers\Url;

$used = $receipt ? $receipt->getUserReceipts()->filterByStatus(\backend\models\UserReceipt::STATUS_USED)->count() : 0;
$unusable = $receipt ? $receipt->getUserReceipts()->filterByStatus(\backend\models\UserReceipt::STATUS_UNUSABLE)->count() : 0;
?>
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-5">
        <?php if ($receipt):?>
            <?php if ($receipt->user):?>
                Добавил: <strong><?php echo htmlspecialchars($receipt->user->username);?></strong><br>
            <?php endif;?>
            <?php if ($receipt->date):?>
                Дата покупки: <strong><?php echo $receipt->date;?></strong><br>
            <?php endif;?>
            <?php if ($receipt->amount):?>
                Цена покупки: <strong><?=$receipt->amount;?>&#8381;</strong><br>
            <?php endif;?>
            <?php if ($used+$unusable):?>
                Сканировали: <strong><?=$used+$unusable;?></strong> человек
                            <?php if ($unusable):?>, неуспешно <strong><?=$unusable;?></strong><?php endif;?>
                <br>
            <?php endif;?>
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
            <li>Показываются только чеки дата покупки которых не старше 3х дней</li>
            <li>Не забудте делиться своими чеками на <?= Html::a('странице добавления чеков',['receipt/create']);?></li>
        </ul>
    </div>
</div>