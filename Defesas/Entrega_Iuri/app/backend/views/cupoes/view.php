<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Cupoes */

$this->title = "Cupões";
$this->params['breadcrumbs'][] = ['label' => 'Cupoes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="cupoes-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <br>
    <?php foreach ($cupoes as $cupao){?>
        <p><?= $cupao->codigo?> - <?=$cupao->codigo_verificacao?></p>
        <?php }?>


</div>
