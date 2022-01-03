<?php

use yii\bootstrap4\LinkPager;
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\helpers\HtmlPurifier;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $comentarios */
/* @var $pagination */

$this->title = 'Comentários';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="comentario-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>
    <!-- Mostra todos os comentários -->
    <?php foreach ($comentarios as $comentario) { ?>
        <br>
        <h3><strong><?= Html::encode($comentario->user->username) ?></strong>
            - <?= Html::encode($comentario->publicacao->ciclismo->nome_percurso) ?></h3>
        <h5><?= HtmlPurifier::process($comentario->content) ?></h5>
        <p><?= Html::encode($comentario->createtime) ?></p>

        <?= Html::a('Apagar Comentário', ['deletemoderador', 'id' => $comentario->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Deseja remover este comentário?',
            'method' => 'post',
        ],
    ]) ?>
        <br>
        <br>
    <?php } ?>
    <?= LinkPager::widget(['pagination' => $pagination]) ?>
    <?php Pjax::end(); ?>

</div>
