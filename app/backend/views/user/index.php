<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $roles */

$this->title = 'Utilizadores';
$this->params['breadcrumbs'][] = $this->title;

for ($i = 0; $i < count($roles); $i++){
    // Nome de cada role
    $tipos_user[$i] = $roles[$i]->name;
}
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                    </div>

                    <?php
                    $i = 0;

                    // Para cada tipo de utilizador (Adapta-se ao número de utilizadores)
                    foreach ($dataProvider as $data) { ?>
                        <!-- Destaca o tipo de utilizador !-->
                        <h3 style="text-transform: capitalize;"><strong><?=$tipos_user[$i]?></strong></h3>
                        <?php
                        // Preenche a grid
                        echo GridView::widget([
                        'dataProvider' => $data,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            'id',
                            'username',
                            'email:email',

                            ['class' => 'hail812\adminlte3\yii\grid\ActionColumn'],
                        ],
                        'summaryOptions' => ['class' => 'summary mb-2'],
                        'pager' => [
                            'class' => 'yii\bootstrap4\LinkPager',
                        ]
                    ]);?>
                    <br>
                    <?php $i++;
                    }?>
                </div>
                <!--.card-body-->
            </div>
            <!--.card-->
        </div>
        <!--.col-md-12-->
    </div>
    <!--.row-->
</div>
