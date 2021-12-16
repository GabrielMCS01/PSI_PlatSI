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

                    foreach ($dataProvider as $datas) { ?>
                        <h3><?=$tipos_user[$i]?></h3>
                        <?php
                        echo GridView::widget([
                        'dataProvider' => $datas,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            'id',
                            'username',
                            'email:email',
                            /*[
                                'label' => 'Tipo de Utilizador',
                                'value' => function($data){
                                    return $data->authassignment->item_name;
                                },
                                'filterInputOptions' => ['prompt' => 'Todos os Roles', 'class' => 'form-control', 'id' => null],
                                'filter' => $tipos_user,
                            ],*/
                            //'auth_key',
                            //'password_hash',
                            //'password_reset_token',
                            //'status',
                            //'created_at',
                            //'updated_at',
                            //'verification_token',

                            ['class' => 'hail812\adminlte3\yii\grid\ActionColumn'],
                        ],
                        'summaryOptions' => ['class' => 'summary mb-2'],
                        'pager' => [
                            'class' => 'yii\bootstrap4\LinkPager',
                        ]
                    ]);
                    $i++;
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
