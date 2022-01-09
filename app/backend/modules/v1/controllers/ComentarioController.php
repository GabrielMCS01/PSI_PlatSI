<?php

namespace app\modules\v1\controllers;

use app\modules\v1\models\ResponseComentario;
use common\models\Comentario;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;

class ComentarioController extends ActiveController
{
    public $modelClass = 'common\models\Comentario';

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
        unset($actions['index']);
        unset($actions['view']);
        unset($actions['delete']);
        unset($actions['create']);
        unset($actions['update']);

        return $actions;
    }

    // Devolve todos os comentários
    public function actionIndex()
    {
        $comentarios = Comentario::find()->all();

        if ($comentarios == null) {
            $response = new ResponseComentario();
            $response->success = false;
            $response->mensagem = "Não existem comentários";
            return $response;
        }

        $response = new ResponseComentario();
        $response->success = true;
        $response->comentario = $comentarios;

        return $response;
    }

    // Cria um comentário numa publicação
    public function actionCreate()
    {
        // Cria um objeto do tipo Comentário
        $model = new Comentario();

        $model->publicacao_id = Yii::$app->request->post('publicacao_id');
        $model->user_id = Yii::$app->user->getId();
        $model->createtime = Yii::$app->formatter->asDateTime('now', 'yyyy-MM-dd HH-mm-ss');
        $model->content = Yii::$app->request->post('content');

        // Se os dados do comentário forem válidos cria na DB
        if ($model->validate()) {
            $model->save();

            $response = new ResponseComentario();
            $response->success = true;
            $response->comentario = $model;
            return $response;
        } else {
            $response = new ResponseComentario();
            $response->success = false;
            $response->mensagem = "Erro a criar o comentário";
            return $response;
        }
    }

    // Devolve um comentário
    public function actionView($id)
    {
        $comentario = Comentario::findOne($id);

        if ($comentario == null) {
            $response = new ResponseComentario();
            $response->success = false;
            $response->mensagem = "Não existe um comentário com esse ID";
            return $response;
        }

        $response = new ResponseComentario();
        $response->success = true;
        $response->comentario = $comentario;
        return $response;
    }

    // Edita um comentário numa publicação
    public function actionUpdate($id)
    {
        $comentario = Comentario::find()->where(['id' => $id])->one();

        if ($comentario == null) {
            $response = new ResponseComentario();
            $response->success = false;
            $response->mensagem = "Não existe um comentário com esse ID";
            return $response;
        }

        // Verifica se o utilizador que edita é o utilizador que criou o comentário
        if (Yii::$app->user->can("UpdateComment", ['comentario' => $comentario])) {
            $comentario->content = Yii::$app->request->post('content');

            // Adiciona ao comentário o texto (editado)
            $comentario->content = $comentario->content . ' (Editado)';

            
            if ($comentario->validate()) {
                $comentario->save();

                $response = new ResponseComentario();
                $response->success = true;
                $response->comentario = $comentario;
                return $response;
            } else {
                $response = new ResponseComentario();
                $response->success = false;
                $response->mensagem = "Erro a editar o comentário";
                return $response;
            }
        } else {
            $response = new ResponseComentario();
            $response->success = false;
            $response->mensagem = "Utilizador não tem permissões para editar este comentário";
            return $response;
        }
    }


    // Apaga um comentário numa publicação
    public function actionDelete($id)
    {
        $comentario = Comentario::find()->where(['id' => $id])->one();

        if ($comentario == null) {
            $response = new ResponseComentario();
            $response->success = false;
            $response->mensagem = "Não existe um comentário com esse ID";
            return $response;
        }

        if (Yii::$app->user->can("deleteCommentModerator", ['comentario' => $comentario])) {
            if ($comentario->delete()) {
                $response = new ResponseComentario();
                $response->success = true;
                return $response;
            } else {
                $response = new ResponseComentario();
                $response->success = false;
                $response->mensagem = "Erro a apagar o comentário";
                return $response;
            }
        } else {
            $response = new ResponseComentario();
            $response->success = false;
            $response->mensagem = "Utilizador não tem permissões para remover este comentário";
            return $response;
        }
    }

    // Mostra todos os comentários de uma publicação
    public function actionGetcomentpub($publicacaoid)
    {
        $comentarios = Comentario::find()->where(['publicacao_id' => $publicacaoid])->all();

        if ($comentarios == null) {
            $response = new ResponseComentario();
            $response->success = false;
            $response->mensagem = "Essa publicação não tem comentários";
            return $response;
        }

        $response = new ResponseComentario();
        $response->success = true;
        $response->comentario = $comentarios;

        return $response;
    }
}