<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 24.10.16
 * Time: 12:27
 * @var app\extensions\yii\bootstrap\FilterForm $form
 * @var $filterModel
 * @var $fields = array
 */


use app\extensions\yii\helpers\Html;

$fieldsCount = count($fields);
$rows = ceil($fieldsCount / $form->columnsPerRow);
$bootstrapColClass = 12 / $form->columnsPerRow;
?>

<div class="ibox-content m-b-sm border-bottom">
        <div class="row">
            <?php
                foreach ($fields as $attribute => $fieldConfig):?>
                    <div class="col-sm-<?= isset($fieldConfig['bootstrapColumnWidth']) ? $fieldConfig['bootstrapColumnWidth'] : $bootstrapColClass?>">
                        <div class="form-group">
                            <?php
                                $field = $form->field($filterModel, $attribute);
                                if(isset($fieldConfig['type'])){
                                    $fieldType = $fieldConfig['type'];
                                    unset($fieldConfig['type']);

                                    if($fieldType == 'dropDownList'){
                                        $items = \yii\helpers\ArrayHelper::remove($fieldConfig, 'items');
                                        echo call_user_func(array($field, $fieldType), $items, $fieldConfig);
                                    } else {
                                        echo call_user_func(array($field, $fieldType), $fieldConfig);
                                    }

                                } else {
                                    echo $field->textInput($fieldConfig);
                                }
                            ?>
                        </div>
                    </div>
            <?php endforeach;?>
            <div class="<?= $form->buttonWrapperClass ?> ">
                <?= Html::submitButton('Search', ['class' => 'btn btn-w-m btn-primary']) ?>
                <?= Html::button('Clear', ['class' => 'btn btn-white clear-form'])?>
            </div>
        </div>


</div>