<?php
/**
 * @var $model \backend\models\Trader
 */
use app\extensions\yii\helpers\Html;
use yii\widgets\Breadcrumbs;

?>
<div class="row">
    <div class="col-xs-12">

        <div class="tabs-container">
            <div class="col-xs-offset-3 col-xs-6">
            <div class="tab-content">
                <div class="tab-pane active">
                    <div class="panel-title">

                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12">
                                Вы действительно хотите удалить инструмент
                                <strong><?=htmlspecialchars($model->name);?></strong><br><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-offset-4 col-xs-4 text-center">
                                <?=Html::a('Удалить',['trader/delete','id'=>$model->trader_id,'confirm'=>1],['class'=>'btn btn-primary']);?>
                                <?=Html::a('Отмена',['trader/view','id'=>$model->trader_id],['class'=>'btn btn-link']);?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            </div>

        </div>
    </div>
</div>
