<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

?>
<div class="post">
    <br>
    <h3><strong><?= Html::encode($model->user->username) ?></strong></h3>
    <?= Html::encode($model->createtime) ?>
    <p><?= HtmlPurifier::process($model->content) ?></p>
    <br>
</div>
