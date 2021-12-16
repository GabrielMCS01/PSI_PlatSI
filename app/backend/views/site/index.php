<?php

use common\utils\Converter;
use hail812\adminlte\widgets\InfoBox;
use hail812\adminlte\widgets\SmallBox;
use yii\helpers\Html;

// Variáveis que veêm do controller
/* @var $tempoTotal  */
/* @var $distancia  */
/* @var $velMedia  */
/* @var $numUsers  */
/* @var $numTreinos  */
$this->title = Yii::$app->name;
$this->params['breadcrumbs'] = [['label' => "Informações da aplicação Ciclodias"]];
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 col-sm-6 col-12">
            <?= InfoBox::widget([
                'text' => 'Tempo de atividade física',
                'number' => Converter::secondsToHours($tempoTotal),
                'icon' => 'far fa-clock',
            ]) ?>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <?= InfoBox::widget([
                'text' => 'Quilometros Percorridos',
                'number' => $distancia . " KM",
               //  'theme' => 'success',
                'icon' => 'fas fa-road',
            ]) ?>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <?= InfoBox::widget([
                'text' => 'Velocidade média',
                'number' => $velMedia . " Km/h",
             //   'theme' => 'gradient-warning',
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
                /*'progress' => [
                    'width' => '70%',
                    'description' => '70% Increase in 30 Days'
                ]*/
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