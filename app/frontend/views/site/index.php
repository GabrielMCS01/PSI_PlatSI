<?php

/* @var $this yii\web\View */

$this->title = Yii::$app->name;
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent">
        
        <img src="/../../assets/ciclodias_logo_transparent.png" width="200px">
        <h1 class="display-4">Bem-Vindo ao Ciclodias</h1>

        <p class="lead">Aplicação de monitorização de exercicio fisico</p>

        <!-- <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Crie uma conta ou inicie sessão</a></p> -->
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h3>TOP 10 - Distancia</h3>
                <ol>
                    <li>Gabriel - 45.72 km</li>
                    <li>Iuri - 34.98 km</li>
                    <li>Dias - 12.64 km</li>
                    <li>...</li>
                </ol>

            </div>
            <div class="col-lg-4">
                <h3>TOP 10 - Tempo</h3>
                <ol>
                    <li>Fabio - 02:45:12 h</li>
                    <li>Gabriel - 01:52:51 h</li>
                    <li>Dias - 00:56:23 h</li>
                    <li>...</li>
                </ol>

            </div>
            <div class="col-lg-4">
                <h3>TOP 10 - Velocidade Média</h3>
                <ol>
                    <li>Iuri - 24.42 km/h</li>
                    <li>Gabriel - 23.72 km/h</li>
                    <li>Fábio - 19.64 km/h</li>
                    <li>...</li>
                </ol>
            </div>
        </div>

    </div>
</div>
