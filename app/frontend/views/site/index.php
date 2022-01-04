<?php

/* @var $this yii\web\View */
/* @var $velocidademed  */
/* @var $distancias  */
/* @var $tempos  */

use common\utils\Converter;
use yii\helpers\Url;

$this->title = Yii::$app->name;
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent">
        
        <img src="<?= Url::to('@web/img/ciclodias.png');?>" width="200px">
        <h1 class="display-4">Bem-Vindo ao Ciclodias</h1>

        <p class="lead">Aplicação de monitorização de exercício físico</p>
    </div>

    <div class="body-content">
        <div class="row">
            <div class="col-lg-4">
                <!-- Mostra o top 10 (tabela de classificação) da distância -->
                <h3>TOP 10 - Distância</h3>
                <ol>
                    <?php foreach ($distancias as $distancia){?>
                    <li><?= $distancia->user->username?> - <?= Converter::distanceConverter($distancia->distancia)?></li>
                    <?php }?>
                </ol>

            </div>
            <div class="col-lg-4">
                <!-- Mostra o top 10 (tabela de classificação) da duração -->
                <h3>TOP 10 - Duração</h3>
                <ol>
                    <?php foreach ($tempos as $tempo){?>
                    <li><?= $tempo->user->username?> - <?= Converter::timeConverter($tempo->duracao)?></li>
                    <?php }?>
                </ol>

            </div>
            <div class="col-lg-4">
                <!-- Mostra o top 10 (tabela de classificação) da velocidade média -->
                <h3>TOP 10 - Velocidade Média</h3>
                <ol>
                    <?php foreach ($velocidademed as $velocidade){?>
                    <li><?=$velocidade->user->username?> - <?= Converter::velocityConverter($velocidade->velocidade_media)?></li>
                    <?php }?>
                </ol>
            </div>
        </div>

    </div>
</div>
