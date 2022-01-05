<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Registo';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs("jQuery('#reveal-password').change(function(){jQuery('#signupform-password').attr('type',this.checked?'text':'password');})");

?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Preencha os seguintes campos com os seus dados para criar uma nova conta</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= Html::checkbox('reveal-password', false, ['id' => 'reveal-password', 'label' => 'Show Password']);?>

                <?= $form->field($model, 'primeiro_nome') ?>

                <?= $form->field($model, 'ultimo_nome')->label('Apelido') ?>

                <div class="form-group">
                    <?= Html::submitButton('Registar', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
