<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \common\models\UserInfo */

use kartik\dialog\Dialog;
use yii\bootstrap4\BootstrapAsset;
use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use yii\jui\DatePicker;
use kartik\dialog\DialogAsset;

$this->title = 'Perfil';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="site-login">
        <h1><?= Html::encode($this->title) ?></h1>

        <p>Username: <?= Html::encode($model->user->username)?></p>
        <p>Email: <?= Html::encode($model->user->email)?></p>

        <div class="row">
            <div class="col-lg-5">
                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'primeiro_nome')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'ultimo_nome')->textInput() ?>

                <?= $form->field($model, 'data_nascimento')->widget(DatePicker::classname(), [
                    'language' => 'pt',
                    'options' => ['class' => 'form-control'],
                    'dateFormat' => 'yyyy-MM-dd',
                ]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Guardar Alterações', ['class' => 'btn btn-primary', 'name' => 'update-button']) ?>
                </div>
                <?php ActiveForm::end(); ?>
                <?= Dialog::widget(['overrideYiiConfirm' => true]);?>
                <?=Html::a(
                    'Remover Perfil',
                    ['/user-info/delete'],
                    [
                        'data-confirm' => 'Deseja apagar este perfil?',
                        'data-method' => 'post',
                        'class' => 'btn btn-danger'])?>
            </div>
        </div>
    </div>
<?php
