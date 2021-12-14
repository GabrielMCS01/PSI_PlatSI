<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $auth_model */
/* @var $user_info */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($user_info, 'primeiro_nome')->textInput(); ?>
    <?= $form->field($user_info, 'ultimo_nome')->textInput(); ?>
    <?= $form->field($user_info, 'data_nascimento')->textInput(); ?>

    <?= $form->field($auth_model, 'item_name')->dropdownList([
        ['Admin' => 'Administrador', 'User' => 'Utilizador']]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
