<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

?>
<div class="post">
    <br>
    <h3><strong><?= Html::encode($model->user->username) ?></strong><?= Html::encode($model->createtime) ?></h3>
    <p><?= HtmlPurifier::process($model->content) ?></p>
    <br>
</div>
