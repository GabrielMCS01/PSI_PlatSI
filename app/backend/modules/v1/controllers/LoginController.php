<?php

namespace app\modules\v1\controllers;

use common\models\LoginForm;
use common\models\User;
use Yii;
use yii\rest\ActiveController;

/**
 * Default controller for the `v1` module
 */
class LoginController extends ActiveController
{
    public $modelClass = 'common\models\LoginForm';

    public function actions()
    {
        return array_merge(parent::actions(), [
            'create' => null, // Disable POST
            'view' => null, // Disable GET
            'update' => null, // Disable PUT
            'delete' => null, // Disable DELETE
        ]);
    }

    public function actionLogin()
    {
        // Recebe o authManager para verificar as permissões
        $auth = Yii::$app->authManager;

        // Cria uma instância do LoginForm
        $model = new LoginForm();

        // Recebe o Username e a password inserida
        $model->username = Yii::$app->request->post('username');
        $model->password = Yii::$app->request->post('password');

        // Valida os dados
        if($model->login()) {
            // Verifica se o utilizador tem acesso á aplicação (Frontend)
            if($auth->checkAccess(Yii::$app->user->getId(), "frontendAccess")){
                // Recebe o user que acabou de fazer login
                $user = User::findByUsername($model->username);

                // Gera um token e atribui no verification_token
                $user->auth_key = Yii::$app->security->generateRandomString();
                $user->save();
                
                $jsons = "{\"success\": \"true\", \"token\": \" $user->auth_key \"}";
                // Retorna o token
                return $jsons;
            }else{
                $message = "Utilizador sem acesso á aplicação";
            }
        }
        else{
            $message = "Utilizador inválido";
        }

        // Retorna a mensagem de erro
        return $message;
    }
}
