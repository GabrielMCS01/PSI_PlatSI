<?php

namespace app\modules\v1\controllers;

use common\models\User;
use common\models\UserInfo;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;

/**
 * Default controller for the `v1` module
 */
class UserController extends ActiveController
{
    public $modelClass = 'common\models\User';
    public $modelUserInfo = 'common\models\Userinfo';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
        ];
        return $behaviors;
    }

    // Permite a reescrita de métodos e apagar os desnecessários
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['view']);
        unset($actions['update']);
        unset($actions['delete']);
        $actions['create'] = null;
        $actions['index'] = null;

        return $actions;
    }

    // Mostra o próprio utilizador
    public function actionView($id){
        // Recebe o authManager para verificar as permissões
        $auth = Yii::$app->authManager;
        $user = User::findOne($id);

        // Verifica se o utilizador tem acesso á aplicação (Frontend)
        /*if($auth->checkAccess(Yii::$app->user->getId(), "frontendAccess")){
            // Verifica se o utilizador que acede é o mesmo que este está a chamar os dados
            if(Yii::$app->user->getId() == $id) {
                // Recebe o utilizador com o login feito
                $user = User::findOne($id);

                return $user;
            }
            else{
                return "O utilizador não tem permissões para visualizar outros utilizadores";
            }
        }else{
            return "Utilizador sem acesso á aplicação";
        }*/

        if(Yii::$app->user->can('viewProfile', ['user' => $user])){
            return $user;
        }
        else{
            return "O utilizador não tem permissões para visualizar outros utilizadores";
        }
    }

    // Atualiza o próprio utilizador
    public function actionUpdate($id){
        // Recebe o authManager para verificar as permissões
        $auth = Yii::$app->authManager;

        // Verifica se o utilizador tem acesso á aplicação (Frontend)
        if($auth->checkAccess(Yii::$app->user->getId(), "frontendAccess")){
            // Verifica se o utilizador que acede é o mesmo que este está a chamar os dados
            if(Yii::$app->user->getId() == $id) {
                // Recebe o user com o login feito
                $user = User::findOne($id);

                // Recebe as outras informações do utilizador encontrado anteriormente
                $userinfo = $user->userinfo;

                // Recebe os dados enviados e atualiza-os
                // Verificar se o email é válido
                $user->username = Yii::$app->request->post('username');
                $userinfo->primeiro_nome = Yii::$app->request->post('primeiro_nome');
                $userinfo->ultimo_nome = Yii::$app->request->post('ultimo_nome');
                $userinfo->data_nascimento = Yii::$app->request->post('data_nascimento');

                $user->save();
                $userinfo->save();

                return $userinfo;
            }
            else{
                return "O utilizador não tem permissões para atualizar outros utilizadores";
            }
        }else{
            return "Utilizador sem acesso á aplicação";
        }
    }


    // Mostra o proprio utilizador
    public function actionDelete($id){
        // Recebe o authManager para verificar as permissões
        $auth = Yii::$app->authManager;

        // Verifica se o utilizador tem acesso á aplicação (Frontend)
        if($auth->checkAccess(Yii::$app->user->getId(), "frontendAccess")){
            // Verifica se o utilizador que acede é o mesmo que este está a chamar os dados
            if(Yii::$app->user->getId() == $id) {
                // Apaga o utilizador com o login feito
                $user = User::findOne($id);
                $userinfo = $user->userinfo;

                $userinfo->delete();
                $user->delete();

                $user = null;
                $userinfo = null;

                if ($user == null && $userinfo == null) return "Utilizador apagado com sucesso";
                else return "Erro ao apagar utilizador";

            }
            else{
                return "O utilizador não tem permissões para apagar outros utilizadores";
            }
        }else{
            return "Utilizador sem acesso á aplicação";
        }
    }
}
