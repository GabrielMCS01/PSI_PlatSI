<?php

namespace app\modules\v1\controllers;

use common\models\LoginForm;
use Yii;
use yii\rest\ActiveController;

/**
 * Default controller for the `v1` module
 */
class LoginController extends ActiveController
{
    public $modelClass = 'common\models\LoginForm';

    public function actionLogin()
    {
        //$auth = Yii::$app->authManager;

        $model = new LoginForm();

        $model->username = Yii::$app->request->post('username');
        $model->password = Yii::$app->request->post('password');

        if ($model->login()) {
            /*if($auth->checkAccess(Yii::$app->user->getId(), "frontendAccess")){
                return $this->goBack();
            }else{
                $message = "Utilizador sem acesso á frontend";
                echo "<script type='text/javascript'>alert('$message');</script>";

                Yii::$app->user->logout();
            }*/


            return "Banana Entrou";
        }

        $model->password = '';

        return "Banana não entrou";
    }
}
