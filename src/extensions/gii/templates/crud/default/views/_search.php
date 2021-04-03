<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator app\extensions\gii\templates\crud\Generator */

echo "<?php\n";
?>

use app\extensions\yii\helpers\Html;
use app\extensions\InspiniaFilterForm;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->searchModelClass, '\\') ?> */
/* @var $form $form app\extensions\InspiniaFilterForm */
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-search">

    <?= "<?php " ?>$form = InspiniaFilterForm::begin([
        'id' => '<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-search-form',
        'options' => ['class' => ''],
        ]);

        $form->renderFields($model, [
        <?php
        $count = 0;
        foreach ($generator->getColumnNames() as $attribute) {
            if (++$count < 6) {
                echo "    " . $generator->generateFilterColumn($attribute) . ",\n";
            } else {
                echo "    // " . $generator->generateFilterColumn($attribute) . ",\n";
            }
        }?>
    ]);

    InspiniaFilterForm::end(); ?>

</div>
