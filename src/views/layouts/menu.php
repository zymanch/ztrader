<?php

/* @var $this \yii\web\View */
use app\widgets\InspiniaNav;
?>
<style>
    .navbar-nav > li {
        text-transform: uppercase;
    }
</style>
<div class="row border-bottom white-bg navbar-fixed-top">
    <?php

    echo InspiniaNav::widget([
            'id' => 'side-menu',
            'options' => ['class' => 'nav navbar-nav'],
            'items' => Yii::$app->controller->menuItemList,
            'dropDownCaret' => '',
            'header' => \app\widgets\MainMenu::widget([
                'title' => 'SMOKE TESTS',
            ]),
            'footer' => '<ul class="nav navbar-top-links navbar-right"><!--START-->
                            <li>
                                <a href="/login/logout">
                                    <i class="fa fa-sign-out"></i>
                                </a>
                            </li>
                        </ul>'
            ]);
    ?>
</div>