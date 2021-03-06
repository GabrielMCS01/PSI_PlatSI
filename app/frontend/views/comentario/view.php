<?php

use kartik\dialog\Dialog;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

/* @var $this yii\web\View */
/* @var $model common\models\Comentario */

$this->title = "Comentário de " . $model->user->username;
$this->params['breadcrumbs'][] = ['label' => 'Comentários', 'url' => ['indexpost', 'id' => $model->publicacao_id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="comentario-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <!-- Mostra detalhadamente um comentário -->
    <p>
        <?php
        // Caso o comentário seja do próprio utilizador, ele pode editar o comentário
        if (Yii::$app->user->can("UpdateComment", ['comentario' => $model])) { ?>
            <?= Html::a('Atualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php } ?>
        <?php Dialog::widget(['overrideYiiConfirm' => true]); ?>
        <?= Html::a('Apagar', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data-confirm' => 'Deseja apagar este comentário?',
                'data-method' => 'post',
        ]) ?>
    </p>

    <div class="jumbotron text-center">
        <h4><strong>Comentário de <?= Html::encode($model->user->username) ?></strong></h4>
        <h5><strong>Texto</strong></h5>
        <p><?= HtmlPurifier::process($model->content) ?></p>
        <p><?= Html::encode($model->createtime) ?></p>
    </div>

</div>
