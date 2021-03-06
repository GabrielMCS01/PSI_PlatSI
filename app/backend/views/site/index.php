<?php

use common\utils\Converter;
use hail812\adminlte\widgets\InfoBox;
use hail812\adminlte\widgets\SmallBox;

// Variáveis que veêm do controller
/* @var $tempoTotal  */
/* @var $distancia  */
/* @var $velMedia  */
/* @var $numUsers  */
/* @var $numTreinos  */
/* @var $numPublicacoes  */
/* @var $numGostos  */
/* @var $numComentarios  */

$this->title = Yii::$app->name;
$this->params['breadcrumbs'] = [['label' => "Informações da aplicação Ciclodias"]];
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 col-sm-6 col-12">
            <?= InfoBox::widget([
                'text' => 'Tempo de atividade física',
                'number' => Converter::timeConverter($tempoTotal),
                'icon' => 'far fa-clock',
            ]) ?>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <?= InfoBox::widget([
                'text' => 'Quilómetros Percorridos',
                'number' => Converter::distanceConverter($distancia),
                'icon' => 'fas fa-road',
            ]) ?>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <?= InfoBox::widget([
                'text' => 'Velocidade média',
                'number' => Converter::velocityConverter($velMedia),
                'icon' => 'fas fa-tachometer-alt',
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 col-sm-6 col-12">
            <?= InfoBox::widget([
                'text' => 'Sessões de treino',
                'number' => $numTreinos,
                'icon' => 'fas fa-bicycle',
            ]) ?>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <?= InfoBox::widget([
                'text' => 'Publicações',
                'number' => $numPublicacoes,
                'icon' => 'fas fa-blog',
            ]) ?>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <?= InfoBox::widget([
                'text' => 'Gostos nas publicações',
                'number' => $numGostos,
                'icon' => 'fas fa-thumbs-up',
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 col-sm-6 col-12">
            <?= InfoBox::widget([
                'text' => 'Comentários nas publicações',
                'number' => $numComentarios,
                'icon' => 'fas fa-comments',
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <?= SmallBox::widget([
                'title' => $numUsers,
                'text' => 'Utilizadores Registados',
                'icon' => 'fas fa-user-plus',
                'theme' => 'gradient-success',
                'linkText' => 'Ver todos os utilizadores',
                'linkUrl' => 'user/index',
            ]) ?>
        </div>
    </div>
</div>