<?php

namespace app\modules\v1\controllers;

use app\modules\v1\models\ResponseRegisto;
use common\models\UserInfo;
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
        $model->primeiro_nome = Yii::$app->request->post('primeiro_nome');
        $model->ultimo_nome = Yii::$app->request->post('ultimo_nome');


        $response = new ResponseRegisto();

        if ($model->signup()) {
            $response->success = true;
            return $response;
        }

        $response->success = false;
        return $response;
    }

}
