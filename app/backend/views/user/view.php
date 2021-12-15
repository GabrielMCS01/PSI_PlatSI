<?php

use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $role_name */
/* @var $user_info */


$this->title = "Utilizador: $model->username";
$this->params['breadcrumbs'][] = ['label' => 'User', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <p>
                        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Pretende apagar este utilizador?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </p>
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'username',
                            [
                                'label' => 'Primeiro Nome',
                                'value' => $user_info->primeiro_nome,
                            ],
                            [
                                'label' => 'Ultimo Nome',
                                'value' => $user_info->ultimo_nome,
                            ],
                            [
                                'label' => 'Data de Nascimento',
                                'value' => $user_info->data_nascimento,
                            ],
                            'email:email',
                            [
                                'label' => 'Tipo de Utilizador',
                                'value' => $model->authassignment->item_name,
                            ],
                        ],
                    ]) ?>
                </div>
                <!--.col-md-12-->
            </div>
            <!--.row-->
        </div>
        <!--.card-body-->
    </div>
    <!--.card-->
</div>