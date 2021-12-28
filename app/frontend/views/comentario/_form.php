<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Comentario */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="comentario-form">

    <?php $form = ActiveForm::begin(['id' => 'form-comentario']); ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Publicar Comentário', ['class' => 'btn btn-success', 'name' => 'criarcomentario-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
