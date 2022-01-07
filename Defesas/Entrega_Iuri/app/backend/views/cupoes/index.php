<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CupoesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cupoes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cupoes-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <br>
    <?php foreach ($clientes as $cliente){ ?>
        <p><?=$cliente->nome?> - <?=count($cliente->cupoes)?> Cupões</p>
        <?= Html::a('Ver Cupões', ['view', 'id' => $cliente->id], ['class' => 'btn btn-primary'])?>
        <?php } ?>


</div>
