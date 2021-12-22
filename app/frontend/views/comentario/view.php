<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Comentario */

$this->title = "Comentário de " . $model->user->username;
$this->params['breadcrumbs'][] = ['label' => 'Comentarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="comentario-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (Yii::$app->user->can("UpdateComment", ['comentario' => $model])) { ?>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php } ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Deseja remover este comentário?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="jumbotron text-center">
        <h4><strong>Comentário de <?= Html::encode($model->user->username) ?></strong></h4>
        <h5><strong>Texto</strong></h5>
        <p><?= HtmlPurifier::process($model->content) ?></p>
        <p><?= Html::encode($model->createtime) ?></p>
    </div>

</div>
