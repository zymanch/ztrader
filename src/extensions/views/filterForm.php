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
    <?php for($rowIndex = 0; $rowIndex < $rows; $rowIndex++):?>
        <div class="row">
            <?php
                $thisRowFields = array_slice($fields, $form->columnsPerRow * $rowIndex, $form->columnsPerRow);
                foreach ($thisRowFields as $attribute => $fieldConfig):?>
                    <?php
                        $bootstrapSMWidth = isset($fieldConfig['bootstrapColumnWidth']['sm']) ? $fieldConfig['bootstrapColumnWidth']['sm'] : $bootstrapColClass;
                        $bootstrapLGWidth = isset($fieldConfig['bootstrapColumnWidth']['lg']) ? $fieldConfig['bootstrapColumnWidth']['lg'] : $bootstrapColClass;
                        $bootstrapXLWidth = isset($fieldConfig['bootstrapColumnWidth']['xl']) ? $fieldConfig['bootstrapColumnWidth']['xl'] : $bootstrapColClass;
                    ?>
                    <div class="col-sm-<?= $bootstrapSMWidth?> col-lg-<?= $bootstrapLGWidth?> col-xl-<?= $bootstrapXLWidth?>">
                        <div class="form-group">
                            <?php
                                $field = $form->field($filterModel, $attribute);
                                if(isset($fieldConfig['type'])){
                                    $fieldType = $fieldConfig['type'];
                                    unset($fieldConfig['type']);
                                    unset($fieldConfig['bootstrapColumnWidth']);

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
        </div>
    <?php endfor;?>

    <div class="row">
        <div class="col-sm-4 pull-right text-right">
            <?= Html::submitButton('Search', ['class' => 'btn btn-w-m btn-primary']) ?>
            <?= Html::button('Clear', ['class' => 'btn btn-w-m btn-white clear-form'])?>
        </div>
    </div>
</div>