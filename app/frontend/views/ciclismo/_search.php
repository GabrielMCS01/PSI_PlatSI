<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CiclismoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ciclismo-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nome_percurso') ?>

    <?= $form->field($model, 'duracao') ?>

    <?= $form->field($model, 'distancia') ?>

    <?= $form->field($model, 'velocidade_media') ?>

    <?php // echo $form->field($model, 'velocidade_maxima') ?>

    <?php // echo $form->field($model, 'velocidade_grafico') ?>

    <?php // echo $form->field($model, 'rota') ?>

    <?php // echo $form->field($model, 'data_treino') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
