<?php

use common\utils\Converter;
use kartik\dialog\Dialog;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Ciclismo */
/* @var $publicar */

$this->title = $model->nome_percurso;
$this->params['breadcrumbs'][] = ['label' => 'Historico', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$this->registerJsFile("@web/@mapbox/polyline/src/polyline.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<div class="ciclismo-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="jumbotron text-center">
        <h3><?= $model->nome_percurso;?></h3>
        <h5><?=$model->data_treino?></h5>
        <br>
        <div id='map' style='height: 300px;'>
            <?php
            if($model->rota == ""){
                echo "<p>SEM ROTA</p>";
            }
            ?>
        </div>
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
        <div class="row">
            <div class="col-lg-10"><br></div>
            <div class="col-lg-2 text-right">
                <?= Dialog::widget(['overrideYiiConfirm' => true]);?>
                <?php
                if ($publicar) {
                    echo Html::a("Publicar", ['publicacao/create', 'id' => $model->id], ['data-confirm' => 'Deseja publicar esta sessão de treino?', 'class' => 'btn btn-primary']);
                }else{
                    echo Html::a("Publicado", ['publicacao/create', 'id' => $model->id], ['class' => 'btn btn-primary', 'disabled' => 'disabled']);
                }?>
            </div>
        </div>
    </div>
</div>
<script>
    if('<?= $model->rota?>' != "") {
        mapboxgl.accessToken = 'pk.eyJ1IjoiaXVyaWNhcnJhcyIsImEiOiJja3V3aDJrZWEwNjhuMm5xd3hqNHRuODdiIn0.Yztl8wZEMrxIlkEVwt1zgw';
        const map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [-9.259802, 39.091996],
            zoom: 13
        });

        map.on('load', () => {
            var array = polyline.toGeoJSON('<?= $model->rota?>', 6);


            map.addSource('route', {
                    'type': 'geojson',
                    'data': array
                }
            );
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
            console.log(array);
        });
    }
</script>