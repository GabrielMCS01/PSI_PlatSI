<?php

namespace app\modules\v1\controllers;

use common\models\Comentario;
use common\models\Gosto;
use common\models\Publicacao;
use phpDocumentor\Reflection\Types\True_;
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
        $actions['update'] = null;

        return $actions;
    }

    // Mostra todas as publicações
    public function actionIndex(){

        //Vai buscar todas as publicações, ordenando-as por ordem descendente
        $publicacao = Publicacao::find()->orderBy(['createtime' => SORT_DESC])->all();

        return $publicacao;
    }


    //Mostra todas as publicações do próprio utilizador
    public function actionUser(){
        $publicacao = Publicacao::find()->innerJoin(['ciclismo'], 'publicacao.ciclismo_id = ciclismo.id')->where(['ciclismo.user_id' => Yii::$app->user->getId()])->orderBy(['createtime' => SORT_DESC])->all();

        return $publicacao;
    }

    //Cria uma publicação
    public function actionCreate(){
        $model = new Publicacao();

        $model->ciclismo_id = Yii::$app->request->post('ciclismo_id');
        $model->createtime = Yii::$app->formatter->asDateTime('now', 'yyyy-MM-dd HH-mm-ss');

        if($model->validate()) {
            $model->save();
            return $model;
        }else{
            return $model;
        }
    }

    //Apaga uma publicação, juntamente com todos os seus gostos e comentários
    public function actionDelete($id){
        $publicacao = Publicacao::find()->where(['id' => $id])->one();

        if(Yii::$app->user->can("deletePostModerator", ['publicacao' => $publicacao])) {
            Comentario::deleteAll(['publicacao_id' => $publicacao->id]);
            Gosto::deleteAll(['publicacao_id' => $publicacao->id]);

            if ($publicacao->delete()) {
                return true;
            } else {
                return false;
            }
        }
    }
}