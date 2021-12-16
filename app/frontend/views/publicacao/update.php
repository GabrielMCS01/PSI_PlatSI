<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Publicacao */

$this->title = 'Update Publicacao: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Publicacaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="publicacao-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
