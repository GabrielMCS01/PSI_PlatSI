<?php

namespace app\modules\v1\controllers;

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
        unset($actions['delete']);
        unset($actions['create']);
        unset($actions['update']);

        return $actions;
    }

    // Cria um comentário numa publicação
    public function actionCreate(){

        $model = new Comentario();

        $model->publicacao_id = Yii::$app->request->post('publicacao_id');
        $model->user_id = Yii::$app->user->getId();
        $model->createtime = Yii::$app->formatter->asDateTime('now', 'yyyy-MM-dd HH-mm-ss');
        $model->content = Yii::$app->request->post('content');

        if($model->validate()){
            $model->save();
            return $model;
        }else{
            return $model;
        }
    }

    // Edita um comentário numa publicação
    public function actionUpdate($id){

        $comentario = Comentario::find()->where(['id' => $id])->one();

        if(Yii::$app->user->can("UpdateComment", ['comentario' => $comentario])) {
            $comentario->content = Yii::$app->request->post('content');

            $comentario->content = $comentario->content . ' (Editado)';

            if ($comentario->validate()) {
                $comentario->save();
                return $comentario;
            } else {
                return $comentario;
            }
        }else{
            return "Utilizador não ter permissões para editar este comentário";
        }
    }

    // Apaga um comentário numa publicação
    public function actionDelete($id){

        $comentario = Comentario::find()->where(['id' => $id])->one();

        if(Yii::$app->user->can("deleteCommentModerator", ['comentario' => $comentario])){
            if($comentario->delete()){
                return true;
            }else{
                return false;
            }
        }else{
            return "Utilizador não ter permissões para remover este comentário";
        }

    }

    // Mostra todos os comentários de uma publicação
    public function actionGetcomentpub($publicacaoid){

        $comentario = Comentario::find()->where(['publicacao_id' => $publicacaoid])->all();

        return $comentario;
    }
}