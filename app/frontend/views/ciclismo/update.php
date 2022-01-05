<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Ciclismo */

$this->title = 'Atualizar Ciclismo: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Ciclismos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="ciclismo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
