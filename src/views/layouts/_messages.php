<?php

/* @var $this \yii\web\View */
/* @var $content string */

$dialogs = ['success','error','danger','info','warning'];
foreach ($dialogs as $dialogType) {
    $message = Yii::$app->session->getFlash($dialogType, null, true);
    if (!$message) {
        continue;
    }
    if (is_array($message)) {
        $message = implode('. ',$message);
    }
    $this->registerJs('toastr["'.$dialogType.'"]('.json_encode($message).')');
}