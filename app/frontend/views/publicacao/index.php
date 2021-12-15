<?php

use common\models\Gosto;
use common\utils\Converter;
use hail812\adminlte3\assets\FontAwesomeAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $publicacoes */
/* @var $pagination */

$this->title = 'Publicações';
$this->params['breadcrumbs'][] = $this->title;
FontAwesomeAsset::register($this);


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
        <h3><?= Html::a($publicacao->ciclismo->nome_percurso, ['ciclismo/view', 'id' => $publicacao->ciclismo->id], ['data-method' => 'post', 'class' => 'd-block']); ?></h3>
        <h5><?= $publicacao->ciclismo->data_treino ?></h5>
        <div id='map' style='height: 300px;'>
            <script>
                var divElts = document.getElementById("map");
                divElts.setAttribute('id', "map" + <?=$publicacao->id?>);


                mapboxgl.accessToken = 'pk.eyJ1IjoiaXVyaWNhcnJhcyIsImEiOiJja3V3aDJrZWEwNjhuMm5xd3hqNHRuODdiIn0.Yztl8wZEMrxIlkEVwt1zgw';
                map[<?= $publicacao->id?>] = new mapboxgl.Map({
                    container: 'map' + <?= $publicacao->id?>,
                    style: 'mapbox://styles/mapbox/streets-v11',
                    center: [-122.486052, 37.830348],
                    zoom: 14
                }).on('load', () => {
                    map[<?= $publicacao->id?>].addSource('id' + j, {
                        'type': 'geojson',
                        'data': {
                            'type': 'Feature',
                            'properties': {},
                            'geometry': {
                                'type': 'LineString',
                                'coordinates': [
                                    [-122.483696, 37.833818],
                                    [-122.483482, 37.833174],
                                    [-122.483396, 37.8327],
                                    [-122.483568, 37.832056],
                                    [-122.48404, 37.831141],
                                    [-122.48404, 37.830497],
                                    [-122.483482, 37.82992],
                                    [-122.483568, 37.829548],
                                    [-122.48507, 37.829446],
                                    [-122.4861, 37.828802],
                                    [-122.486958, 37.82931],
                                    [-122.487001, 37.830802],
                                    [-122.487516, 37.831683],
                                    [-122.488031, 37.832158],
                                    [-122.488889, 37.832971],
                                    [-122.489876, 37.832632],
                                    [-122.490434, 37.832937],
                                    [-122.49125, 37.832429],
                                    [-122.491636, 37.832564],
                                    [-122.492237, 37.833378],
                                    [-122.493782, 37.833683]
                                ]
                            }
                        }
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
            </script>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-6">
                <strong>Tempo: </strong><?= Converter::secondsToHours($publicacao->ciclismo->duracao) ?>
                <br>
                <strong>Distancia: </strong><?= $publicacao->ciclismo->duracao ?>
                </ul>
            </div>
            <div class="col-lg-6">
                <strong>Velocidade Média: </strong> <?= $publicacao->ciclismo->velocidade_media ?>
                <br>
                <strong>Velocidade Máxima: </strong><?= $publicacao->ciclismo->velocidade_maxima ?>
            </div>
        </div>
        <br>
        <br>
        <?php Pjax::begin(['id' => 'my_pjax']);
        $options = ['pjax-container' => 'my_pjax', 'like-url' => Url::to(['gosto/gosto', 'id' => $publicacao->id]), 'class' => 'fas fa-heart pjax-like-link'];
        if (Gosto::find()->where(['publicacao_id' => $publicacao->id, 'user_id' => Yii::$app->user->getId()])->one() != null) {
            echo "<script>console.log('bonjour')</script>";
            Html::addCssStyle($options, 'color: red;');
        }
        ?>
        <div class="row">
            <div class="col-lg-9"
            "><br></div>
        <div class="col-lg-1 text-right">
            <?= Html::a('', false, $options); ?></div>
        <div class="col-lg-2 text-right"><?= Html::a('Ver Comentarios', false, ['class' => 'btn btn-primary']) ?></div>
    </div>
    <?php Pjax::end(); ?>
</div>
    </div>

<?php } ?>
</div>

<script>
    function myFunction(x) {
        //x.classList.toggle("fa-thumbs-down");
        if (x.style.color == "red") {
            x.style.color = "black";
        } else {
            x.style.color = "red";
        }
    }</script>
