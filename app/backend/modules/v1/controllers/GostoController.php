<?php

namespace app\modules\v1\controllers;

use common\models\Gosto;
use common\models\Publicacao;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;

class GostoController extends ActiveController
{
    public $modelClass = 'common\models\Gosto';

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
        unset($actions['create']);
        $actions['update'] = null;

        return $actions;
    }

    //Adiciona um gosto a uma publicação
    public function actionCreate(){

        $gosto = new Gosto();
        $gosto->user_id = Yii::$app->user->getId();
        $gosto->publicacao_id = Yii::$app->request->post("publicacao_id");

        if($gosto->validate()) {
            $gosto->save();
            return $gosto;
        }else{
            return $gosto;
        }
    }

    public function actionDelete($id){
        $gosto = Gosto::find()->where(['id' => $id])->one();
        if($gosto->delete()){
            return true;
        }else{
            return false;
        }
    }

    //Mostra o número de gostos de uma publicacao
    public function actionNumgostospub($publicacaoid){
        $num = count(Gosto::find()->where(['publicacao_id' => $publicacaoid])->all());

        return ['publicação_id' => $publicacaoid, 'count' => $num];
    }

    //Mostra o número de gostos de cada publicacao que existe na bd
    public function actionNumgostos(){
        $publicacoes = Publicacao::find()->all();

        $i = 0;
        foreach ($publicacoes as $publicacao){
            $subarray['publicacao_id'] = $publicacao->id;
            $subarray['count'] = count(Gosto::find()->where(['publicacao_id' => $publicacao->id])->all());
            $array[$i] = $subarray;
            $i++;
        }

        return $array;
    }

    //Mostra o número de gostos de cada publicacao de um utilizador
    public function actionNumgostosuser(){
        $publicacoes = Publicacao::find()->innerJoin(['ciclismo'], 'publicacao.ciclismo_id = ciclismo.id')->where(['ciclismo.user_id' => Yii::$app->user->getId()])->all();

        $i = 0;
        foreach ($publicacoes as $publicacao){
            $subarray['publicacao_id'] = $publicacao->id;
            $subarray['count'] = count(Gosto::find()->where(['publicacao_id' => $publicacao->id])->all());
            $array[$i] = $subarray;
            $i++;
        }

        return $array;
    }

}