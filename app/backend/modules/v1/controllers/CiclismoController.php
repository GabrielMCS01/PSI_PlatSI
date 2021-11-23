<?php

namespace app\modules\v1\controllers;

use common\models\Ciclismo;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;

/**
 * Default controller for the `v1` module
 */
class CiclismoController extends ActiveController
{
    public $modelClass = 'common\models\Ciclismo';

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
        unset($actions['create']);
        unset($actions['index']);

        return $actions;
    }

    public function actionCreate(){
        $ciclismo = new Ciclismo();

        $ciclismo->nome_percurso = Yii::$app->request->post('nome_percurso');
        $ciclismo->duracao = Yii::$app->request->post('duracao');
        $ciclismo->distancia = Yii::$app->request->post('distancia');
        $ciclismo->velocidade_media = Yii::$app->request->post('velocidade_media');
        $ciclismo->velocidade_maxima = Yii::$app->request->post('velocidade_maxima');
        $ciclismo->velocidade_grafico = Yii::$app->request->post('velocidade_grafico');
        $ciclismo->rota = Yii::$app->request->post('rota');
        $ciclismo->data_treino = Yii::$app->request->post('data_treino');
        $ciclismo->user_id = Yii::$app->user->getId();

        if ($ciclismo->validate()){
            $ciclismo->save();
            return "Treino criado com sucesso";
        }
        else return "Ocorreu um erro a criar o treino";
    }

    // Mostra um treino do próprio utilizador
    public function actionView($id){
        $treino = Ciclismo::findOne($id);

        // Verifica se o utilizador que acede é o mesmo que este está a chamar os dados
        if(Yii::$app->user->can('viewActivity', ['activity' => $treino])){
            return $treino;
        }
        else{
            return "O utilizador não tem permissões para visualizar atividades de outros utilizadores";
        }
    }


/*
    // Atualiza o próprio utilizador
    public function actionUpdate($id){
        $user = User::findOne($id);

        // Verifica se o utilizador tem acesso á aplicação (Frontend)
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

        // Verifica se o utilizador tem acesso á aplicação (Frontend)
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
*/
}
