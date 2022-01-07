<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Clientes */
/* @var $cupoes */

$this->params['breadcrumbs'][] = ['label' => 'Clientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="clientes-view">
    <?php foreach ($cupoes as $cupoe) { ?>
        <h3><?= $cupoe->codigo ?></h3>
        <h3><?= $cupoe->codigo_verificacao ?></h3>
    <?php } ?>
</div>
