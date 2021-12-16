<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        Ocorreu um erro a carregar a página pretendida, esta poderá estar em baixo ou não existir, o link abaixo
        redirecionará para a página principal
        <?= Html::a(', (Menu Principal)', Yii::$app->homeUrl); ?>
    </p>

</div>
