<?php

use common\utils\Converter;
use yii\bootstrap4\LinkPager;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $ciclismos */
/* @var $pagination */

$this->title = 'Histórico';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ciclismo-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Mostra cada treino feito pelo utilizador -->
    <?php foreach ($ciclismos as $ciclismo) { ?>
        <div class="jumbotron text-center">
            <h3><?= Html::a($ciclismo->nome_percurso, ['ciclismo/view', 'id' => $ciclismo->id], ['data-method' => 'post', 'class' => 'd-block']); ?></h3>
            <h5><?= $ciclismo->data_treino ?></h5>
            <div class="row">
                <div class="col-lg-6">
                    <strong>Duração: </strong><?= Converter::timeConverter($ciclismo->duracao) ?>
                    <br>
                    <strong>Distância: </strong><?= Converter::distanceConverter($ciclismo->distancia) ?>
                </div>
                <div class="col-lg-6">
                    <strong>Velocidade Média: </strong> <?= Converter::velocityConverter($ciclismo->velocidade_media) ?>
                    <br>
                    <strong>Velocidade Máxima: </strong><?= Converter::velocityConverter($ciclismo->velocidade_maxima) ?>
                </div>
            </div>
        </div>
    <?php } ?>

    <?= LinkPager::widget(['pagination' => $pagination]) ?>
</div>
