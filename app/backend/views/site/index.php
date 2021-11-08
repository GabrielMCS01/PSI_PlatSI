<?php

use hail812\adminlte\widgets\InfoBox;
use hail812\adminlte\widgets\Ribbon;
use hail812\adminlte\widgets\SmallBox;
use yii\helpers\Html;

$this->title = Yii::$app->name;
$this->params['breadcrumbs'] = [['label' => $this->title]];
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 col-sm-6 col-12">
            <?= InfoBox::widget([
                'text' => 'Tempo atividade física',
                'number' => '10:24:36 H',
                'icon' => 'far fa-clock',
            ]) ?>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <?= InfoBox::widget([
                'text' => 'Quilometros Percorridos',
                'number' => '231 KM',
               //  'theme' => 'success',
                'icon' => 'fas fa-road',
            ]) ?>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <?= InfoBox::widget([
                'text' => 'Velocidade média',
                'number' => '20,94 Km/h',
             //   'theme' => 'gradient-warning',
                'icon' => 'fas fa-tachometer-alt',
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 col-sm-6 col-12">
            <?= InfoBox::widget([
                'text' => 'Nº de sessões de treino',
                'number' => '11',
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
                'title' => '2',
                'text' => 'Utilizadores Registados',
                'icon' => 'fas fa-user-plus',
                'theme' => 'gradient-success',
                'linkText' => 'Ver os utilizadores',
                'linkUrl' => 'index.php?r=user%2Findex',
            ]) ?>
        </div>
    </div>
</div>