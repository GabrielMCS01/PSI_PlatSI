<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

?>
<div class="post">
    <h3><strong><?= Html::encode($model->user->username) ?></strong></h3>
    <h5><?= HtmlPurifier::process($model->content) ?></h5>
    <?= Html::encode($model->createtime) ?>
    <br>
    <br>
    <br>
</div>
