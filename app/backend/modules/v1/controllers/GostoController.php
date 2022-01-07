<?php

namespace app\modules\v1\controllers;

use app\modules\v1\models\ResponseGosto;
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
        $actions['index'] = null;
        $actions['view'] = null;

        return $actions;
    }

    // Adiciona um gosto a uma publicação
    public function actionCreate(){

        $gosto = new Gosto();
        $gosto->user_id = Yii::$app->user->getId();
        $gosto->publicacao_id = Yii::$app->request->post("publicacao_id");

        $verificarGosto = Gosto::find()->where(['user_id' =>  $gosto->user_id, 'publicacao_id' => $gosto->publicacao_id])->one();

        if($verificarGosto != null){
            $response = new ResponseGosto();
            $response->success = false;
            $response->mensagem = "Já existe um gosto desse utilizador nessa publicação";
            return $response;
        }

        if($gosto->validate()) {
            $gosto->save();
            $response = new ResponseGosto();
            $response->success = true;
            $response->gosto = $gosto;
            return $response;
        }else{
            $response = new ResponseGosto();
            $response->success = false;
            $response->mensagem = "Erro a adicionar o gosto";
            return $response;
        }
    }

    // Remove um gosto a uma publicação
    public function actionDelete($id){
        $gosto = Gosto::find()->where(['id' => $id])->one();

        if($gosto == null){
            $response = new ResponseGosto();
            $response->success = false;
            $response->mensagem = "Não existe um gosto com esse ID";
            return $response;
        }

        if($gosto->delete()){
            $response = new ResponseGosto();
            $response->success = true;
            return $response;
        }else{
            $response = new ResponseGosto();
            $response->success = false;
            $response->mensagem = "Erro a remover o gosto";
            return $response;
        }

    }

    // Mostra o número de gostos de uma publicacao
    public function actionNumgostospub($publicacaoid){

        $num = count(Gosto::find()->where(['publicacao_id' => $publicacaoid])->all());

        $response = new ResponseGosto();
        $response->success = true;
        $response->gosto = ['publicação_id' => $publicacaoid, 'count' => $num];

        return $response;
    }

    // Mostra o número de gostos de cada publicacao que existe na BD
    public function actionNumgostos(){
        $publicacoes = Publicacao::find()->all();

        $i = 0;
        foreach ($publicacoes as $publicacao){
            $subarray['publicacao_id'] = $publicacao->id;
            $subarray['count'] = count(Gosto::find()->where(['publicacao_id' => $publicacao->id])->all());
            $array[$i] = $subarray;
            $i++;
        }

        $response = new ResponseGosto();
        $response->success = true;
        $response->gosto = $array;

        return $response;
    }

    // Mostra o número de gostos de cada publicacao de um utilizador
    public function actionNumgostosuser(){

        $publicacoes = Publicacao::find()->innerJoin(['ciclismo'], 'publicacao.ciclismo_id = ciclismo.id')->where(['ciclismo.user_id' => Yii::$app->user->getId()])->all();

        $i = 0;
        foreach ($publicacoes as $publicacao){
            $subarray['publicacao_id'] = $publicacao->id;
            $subarray['count'] = count(Gosto::find()->where(['publicacao_id' => $publicacao->id])->all());
            $array[$i] = $subarray;
            $i++;
        }

        $response = new ResponseGosto();
        $response->success = true;
        $response->gosto = $array;

        return $response;
    }

}