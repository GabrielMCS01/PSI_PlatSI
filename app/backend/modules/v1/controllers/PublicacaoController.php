<?php

namespace app\modules\v1\controllers;

use app\modules\v1\models\ResponsePublicaçao;
use common\models\Ciclismo;
use common\models\Comentario;
use common\models\Gosto;
use common\models\Publicacao;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;

class PublicacaoController extends ActiveController
{
    public $modelClass = 'common\models\Publicacao';


    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
        ];
        return $behaviors;
    }


    public function actions()
    {
        $actions = parent::actions();
        unset($actions['delete']);
        unset($actions['create']);
        unset($actions['index']);
        unset($actions['view']);
        $actions['update'] = null;

        return $actions;
    }

    // Mostra todas as publicações
    public function actionIndex()
    {
        // Recebe todas as publicações, ordenando-as por ordem decrescente
        $publicacao = Publicacao::find()->orderBy(['createtime' => SORT_DESC])->all();

        $response = new ResponsePublicaçao();
        $response->success = true;
        $response->publicacao = $publicacao;
        return $response;
    }

    // Mostra uma publicação
    public function actionView($id)
    {
        $publicacao = Publicacao::findOne($id);

        if ($publicacao == null) {
            $response = new ResponsePublicaçao();
            $response->success = false;
            $response->mensagem = "Não existe uma publicação com esse ID";
            return $response;
        }

        $response = new ResponsePublicaçao();
        $response->success = true;
        $response->publicacao = $publicacao;

        return $response;
    }


    // Mostra todas as publicações do próprio utilizador
    public function actionUser()
    {
        // Recebe a publicações do utilizador
        $publicacao = Publicacao::find()->innerJoin(['ciclismo'], 'publicacao.ciclismo_id = ciclismo.id')->where(['ciclismo.user_id' => Yii::$app->user->getId()])->orderBy(['createtime' => SORT_DESC])->all();

        if ($publicacao == null) {
            $response = new ResponsePublicaçao();
            $response->success = false;
            $response->mensagem = "Esse utilizador não tem publicações";
            return $response;
        }

        $response = new ResponsePublicaçao();
        $response->success = true;
        $response->publicacao = $publicacao;

        return $response;
    }

    // Cria uma publicação
    public function actionCreate()
    {
        // Recebe o treino que vai ser criada a publicação
        $ciclismo = Ciclismo::findOne(Yii::$app->request->post('ciclismo_id'));

        // Se o utilizador não tiver permissões para criar a publicação e se o treino não for do proprio é retornada uma mensagem
        if(!Yii::$app->user->can('viewActivity', ['activity' => $ciclismo])){
            $response = new ResponsePublicaçao();
            $response->success = false;
            $response->mensagem = "O utilizador não tem permissões de criar uma publicação com um treino de outro utilizador";
            return $response;
        }

        $model = new Publicacao();

        $model->ciclismo_id = Yii::$app->request->post('ciclismo_id');
        $model->createtime = Yii::$app->formatter->asDateTime('now', 'yyyy-MM-dd HH-mm-ss');

        // Se os dados forem válidos guarda na DB
        if ($model->validate()) {
            $model->save();
            $response = new ResponsePublicaçao();
            $response->success = true;
            $response->publicacao = $model;
            return $response;
        } else {
            $response = new ResponsePublicaçao();
            $response->success = false;
            $response->mensagem = "Erro ao criar a publicação";
            return $response;
        }
    }

    // Apaga uma publicação assim como todos os seus gostos e comentários
    public function actionDelete($id)
    {
        $publicacao = Publicacao::find()->where(['id' => $id])->one();

        // Se o utilizador tiver permissões de administrador e/ou a publicação for do próprio faz
        if (Yii::$app->user->can("deletePostModerator", ['publicacao' => $publicacao])) {
            Comentario::deleteAll(['publicacao_id' => $publicacao->id]);
            Gosto::deleteAll(['publicacao_id' => $publicacao->id]);

            // Se apagar a publicação com sucesso retorna uma mensagem de sucesso
            if ($publicacao->delete()) {
                $response = new ResponsePublicaçao();
                $response->success = true;
                return $response;
            } else {
                $response = new ResponsePublicaçao();
                $response->success = false;
                $response->mensagem = "Erro ao apagar a publicação";
                return $response;
            }
        }else{
            $response = new ResponsePublicaçao();
            $response->success = false;
            $response->mensagem = "O utilizador não tem permissões de apagar uma publicação de outro utilizador";
            return $response;
        }
    }
}