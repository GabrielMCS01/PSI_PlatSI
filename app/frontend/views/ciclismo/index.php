<?php

use common\utils\Converter;
use yii\bootstrap4\LinkPager;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $ciclismos */
/* @var $pagination */

$this->title = 'Historico';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ciclismo-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php foreach ($ciclismos as $ciclismo) { ?>
        <div class="jumbotron text-center">
            <h3><?= Html::a($ciclismo->nome_percurso, ['ciclismo/view', 'id' => $ciclismo->id], ['data-method' => 'post', 'class' => 'd-block']); ?></h3>
            <h5><?= $ciclismo->data_treino ?></h5>
            <div class="row">
                <div class="col-lg-6">
                    <strong>Tempo: </strong><?= Converter::secondsToHours($ciclismo->duracao) ?>
                    <br>
                    <strong>Distancia: </strong><?= $ciclismo->distancia ?>
                    </ul>
                </div>
                <div class="col-lg-6">
                    <strong>Velocidade Média: </strong> <?= $ciclismo->velocidade_media ?>
                    <br>
                    <strong>Velocidade Máxima: </strong><?= $ciclismo->velocidade_maxima ?>
                </div>
            </div>
        </div>
    <?php } ?>

    <?= LinkPager::widget(['pagination' => $pagination]) ?>
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

    <!-- <div class="jumbotron text-center" style="width: 80%; margin: auto;"> -->

</div>
