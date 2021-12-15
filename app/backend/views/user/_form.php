<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $auth_model */
/* @var $user_info */

$tipos_user = array('admin', 'moderador', 'user');
$tipo_user_selected = -1;

if ($auth_model->item_name == 'admin'){
    $tipo_user_selected = 0;
} elseif ($auth_model->item_name == 'moderator'){
    $tipo_user_selected = 1;
} elseif ($auth_model->item_name == 'user'){
    $tipo_user_selected = 2;
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

    <?= $form->field($auth_model, 'item_name')->dropDownList($tipos_user, [$tipo_user_selected => ['Selected'=>'selected']]);?>

    <div class="form-group">
        <?= Html::submitButton('Guardar Alterações', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
