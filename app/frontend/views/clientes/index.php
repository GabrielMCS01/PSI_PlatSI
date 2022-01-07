<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ClientesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $clientes */

$this->title = 'Clientes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clientes-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Clientes', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php foreach ($clientes as $cliente){ ?>
        <h3><?= Html::a($cliente->username, ['clientes/view', 'id' => $cliente->id], ['data-method' => 'post', 'class' => 'd-block']);?></h3>
    <?php } ?>


</div>
