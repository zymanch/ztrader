<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 18.10.16
 * Time: 13:15
 */

use app\extensions\yii\helpers\Html;
use backend\assets\AppAsset;

$this->title = Yii::$app->name;
AppAsset::register($this);
$this->registerCss("
.logo-name {
    color: #e6e6e6;
    font-size: 120px;
    font-weight: 800;
    letter-spacing: -5px;
    margin-bottom: 0;
    display: inline-block;
}
.login-page-wrapper{
    height: 100%;
}
");
?>

<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
        <head>
            <meta charset="<?= Yii::$app->charset ?>">
            <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
            <link rel="icon" href="/favicon.ico" />
            <link rel="manifest" href="/manifest.json">
            <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
            <meta name="theme-color" content="#ffffff">
            <meta name="viewport" content="width=device-width, initial-scale=1">

            <?= Html::csrfMetaTags() ?>
            <title><?= Html::encode($this->title) ?></title>
            <?php $this->head() ?>
        </head>
        <body class="gtf-skin">
            <?php $this->beginBody() ?>

                <?= $content ?>

            <?php $this->endBody() ?>
        </body>
    </html>
<?php $this->endPage() ?>

