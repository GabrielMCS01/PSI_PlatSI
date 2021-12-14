<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \common\models\UserInfo */

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use yii\jui\DatePicker;

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
                    <?= Html::submitButton('Guardar Alterações', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
                <?php ActiveForm::end(); ?>
                <?= Html::button('Apagar', ['class' => 'btn btn-danger', 'name' => 'login-button']) ?>
            </div>
        </div>
    </div>
<?php
