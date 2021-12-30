<?php

use common\models\Gosto;
use common\utils\Converter;
use hail812\adminlte3\assets\FontAwesomeAsset;
use kartik\dialog\Dialog;
use yii\bootstrap4\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $publicacoes */
/* @var $pagination */

$this->title = 'Suas Publicações';
$this->params['breadcrumbs'][] = $this->title;
FontAwesomeAsset::register($this);

$this->registerJsFile("@web/@mapbox/polyline/src/polyline.js", ['depends' => [\yii\web\JqueryAsset::className()]]);

$this->registerJs("
     console.log('henlo');
         $('.pjax-like-link').on('click', function(e) {
             console.log('henlo');
             e.preventDefault();
             var likeUrl = $(this).attr('like-url');
             var colorEdit = $(this);
             var pjaxContainer = $(this).attr('pjax-container');                                
                 $.ajax({
                     url: likeUrl,
                     type: 'post',
                     error: function(xhr, status, error) {
                         alert('There was an error with your request.' + xhr.responseText);
                     }
                 }).done(function(data) {
                    if(data.create){
                     colorEdit.css('color', 'red');
                     console.log('gosto posto');
                     }else{
                     colorEdit.css('color', 'green');
                     console.log('gosto retirado');
                     }
                 });
         });

 ", View::POS_READY);


?>
<style>
    .fas {
        font-size: 40px;
        cursor: pointer;
        user-select: none;
    }

    .fas:hover {
        color: darkblue;
    }
</style>

<script>  var map = [];
    var j = 0;
</script>
<div class="publicacao-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php foreach ($publicacoes

                   as $publicacao) { ?>
        <div class="jumbotron text-center">
            <h3><?= $publicacao->ciclismo->nome_percurso ?></h3>
            <h5><?= $publicacao->ciclismo->data_treino ?></h5>
            <div id='map' style='height: 300px;'>
                <?php
                if ($publicacao->ciclismo->rota == "") {
                    echo "<p>SEM ROTA</p>";
                }
                ?>
                <script>
                    var divElts = document.getElementById("map");
                    divElts.setAttribute('id', "map" + <?=$publicacao->id?>);
                    if ('<?= $publicacao->ciclismo->rota?>' != "") {
                        mapboxgl.accessToken = 'pk.eyJ1IjoiaXVyaWNhcnJhcyIsImEiOiJja3V3aDJrZWEwNjhuMm5xd3hqNHRuODdiIn0.Yztl8wZEMrxIlkEVwt1zgw';
                        map[<?= $publicacao->id?>] = new mapboxgl.Map({
                            container: 'map' + <?= $publicacao->id?>,
                            style: 'mapbox://styles/mapbox/streets-v11',
                            center: [-122.486052, 37.830348],
                            zoom: 14
                        }).on('load', () => {

                            var geoJSON = polyline.toGeoJSON('<?= $publicacao->ciclismo->rota?>', 6);

                            var getCenter = polyline.decode('<?= $publicacao->ciclismo->rota?>', 6);

                            var index = getCenter.length / 2;
                            var centerPoint = getCenter[index.toFixed(0)];


                            map[<?= $publicacao->id?>].setCenter([centerPoint[1], centerPoint[0]], null);

                            map[<?= $publicacao->id?>].addSource('id' + j, {
                                'type': 'geojson',
                                'data': geoJSON
                            });
                            map[<?= $publicacao->id?>].addLayer({
                                'id': 'id' + j,
                                'type': 'line',
                                'source': 'id' + j,
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
                    }
                </script>
            </div>
            <br>
            <div class="row">
                <div class="col-lg-6">
                    <strong>Tempo: </strong><?= Converter::timeConverter($publicacao->ciclismo->duracao) ?>
                    <br>
                    <strong>Distancia: </strong><?= Converter::distanceConverter($publicacao->ciclismo->distancia) ?>
                    </ul>
                </div>
                <div class="col-lg-6">
                    <strong>Velocidade
                        Média: </strong> <?= Converter::velocityConverter($publicacao->ciclismo->velocidade_media) ?>
                    <br>
                    <strong>Velocidade
                        Máxima: </strong><?= Converter::velocityConverter($publicacao->ciclismo->velocidade_maxima) ?>
                </div>
            </div>
            <br>
            <br>
            <?php Pjax::begin(['id' => 'my_pjax']);
            $options = ['pjax-container' => 'my_pjax', 'like-url' => Url::to(['gosto/gosto', 'id' => $publicacao->id]), 'class' => 'fas fa-heart pjax-like-link'];
            if (Gosto::find()->where(['publicacao_id' => $publicacao->id, 'user_id' => Yii::$app->user->getId()])->one() != null) {
                Html::addCssStyle($options, 'color: red;');
            }
            ?>
            <div class="row">
                <div class="col-lg-3">
                    <?php Dialog::widget(['overrideYiiConfirm' => true]);
                    echo Html::a("Apagar Publicação", ['delete', 'id' => $publicacao->id], [
                            'class' => 'btn btn-danger',
                            'data-confirm' => 'Deseja remover a publicação desta sessão de treino?',
                            'data-method' => 'post',
                            'data-pjax' => 0]); ?>
                </div>
                <div class="col-lg-5">
                </div>
                <div class="col-lg-2 text-right">
                    <?= Html::a('', false, $options); ?>

                    <?php $gostos = Gosto::find()->where(["publicacao_id" => $publicacao->id])->count();
                    if ($gostos == 1) { ?>
                        <h6><?= $gostos ?> Gosto </h6>
                    <?php } else if ($gostos > 1) { ?>
                        <h6><?= $gostos ?> Gostos </h6>
                    <?php } ?>
                </div>
                <div class="col-lg-2 text-right">
                    <?= Html::a('Ver Comentarios', ['comentario/indexpost', 'id' => $publicacao->id], ['class' => 'btn btn-primary', 'data-pjax' => 0]) ?>
                </div>
            </div>
            <?php Pjax::end(); ?>
        </div>
    <?php } ?>
    <?= LinkPager::widget(['pagination' => $pagination]) ?>
</div>


