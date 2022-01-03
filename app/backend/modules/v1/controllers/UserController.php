<?php

namespace app\modules\v1\controllers;

use app\modules\v1\models\ResponseDeletePerfil;
use app\modules\v1\models\ResponsePerfil;
use app\modules\v1\models\ResponseUpdatePerfil;
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

        // Verifica se o utilizador que acede é o mesmo que este chama os dados e se tem a permissão
        if(Yii::$app->user->can('viewProfile', ['user' => $user])){
            // Preenche a resposta com os dados do perfil
            $response = new ResponsePerfil();

            $response->primeiro_nome = $user->userinfo->primeiro_nome;
            $response->ultimo_nome = $user->userinfo->ultimo_nome;
            if($user->userinfo->data_nascimento == null){
                $response->data_nascimento = "nulo";
            }else {
                $response->data_nascimento = $user->userinfo->data_nascimento;
            }
            return $response;
        }
        else{
            return "O utilizador não tem permissões para visualizar outros utilizadores";
        }
    }

    // Atualiza o próprio utilizador
    public function actionUpdate($id){
        $user = User::findOne($id);

        // Verifica se o user tem a permissão para fazer atualizações e se altera o seu próprio perfil
        if(Yii::$app->user->can('updateProfile', ['user' => $user])) {
            // Recebe os dados enviados e atualiza-os
            // Verificar se o email é válido
            $user->userinfo->primeiro_nome = Yii::$app->request->post('primeiro_nome');
            $user->userinfo->ultimo_nome = Yii::$app->request->post('ultimo_nome');
            // Formata a string para data
            $date = strtotime(Yii::$app->request->post('data_nascimento'));
            $user->userinfo->data_nascimento = date("Y-m-d", $date);

            $response = new ResponseUpdatePerfil();

            // Verifica se os novos dados estão válidos
            if($user->validate() && $user->userinfo->validate()) {
                // Guarda as alterações do utilizador
                $user->save();
                $user->userinfo->save();

                // Envia uma resposta de sucesso
                $response->success = true;
            }else{
                // Envia uma resposta de erro
                $response->success = false;
            }

            return $response;
        }
        else return "O utilizador não tem permissões para atualizar outros utilizadores";
    }

    // Apaga o utilizador com o login feito
    public function actionDelete($id){
        $user = User::findOne($id);

        // Verifica se o user tem a permissão o seu próprio perfil
        if(Yii::$app->user->can('deleteProfile', ['user' => $user])) {
            // Apaga os dados da chave estrangeira
            $user->userinfo->delete();
            $user->delete();

            // Verifica se o utilizador foi apagado
            $user = User::findOne($id);

            $response = new ResponseDeletePerfil();

            // Se nenhum utilizador foi encontrado, retorna sucesso
            if ($user == null) $response->success = true;
            else $response->success = false;

            return $response;
        }
        else{
            return "O utilizador não tem permissões para apagar outros utilizadores";
        }
    }
}
