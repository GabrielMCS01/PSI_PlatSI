<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\jui\DatePicker;

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

    <?= $form->field($user_info, 'data_nascimento')->widget(DatePicker::classname(), [
        'language' => 'pt',
        'options' => ['class' => 'form-control'],
        'dateFormat' => 'yyyy-MM-dd',
    ]) ?>

    <?= $form->field($auth_model, 'item_name')->dropdownList([
        'options' => \common\models\AuthItem::find()->where(['type' => 1])->all()]);
            /*'Administrador'
                ['value' => 'Admin',
                if ($auth_model->item_name == 'Admin'){
                    'selected' => true;
                }],

                /*'options' => [
         $company_id => [
            'selected' => 'selected',
            'label' => 'test'
        ]*/



           /* 'Moderador' => 'Moderador',
            'User' => 'Utilizador']]);*/ ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar Alterações', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
