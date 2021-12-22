<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Comentario */

$this->title = 'Adicionar novo comentario';
$this->params['breadcrumbs'][] = ['label' => 'Comentarios', 'url' => ['indexpost', 'id' => $id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comentario-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
