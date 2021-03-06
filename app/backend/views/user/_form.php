<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $roles */
/* @var $role_name */
/* @var $user_info */
/* @var $auth_model */

// Padrão
$tipo_user_selected = 1;

// Recebe todos os tipos de utilizadores possiveis de se selecionar
for ($i = 0; $i < count($roles); $i++){
    // Seleciona qual o tipo de utilizador que é o utilizador que se pretende editar
    if($roles[$i]->name == $role_name){
        $tipo_user_selected = $i;
    }
    $tipos_user[$i] = $roles[$i]->name;
}
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($user_info, 'primeiro_nome')->textInput(); ?>

    <?= $form->field($user_info, 'ultimo_nome')->textInput(); ?>

    <?= $form->field($user_info, 'data_nascimento')->widget(DatePicker::classname(), [
        'language' => 'pt',
        'options' => ['class' => 'form-control'],
        'dateFormat' => 'yyyy-MM-dd',
    ]); ?>

    <?= $form->field($auth_model, 'item_name')->dropDownList($tipos_user, ['options' => [$tipo_user_selected => ['Selected'=> true]]]);?>

    <div class="form-group">
        <?= Html::submitButton('Guardar Alterações', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
