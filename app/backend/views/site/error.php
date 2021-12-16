<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
$this->params['breadcrumbs'] = [['label' => $this->title]];
?>
<div class="error-page">
    <div class="error-content" style="margin-left: auto;">
        <h3><i class="fas fa-exclamation-triangle text-danger"></i> <?= Html::encode($name) ?></h3>

        <p>
            <?= nl2br(Html::encode($message)) ?>
        </p>

        <p>
            Ocorreu um erro a carregar a página pretendida, esta poderá estar em baixo ou não existir, o link abaixo
            redirecionará para a página principal
            <?= Html::a(' Menu Principal', Yii::$app->homeUrl); ?>
        </p>
    </div>
</div>

