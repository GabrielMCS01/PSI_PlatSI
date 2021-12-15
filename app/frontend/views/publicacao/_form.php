<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Publicacao */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="publicacao-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'createtime')->textInput() ?>

    <?= $form->field($model, 'ciclismo_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
