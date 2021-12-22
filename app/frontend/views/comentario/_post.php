<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

?>
<div class="post">
    <br>
    <h3><strong><?= Html::encode($model->user->username) ?></strong></h3>
    <h4><?= HtmlPurifier::process($model->content) ?></h4>
    <?= Html::encode($model->createtime) ?>
    <br>
</div>
