<?php

namespace app\modules\v1\controllers;

use app\modules\v1\models\ResponseCreateCiclismo;
use app\modules\v1\models\ResponseDeleteCiclismo;
use app\modules\v1\models\ResponseSync;
use app\modules\v1\models\ResponseUpdateCiclismo;
use common\models\Ciclismo;
use common\utils\Converter;
use common\utils\phpMQTT;
use phpDocumentor\Reflection\Types\Array_;
use Yii;
use yii\db\StaleObjectException;
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

        $bestDistancia = Ciclismo::find()->select(['user_id', 'MAX(distancia) as distancia'])->orderBy(['MAX(distancia)' => SORT_DESC])->groupBy(['user_id'])->one();
        $bestTempo = Ciclismo::find()->select(['user_id', 'MAX(duracao) as duracao'])->orderBy(['MAX(duracao)' => SORT_DESC])->groupBy(['user_id'])->one();
        $bestVelocidade = Ciclismo::find()->select(['user_id', 'MAX(velocidade_media) as velocidade_media'])->orderBy(['MAX(velocidade_media)' => SORT_DESC])->groupBy(['user_id'])->one();


        // Se a validação dos dados for TRUE guarda os dados caso contrário emite um erro
        if ($ciclismo->validate()){
            if($bestDistancia < $ciclismo->distancia){
                $msg = "Novo recorde de distancia: " . Converter::distanceConverter($ciclismo->distancia) . " por " . $ciclismo->user->username;
                $this->FazPublish($msg);
            }
            if($bestTempo < $ciclismo->duracao){
                $msg = "Novo recorde de duração: " . Converter::timeConverter($ciclismo->duracao) . " por " . $ciclismo->user->username;
                $this->FazPublish($msg);
            }
            if($bestVelocidade < $ciclismo->velocidade_media){
                $msg = "Novo recorde de velocidade média: " . Converter::velocityConverter($ciclismo->velocidade_media) . " por " . $ciclismo->user->username;
                $this->FazPublish($msg);
            }
            $ciclismo->save();
            return $ciclismo;
        }
        else {
            $ciclismo->id = -1;
            return $ciclismo;
        }
    }

    public function FazPublish($msg)
    {
        $server = "ciclodias.duckdns.org";
        $canal = "leaderboard";
        $port = 1883;
        $username = "ciclodias";
        $password = "serverciclodias2021";
        $client_id = "phpMQTT-publisher"; // unique!
        $mqtt = new phpMQTT($server, $port, $client_id);
        if ($mqtt->connect(true, NULL, $username, $password)) {
            $mqtt->publish($canal, $msg, 0);
            $mqtt->close();
        } else {
            file_put_contents("debug.output", "Time out!");
        }
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

            $response = new ResponseUpdateCiclismo();
            $response->success = true;
            return $response;
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

            $response = new ResponseDeleteCiclismo();

            if ($treino == null) $response->success = true ;
            else $response->success = false;
            return $response;
        }
        else{
            return "O utilizador não tem permissões para apagar treinos de outros utilizadores";
        }
    }


    /**
     * @throws \yii\base\InvalidConfigException
     */
    // Permite fazer a sincronização dos treinos da DB local (SQLITE) com a DB da API
    public function actionSync(){
        $treinos = Yii::$app->request->post();

        foreach ($treinos as $treino){
            $ciclismo = new Ciclismo();

            $ciclismo->nome_percurso = $treino["nome_percurso"];
            $ciclismo->duracao = $treino["duracao"];
            $ciclismo->distancia = $treino["distancia"];
            $ciclismo->velocidade_media = $treino["velocidade_media"];
            $ciclismo->velocidade_maxima = $treino["velocidade_maxima"];
            $ciclismo->velocidade_grafico = $treino["velocidade_grafico"];
            $ciclismo->rota = $treino["rota"];
            $ciclismo->data_treino =Yii::$app->formatter->asDateTime('now', 'yyyy-MM-dd HH-mm-ss');
            $ciclismo->user_id = Yii::$app->user->getId();

            $bestDistancia = Ciclismo::find()->select(['user_id', 'MAX(distancia) as distancia'])->orderBy(['MAX(distancia)' => SORT_DESC])->groupBy(['user_id'])->one();
            $bestTempo = Ciclismo::find()->select(['user_id', 'MAX(duracao) as duracao'])->orderBy(['MAX(duracao)' => SORT_DESC])->groupBy(['user_id'])->one();
            $bestVelocidade = Ciclismo::find()->select(['user_id', 'MAX(velocidade_media) as velocidade_media'])->orderBy(['MAX(velocidade_media)' => SORT_DESC])->groupBy(['user_id'])->one();


            if ($ciclismo->validate()) {
                if ($bestDistancia < $ciclismo->distancia) {
                    $msg = "Novo recorde de distancia: " . Converter::distanceConverter($ciclismo->distancia) . " por " . $ciclismo->user->username;
                    $this->FazPublish($msg);
                }
                if ($bestTempo < $ciclismo->duracao) {
                    $msg = "Novo recorde de duração: " . Converter::timeConverter($ciclismo->duracao) . " por " . $ciclismo->user->username;
                    $this->FazPublish($msg);
                }
                if ($bestVelocidade < $ciclismo->velocidade_media) {
                    $msg = "Novo recorde de velocidade média: " . Converter::velocityConverter($ciclismo->velocidade_media) . " por " . $ciclismo->user->username;
                    $this->FazPublish($msg);
                }
                $ciclismo->save();
            }
        }

        $treino = Ciclismo::find()->where(['user_id' => Yii::$app->user->id])->all();

        return $treino;
    }
}
