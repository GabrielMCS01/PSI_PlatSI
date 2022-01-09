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
        unset($actions['delete']);
        $actions['update'] = null;
        $actions['index'] = null;
        $actions['view'] = null;

        return $actions;
    }

    // Adiciona um gosto a uma publicação
    public function actionCreate(){
        // Cria um objeto Gosto
        $gosto = new Gosto();
        $gosto->user_id = Yii::$app->user->getId();
        $gosto->publicacao_id = Yii::$app->request->post("publicacao_id");

        // Verifica se o utilizador ja tinha colocado um gosto na publicação anteriormente
        $verificarGosto = Gosto::find()->where(['user_id' =>  $gosto->user_id, 'publicacao_id' => $gosto->publicacao_id])->one();

        // Se existir o gosto anteriormente
        if($verificarGosto != null){
            $response = new ResponseGosto();
            $response->success = false;
            $response->mensagem = "Já existe um gosto desse utilizador nessa publicação";
            return $response;
        }

        // Se o novo gosto for válido guarda na DB
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
        // Pesquisa pelo gosto que se pretende apagar
        $gosto = Gosto::find()->where(['id' => $id])->one();

        // Se não encontrar o gosto dá erro
        if($gosto == null){
            $response = new ResponseGosto();
            $response->success = false;
            $response->mensagem = "Não existe um gosto com esse ID";
            return $response;
        }

        // Se o utilizador que pretende apagar o gosto for o mesmo que colocou o gosto pode apagá-lo
        if($gosto->user_id != Yii::$app->user->getId()){
            $response = new ResponseGosto();
            $response->success = false;
            $response->mensagem = "Este utilizador não pode apagar gostos de outros utilizadores";
            return $response;
        }

        // Se remover o gosto com sucesso
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
        // Conta o número de gostos da publicação
        $num = count(Gosto::find()->where(['publicacao_id' => $publicacaoid])->all());

        $response = new ResponseGosto();
        $response->success = true;
        // Envia o ID da publicação com o número de gostos
        $response->gosto = ['publicação_id' => $publicacaoid, 'count' => $num];

        return $response;
    }

    // Mostra o número de gostos de cada publicacao que existe na BD
    public function actionNumgostos(){
        // Pesquisa por todas as publicações
        $publicacoes = Publicacao::find()->all();

        if($publicacoes == null){
            $response = new ResponseGosto();
            $response->success = false;
            $response->mensagem = "Não existem Publicações";
            return $response;
        }

        $i = 0;

        // Cria um array contendo um array para cada publicação
        // Para cada publicação recebe o ID e o número de gostos
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
        // Recebe todas as publicações do utilizador
        $publicacoes = Publicacao::find()->innerJoin(['ciclismo'], 'publicacao.ciclismo_id = ciclismo.id')->where(['ciclismo.user_id' => Yii::$app->user->getId()])->all();

        if($publicacoes == null){
            $response = new ResponseGosto();
            $response->success = false;
            $response->mensagem = "Utilizador sem publicações";
            return $response;
        }

        $i = 0;

        // Cria um array contendo um array para cada publicação
        // Para cada publicação recebe o ID e o número de gostos
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