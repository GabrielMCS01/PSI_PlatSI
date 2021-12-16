<?php

use common\models\User;
use hail812\adminlte\widgets\Menu;
use yii\helpers\Html;
use yii\helpers\Url;

$user = User::findOne(Yii::$app->user->getId())
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= Url::home()?>" class="brand-link">
        <img src="<?= Url::to('@web/img/ciclodias.png');?>" alt="<?= Yii::$app->name?>" class="brand-image img-circle" style="opacity: .8">
        <span class="brand-text font-weight-light"><?= Yii::$app->name?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="info">
                <?= Html::a($user->username, ['user/view', 'id' => $user->id], ['data-method' => 'post', 'class' => 'd-block']); ?>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php
            echo Menu::widget([
                'items' => [
                    ['label' => 'Home', 'url' => ['site/index'], 'icon' => 'home'],
                    ['label' => 'Utilizadores', 'url' => ['user/index'], 'icon' => 'user'],
                    ['label' => 'Yii2 PROVIDED', 'header' => true],
                    ['label' => 'Login', 'url' => ['site/login'], 'icon' => 'sign-in-alt', 'visible' => Yii::$app->user->isGuest],
                    ['label' => 'Gii',  'icon' => 'file-code', 'url' => ['/gii'], 'target' => '_blank'],
                    ['label' => 'Debug', 'icon' => 'bug', 'url' => ['/debug'], 'target' => '_blank'],
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>