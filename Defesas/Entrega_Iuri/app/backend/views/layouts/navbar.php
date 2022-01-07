<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <!-- Esconder/Aparecer a sidebar-->
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <!-- Home -->
        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?= Url::home()?>" class="nav-link">Home</a>
        </li>
        <!-- Utilizadores -->
        <li class="nav-item d-none d-sm-inline-block">
            <?= Html::a('Utilizadores', ['user/index'], ['data-method' => 'post', 'class' => 'nav-link']) ?>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <?= Html::a('Cupões', ['cupoes/index'], ['data-method' => 'post', 'class' => 'nav-link']) ?>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Logout -->
        <li class="nav-item">
            <?= Html::a('<i class="fas fa-sign-out-alt"></i>', ['/site/logout'], ['data-method' => 'post', 'class' => 'nav-link']) ?>
        </li>
        <!-- Fullscreen -->
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->