<?php

namespace app\modules\v1\controllers;

use app\modules\v1\models\ResponseRegisto;
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

    // Registo do utilizador
    public function actionSignup(){
        $model = new SignupForm();

        // Preenche com os dados enviados do POST
        $model->username = Yii::$app->request->post('username');
        $model->email = Yii::$app->request->post('email');
        $model->password = Yii::$app->request->post('password');
        $model->primeiro_nome = Yii::$app->request->post('primeiro_nome');
        $model->ultimo_nome = Yii::$app->request->post('ultimo_nome');

        $response = new ResponseRegisto();

        // Caso o registo tenha sido feito com sucesso
        if ($model->signup()) {
            // É enviada uma resposta de registo feito com sucesso
            $response->success = true;
            return $response;
        }

        // É enviada uma resposta informando que houve erros a fazer o registo do utilizador
        $response->success = false;
        return $response;
    }

}
