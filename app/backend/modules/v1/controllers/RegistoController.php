<?php

namespace app\modules\v1\controllers;

use frontend\models\SignupForm;
use Yii;
use yii\rest\ActiveController;

/**
 * Default controller for the `v1` module
 */
class RegistoController extends ActiveController
{
    public $modelClass = 'frontend\models\SignupForm';

    public function actions()
    {
        return array_merge(parent::actions(), [
            'create' => null, // Disable POST
            'view' => null, // Disable GET
            'update' => null, // Disable PUT
            'delete' => null, // Disable DELETE
        ]);
    }

    public function actionSignup(){
        $model = new SignupForm();

        $model->username = Yii::$app->request->post('username');
        $model->email = Yii::$app->request->post('email');
        $model->password = Yii::$app->request->post('password');

        if ($model->signup()) {
            return "Utilizador criado com sucesso";
        }

        return "Erro ao criar utilizador";
    }

}
