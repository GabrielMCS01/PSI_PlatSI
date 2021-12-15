<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $role_name */
/* @var $user_info */
/* @var $auth_model */

$tipos_user = [0 => 'admin', 1 => 'user'];
$tipo_user_selected = 1;

if ($role_name == 'admin'){
    $tipo_user_selected = 0;
} elseif ($role_name == 'user'){
    $tipo_user_selected = 1;
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
    ]);

    var_dump($tipos_user);?>


    <?= $form->field($auth_model, 'item_name')->dropDownList($tipos_user, ['options' => [$tipo_user_selected => ['Selected'=> true]]]);?>

    <div class="form-group">
        <?= Html::submitButton('Guardar Alterações', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
