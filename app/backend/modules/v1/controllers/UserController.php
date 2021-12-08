<?php

namespace app\modules\v1\controllers;

use app\modules\v1\models\ResponsePerfil;
use common\models\User;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;

/**
 * Default controller for the `v1` module
 */
class UserController extends ActiveController
{
    public $modelClass = 'common\models\User';

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
        $user = User::findOne($id);

        // Verifica se o utilizador que acede é o mesmo que este está a chamar os dados e se tem a permissão
        if(Yii::$app->user->can('viewProfile', ['user' => $user])){

            $response = new ResponsePerfil();

            $response->primeiro_nome = $user->userinfo->primeiro_nome;
            $response->ultimo_nome = $user->userinfo->ultimo_nome;
            $response->data_nascimento = $user->userinfo->data_nascimento;

            return $response;
        }
        else{
            return "O utilizador não tem permissões para visualizar outros utilizadores";
        }
    }

    // Atualiza o próprio utilizador
    public function actionUpdate($id){
        $user = User::findOne($id);

        // Verifica se o user tem a permissão para fazer atualizações e se está a alterar o seu próprio perfil
        if(Yii::$app->user->can('updateProfile', ['user' => $user])) {
            // Recebe os dados enviados e atualiza-os
            // Verificar se o email é válido
            $user->username = Yii::$app->request->post('username');
            $user->userinfo->primeiro_nome = Yii::$app->request->post('primeiro_nome');
            $user->userinfo->ultimo_nome = Yii::$app->request->post('ultimo_nome');
            $user->userinfo->data_nascimento = Yii::$app->request->post('data_nascimento');

            // Guarda as alterações do utilizador e das informações deste
            $user->save();
            $user->userinfo->save();

            return $user;
        }
        else return "O utilizador não tem permissões para atualizar outros utilizadores";
    }

    // Apaga o utilizador com o login feito
    public function actionDelete($id){
        $user = User::findOne($id);

        // Verifica se o user tem a permissão para apagar perfis e se está a apagar o seu próprio perfil
        if(Yii::$app->user->can('deleteProfile', ['user' => $user])) {
            // Apaga os dados da chave estrangeira
            $user->userinfo->delete();
            $user->delete();

            $user = null;

            if ($user == null) return "Utilizador apagado com sucesso";
            else return "Erro ao apagar utilizador";
        }
        else{
            return "O utilizador não tem permissões para apagar outros utilizadores";
        }
    }
}
