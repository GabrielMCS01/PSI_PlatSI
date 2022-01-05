<?php

use yii\bootstrap4\LinkPager;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $pagination */
/* @var $comentarios */
/* @var $id */

$this->title = 'Comentários';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="comentario-index">

        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a('Criar Comentário', ['create', 'id' => $id], ['class' => 'btn btn-success']) ?>
        </p>

        <?php Pjax::begin(); ?>
        <!-- Mostra todos os comentários de uma publicação -->
        <?php foreach ($comentarios as $comentario) { ?>
            <br>
            <h3><strong><?= Html::encode($comentario->user->username) ?></strong></h3>
            <h5><?= HtmlPurifier::process($comentario->content) ?></h5>
            <p><?= Html::encode($comentario->createtime) ?></p>

            <?php
            // Caso o comentário seja do utilizador ou se o utilizador for um Moderador, ele pode editar o comentário
            if (Yii::$app->user->can("deleteCommentModerator", ['comentario' => $comentario])) {
                echo Html::a("Editar Comentário", ['view', 'id' => $comentario->id], ['class' => 'btn btn-success', 'data-pjax' => 0]);
            }
            ?>
            <br>
            <br>
        <?php } ?>
        <?= LinkPager::widget(['pagination' => $pagination]) ?>
        <?php Pjax::end(); ?>
    </div>
<?php
