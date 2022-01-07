<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Cupoes */

$this->title = 'Create Cupoes';
$this->params['breadcrumbs'][] = ['label' => 'Cupoes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cupoes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
