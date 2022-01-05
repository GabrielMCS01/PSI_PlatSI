<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Comentario */
/* @var $id */

$this->title = 'Adicionar novo comentário';
$this->params['breadcrumbs'][] = ['label' => 'Comentários', 'url' => ['indexpost', 'id' => $id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comentario-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
