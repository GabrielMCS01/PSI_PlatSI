<?php

use common\utils\Converter;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var this $ciclismos */

$this->title = 'Historico de Sessões de Treino';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ciclismo-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
    </p>

    <?php foreach ($ciclismos as $ciclismo){ ?>
    <div class="jumbotron text-center">
        <h3><?= $ciclismo->nome_percurso;?></h3>
        <h5><?=$ciclismo->data_treino?></h5>
        <div class="row">
            <div class="col-lg-6">
            <ul>
                <li><strong>Tempo: </strong><?= Converter::secondsToHours($ciclismo->duracao)?></li>
                <li><strong>Distancia: </strong><?= $ciclismo->duracao?></li>
            </ul>
            </ul>
            </div>
            <div class="col-lg-6">
                <ul>
                    <li><strong>Velocidade Média: </strong> <?=$ciclismo->velocidade_media?></li>
                    <li><strong>Velocidade Máxima: </strong><?=$ciclismo->velocidade_maxima?></li>
                </ul>
            </div>
        </div>
    </div>
    <?php }?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php /*GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nome_percurso',
            'duracao',
            'distancia',
            'velocidade_media',
            //'velocidade_maxima',
            //'velocidade_grafico:ntext',
            //'rota:ntext',
            //'data_treino',
            //'user_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);*/ ?>


</div>
