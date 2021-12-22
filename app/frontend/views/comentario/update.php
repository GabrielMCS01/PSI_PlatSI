<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Comentario */

$this->title = 'Atualizar comentario';
$this->params['breadcrumbs'][] = ['label' => 'Comentarios', 'url' => ['indexpost', 'id' => $model->publicacao_id]];
$this->params['breadcrumbs'][] = ['label' => "Comentário de " . $model->user->username , 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="comentario-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
