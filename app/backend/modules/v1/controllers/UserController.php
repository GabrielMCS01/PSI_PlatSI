<?php

namespace app\modules\v1\controllers;

use app\modules\v1\models\ResponsePerfil;
use common\models\Ciclismo;
use common\models\Comentario;
use common\models\Gosto;
use common\models\Publicacao;
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
    public function actionView($id)
    {
        $user = User::findOne($id);


        if ($user == null) {
            $response = new ResponsePerfil();

            $response->success = false;
            $response->mensagem = "Não existe um utilizador com esse ID";
            return $response;
        }

        // Verifica se o utilizador que acede é o mesmo que este chama os dados e se tem a permissão
        if (Yii::$app->user->can('viewProfile', ['user' => $user])) {
            // Preenche a resposta com os dados do perfil
            $response = new ResponsePerfil();

            $response->success = true;
            $response->primeiro_nome = $user->userinfo->primeiro_nome;
            $response->ultimo_nome = $user->userinfo->ultimo_nome;

            // Verifica se a data de Nascimento foi enviada vazia ou não
            if ($user->userinfo->data_nascimento == null) {
                $response->data_nascimento = "nulo";
            } else {
                $response->data_nascimento = $user->userinfo->data_nascimento;
            }
            return $response;
        } else {
            $response = new ResponsePerfil();

            $response->success = false;
            $response->mensagem = "O utilizador não tem permissões para visualizar outros utilizadores";
            return $response;
        }
    }

    // Atualiza o próprio utilizador
    public function actionUpdate($id)
    {
        $user = User::findOne($id);

        // Caso não encontre nenhum utilizador
        if ($user == null) {
            $response = new ResponsePerfil();

            $response->success = false;
            $response->mensagem = "Não existe um utilizador com esse ID";
            return $response;
        }

        // Verifica se o user tem a permissão para fazer atualizações e se altera o seu próprio perfil
        if (Yii::$app->user->can('updateProfile', ['user' => $user])) {
            // Recebe os dados enviados e atualiza-os
            $user->userinfo->primeiro_nome = Yii::$app->request->post('primeiro_nome');
            $user->userinfo->ultimo_nome = Yii::$app->request->post('ultimo_nome');
            // Formata a string para data
            $date = strtotime(Yii::$app->request->post('data_nascimento'));
            $user->userinfo->data_nascimento = date("Y-m-d", $date);

            $response = new ResponsePerfil();

            // Verifica se os novos dados estão válidos
            if ($user->validate() && $user->userinfo->validate()) {
                // Guarda as alterações do utilizador
                $user->save();
                $user->userinfo->save();

                // Envia uma resposta de sucesso
                $response->success = true;
                $response->primeiro_nome = $user->userinfo->primeiro_nome;
                $response->ultimo_nome = $user->userinfo->ultimo_nome;

                // Verifica se a data de Nascimento foi enviada vazia ou não
                if ($user->userinfo->data_nascimento == null) {
                    $response->data_nascimento = "nulo";
                } else {
                    $response->data_nascimento = $user->userinfo->data_nascimento;
                }

            } else {
                // Envia uma resposta de erro
                $response->success = false;
                $response->mensagem = "Erro a editar o perfil";
            }

            return $response;
        } else {
            $response = new ResponsePerfil();

            $response->success = false;
            $response->mensagem = "O utilizador não tem permissões para atualizar outros utilizadores";
            return $response;
        }
    }

    // Apaga o utilizador com o login feito
    public function actionDelete($id)
    {
        $user = User::findOne($id);

        // Caso não encontre nenhum utilizador
        if ($user == null) {
            $response = new ResponsePerfil();

            $response->success = false;
            $response->mensagem = "Não existe um utilizador com esse ID";
            return $response;
        }

        // Verifica se o utilizador tem permissões para apagar o perfil e se está a apagar o próprio
        if (Yii::$app->user->can('deleteProfile', ['user' => $user])) {
            // Recebe todos os treinos que este utilizador tenha feito
            $ciclismos = Ciclismo::find()->where(['user_id' => $user->id])->all();

            // Para cada treino é verificado
            foreach ($ciclismos as $ciclismo) {
                // Caso a sessão de treino tenha uma publicação
                if (Publicacao::find()->where(['ciclismo_id' => $ciclismo->id])->one() == true) {
                    // Apaga todos os Comentários, Gostos, e a própria publicação
                    Comentario::deleteAll(['publicacao_id' => $ciclismo->publicacao->id]);
                    Gosto::deleteAll(['publicacao_id' => $ciclismo->publicacao->id]);
                    Publicacao::deleteAll(['ciclismo_id' => $ciclismo->id]);
                }
                // Apaga a sessão de treino
                $ciclismo->delete();
            }

            // Apaga todos os Comentários, Gostos feitos pelo utilizador e dados do próprio
            Comentario::deleteAll(['user_id' => $user->id]);
            Gosto::deleteAll(['user_id' => $user->id]);
            $user->userinfo->delete();
            $user->delete();

            // Verifica se o utilizador foi apagado
            $user = User::findOne($id);

            $response = new ResponsePerfil();

            // Se nenhum utilizador foi encontrado, retorna sucesso
            if ($user == null) {
                $response->success = true;
            } else {
                $response->success = false;
                $response->mensagem = "Erro a apagar o utilizador";
            }
            return $response;
        } else {
            $response = new ResponsePerfil();
            $response->success = false;
            $response->mensagem = "O utilizador não tem permissões para apagar outros utilizadores";
            return $response;
        }
    }
}
