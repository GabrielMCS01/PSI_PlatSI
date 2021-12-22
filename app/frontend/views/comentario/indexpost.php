<?php

use yii\bootstrap4\LinkPager;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\ListView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $pagination */
/* @var $comentarios  */
/* @var $id  */

$this->title = 'Comentarios';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="comentario-index">

        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a('Criar Comentario', ['create', 'id' => $id], ['class' => 'btn btn-success']) ?>
        </p>

        <?php foreach ($comentarios as $comentario){?>
        <br>
        <h3><strong><?= Html::encode($comentario->user->username) ?></strong></h3>
        <h5><?= HtmlPurifier::process($comentario->content) ?></h5>
        <?= Html::encode($comentario->createtime) ?>
        <br>
        <br>
        <?php }?>
        <?php Pjax::begin(); ?> 
        <?= LinkPager::widget(['pagination' => $pagination]) ?>
        <?php Pjax::end(); ?>

    </div>
<?php
