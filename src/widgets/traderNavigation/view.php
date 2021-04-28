<?php

use app\extensions\yii\helpers\Html;
use app\widgets\TraderNavigation;
use yii\widgets\Breadcrumbs;

/**
 * @var $this \yii\web\View
 * @var $context TraderNavigation
 */
$context = $this->context;
?>
<div class="row">
    <div class="col-xs-12">

        <div class="tabs-container">
            <ul class="nav nav-tabs">
                <?php foreach ($context->menuItemList as $key => $item):?>
                <li class="<?=$key==$context->menuItemActive?'active':'';?>"><?= Html::a($item[0],$item[1]);?></li>
                <?php endforeach;?>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active">
                    <div class="panel-body">
                        <?php echo Breadcrumbs::widget([
                            'links' => $context->breadcrumbs
                        ]);?>
                        <?=$context->content;?>
                    </div>
                </div>

            </div>


        </div>
    </div>
</div>
