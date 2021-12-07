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

    // Cria um Treino para o utilizador
    public function actionCreate(){
        $ciclismo = new Ciclismo();

        $ciclismo->nome_percurso = Yii::$app->request->post('nome_percurso');
        $ciclismo->duracao = Yii::$app->request->post('duracao');
        $ciclismo->distancia = Yii::$app->request->post('distancia');
        $ciclismo->velocidade_media = Yii::$app->request->post('velocidade_media');
        $ciclismo->velocidade_maxima = Yii::$app->request->post('velocidade_maxima');
        $ciclismo->velocidade_grafico = Yii::$app->request->post('velocidade_grafico');
        $ciclismo->rota = Yii::$app->request->post('rota');
        $ciclismo->data_treino = Yii::$app->formatter->asDateTime('now', 'yyyy-MM-dd HH-mm-ss');
        $ciclismo->user_id = Yii::$app->user->getId();

        // Se a validação dos dados for TRUE guarda os dados caso contrário emite um erro
        if ($ciclismo->validate()){
            $ciclismo->save();
            return "Treino criado com sucesso";
        }
        else return "Ocorreu um erro a criar o treino";
    }

    // Mostra um treino do próprio utilizador
    public function actionView($id){
        $treino = Ciclismo::findOne($id);

        // Verifica se o utilizador que acede é o mesmo que este está a ser chamado nos dados
        if(Yii::$app->user->can('viewActivity', ['activity' => $treino])){
            return $treino;
        }
        else{
            return "O utilizador não tem permissões para as visualizar treinos de outros utilizadores";
        }
    }

    // Mostra todos os treinos do próprio utilizador
    public function actionIndex(){
        // Recebe todos os treino onde o User_id do user que faz o pedido
        $treino = Ciclismo::find()->where(['user_id' => Yii::$app->user->id])->all();

        return $treino;
    }


    // Atualiza um treino do User
    public function actionUpdate($id){
        $treino = Ciclismo::findOne($id);

        // Verifica se o utilizador que acede é o mesmo que este está a ser chamado nos dados
        if(Yii::$app->user->can('updateActivity', ['activity' => $treino])) {
            // Recebe os dados enviados e atualiza-os
            $treino->nome_percurso = Yii::$app->request->post('nome_percurso');

            // Guarda as alterações do utilizador e das informações deste
            $treino->save();

            return $treino;
        }
        else return "O utilizador não tem permissões para atualizar treinos de outros utilizadores";
    }

    // Apaga um treino do utilizador com o login feito
    public function actionDelete($id){
        $treino = Ciclismo::findOne($id);

        // Verifica se o utilizador que acede é o mesmo que este está a ser chamado nos dados
        if(Yii::$app->user->can('deleteActivity', ['activity' => $treino])) {

            $treino->delete();

            $treino = null;

            if ($treino == null) return "Treino apagado com sucesso";
            else return "Erro ao apagar treino";
        }
        else{
            return "O utilizador não tem permissões para apagar treinos de outros utilizadores";
        }
    }
}