<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ComentarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Comentarios';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="comentario-index">

        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a('Criar Comentario', ['create', 'id' => $id], ['class' => 'btn btn-success']) ?>
        </p>

        <?php Pjax::begin(); ?>
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_post',
        ]) ?>

        <?php Pjax::end(); ?>

    </div>
<?php
