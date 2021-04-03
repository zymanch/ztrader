<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model backend\models\forms\LoginForm */

use app\extensions\yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="gray-bg login-page-wrapper">

    <div class="text-center">
        <h1 class="logo-name">TRADER</h1>
    </div>

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['class' => 'm-t', 'role' => 'form']]); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'class' => 'form-control', 'placeholder' => 'Username', 'required' => 'required'])->label(false) ?>

            <?= $form->field($model, 'password')->passwordInput(['class' => 'form-control', 'placeholder' => 'Password', 'required' => 'required'])->label(false) ?>

            <?= Html::hiddenInput('LoginForm[rememberMe]',1); ?>

            <div class="form-group">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary block full-width m-b', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>