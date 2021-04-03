<?php
/**
 * @var $this \yii\web\View
 * @var $errors \backend\models\Test[]
 */
?>
<div class="row">
    <div class="col-xs-6">
        <?= \app\widgets\IBox::widget([
            'title_text' => '<h3 style="font-weight: bold">Last errors</h3>',
            'content' => $this->render('_tests',['models' => $errors])
        ]);?>
    </div>
</div>


