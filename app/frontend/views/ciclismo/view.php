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

$this->registerJsFile("@web/@mapbox/polyline/index.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
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
                <br>
            </div>
            <div class="col-lg-3">
                    <strong>Tempo: </strong><?= Converter::secondsToHours($model->duracao)?>
                    <br>
                    <strong>Distancia: </strong><?= $model->duracao?>
            </div>
            <div class="col-lg-3">
                    <strong>Velocidade Média: </strong> <?=$model->velocidade_media?>
                    <br>
                    <strong>Velocidade Máxima: </strong><?=$model->velocidade_maxima?>
            </div>
            <div class="col-lg-3">
                <br>
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
        zoom: 14
    });

    map.on('load', () => {
        var array = polyline.decode('<?= $model->rota?>', 6);
        map.addSource('route', {
            'type': 'geojson',
            'data': {
                'type': 'Feature',
                'properties': {},
                'geometry': {
                    'type': 'LineString',
                    'coordinates': array
                }
            }
        });
        map.addLayer({
            'id': 'route',
            'type': 'line',
            'source': 'route',
            'layout': {
                'line-join': 'round',
                'line-cap': 'round'
            },
            'paint': {
                'line-color': '#F00',
                'line-width': 8
            }
        });
    });
</script>