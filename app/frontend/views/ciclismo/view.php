<?php

use common\utils\Converter;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Ciclismo */

$this->title = $model->nome_percurso;
$this->params['breadcrumbs'][] = ['label' => 'Historico', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="ciclismo-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="jumbotron text-center">
        <h3><?= $model->nome_percurso;?></h3>
        <h5><?=$model->data_treino?></h5>
        <br>
        <div id='map' style='height: 300px;'></div>
        <br>
        <div class="row">
            <div class="col-lg-3">
            </div>
            <div class="col-lg-3">
                <ul>
                    <li><strong>Tempo: </strong><?= Converter::secondsToHours($model->duracao)?></li>
                    <li><strong>Distancia: </strong><?= $model->duracao?></li>
                </ul>
            </div>
            <div class="col-lg-6">
                <ul>
                    <li><strong>Velocidade Média: </strong> <?=$model->velocidade_media?></li>
                    <li><strong>Velocidade Máxima: </strong><?=$model->velocidade_maxima?></li>
                </ul>
            </div>
            <div class="col-lg-3">
            </div>
        </div>
    </div>
</div>
<script>
    mapboxgl.accessToken = 'pk.eyJ1IjoiaXVyaWNhcnJhcyIsImEiOiJja3V3aDJrZWEwNjhuMm5xd3hqNHRuODdiIn0.Yztl8wZEMrxIlkEVwt1zgw';
    const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [-122.486052, 37.830348],
        zoom: 15
    });
</script>