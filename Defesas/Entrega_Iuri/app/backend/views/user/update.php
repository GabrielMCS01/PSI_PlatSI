<?php

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $roles */
/* @var $role_name */
/* @var $user_info */
/* @var $auth_model */

$this->title = 'Atualizar Utilizador: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'User', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?=$this->render('_form', [
                        'model' => $model, 'auth_model' => $auth_model, 'role_name' => $role_name, 'user_info' => $user_info, 'roles' => $roles
                    ]) ?>
                </div>
            </div>
        </div>
        <!--.card-body-->
    </div>
    <!--.card-->
</div>