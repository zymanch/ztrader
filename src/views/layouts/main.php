<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\extensions\yii\helpers\Html;
use app\widgets\Alert;
use app\widgets\Dialog;
use backend\assets\AppAsset;

AppAsset::register($this);
$this->registerJs('$(".table-scroll tbody").mCustomScrollbar({theme:"dark",alwaysShowScrollbar:1});');
if (!$this->title) {
    $this->title = Yii::$app->name;
};
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" href="/favicon.ico"/>
    <link rel="manifest" href="/manifest.json">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="theme-color" content="#ffffff">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?php $this->render('_messages'); ?>
</head>
<body class="top-navigation gtf-skin pace-done">
<?php $this->beginBody() ?>

<div id="wrapper">

    <div id="page-wrapper" class="gray-bg">
        <?= $this->render('menu'); ?>
        <?php if (isset($this->params['CTA'])): ?>
            <?= $this->params['CTA'] ?>
        <?php endif; ?>
        <div class="wrapper wrapper-content">
            <?= $content ?>
        </div>
        <div class="footer">
            <div>
                <strong>Copyright</strong> GTFLIX TV &copy; <?= date('Y') == '2016' ? date('Y') : '2016-' . date('Y') ?>
            </div>
        </div>

    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
