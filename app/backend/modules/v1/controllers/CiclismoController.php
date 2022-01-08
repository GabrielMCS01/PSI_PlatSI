<?php

namespace app\modules\v1\controllers;

use app\modules\v1\models\ResponseCiclismo;
use common\models\Ciclismo;
use common\utils\Converter;
use common\utils\Mosquitto;
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
    public function actionCreate()
    {
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
        if ($ciclismo->validate()) {
            // Compara se a distância do treino é superior que a maior existente na Base de Dados
            if ($bestDistancia->distancia < $ciclismo->distancia) {
                $canal = "leaderboard";
                $msg = "Novo recorde de distancia: " . Converter::distanceConverter($ciclismo->distancia) . " por " . $ciclismo->user->username;
                Mosquitto::FazPublish($canal, $msg);
            }
            // Compara se a duração do treino é superior que a maior existente na Base de Dados
            if ($bestTempo->duracao < $ciclismo->duracao) {
                $canal = "leaderboard";
                $msg = "Novo recorde de duração: " . Converter::timeConverter($ciclismo->duracao) . " por " . $ciclismo->user->username;
                Mosquitto::FazPublish($canal, $msg);
            }
            // Compara se a velocidade média do treino é superior que a maior existente na Base de Dados
            if ($bestVelocidade->velocidade_media < $ciclismo->velocidade_media) {
                $canal = "leaderboard";
                $msg = "Novo recorde de velocidade média: " . Converter::velocityConverter($ciclismo->velocidade_media) . " por " . $ciclismo->user->username;
                Mosquitto::FazPublish($canal, $msg);
            }
            $ciclismo->save();
            $response = new ResponseCiclismo();
            $response->success = true;
            $response->ciclismo = $ciclismo;
            return $response;
        } else {
            $response = new ResponseCiclismo();
            $response->success = false;
            $response->mensagem = "Erro a criar o treino";
            return $response;
        }
    }

    // Mostra um treino do próprio utilizador
    public function actionView($id)
    {
        $ciclismo = Ciclismo::findOne($id);

        if($ciclismo == null){
            $response = new ResponseCiclismo();
            $response->success = false;
            $response->mensagem = "Não existe uma sessão de treino com esse ID";
            return $response;
        }
        // Verifica se o utilizador que acede é o mesmo que este está a ser chamado nos dados
        if (Yii::$app->user->can('viewActivity', ['activity' => $ciclismo])) {
            $response = new ResponseCiclismo();
            $response->success = true;
            $response->ciclismo = $ciclismo;
            return $response;
        } else {
            $response = new ResponseCiclismo();
            $response->success = false;
            $response->mensagem = "O utilizador não tem permissões para as visualizar treinos de outros utilizadores";
            return $response;
        }
    }

    // Mostra todos os treinos do próprio utilizador
    public function actionIndex()
    {
        // Recebe todos os treino onde o User_id do user que faz o pedido
        $ciclismos = Ciclismo::find()->where(['user_id' => Yii::$app->user->id])->all();

        if($ciclismos == null){
            $response = new ResponseCiclismo();
            $response->success = false;
            $response->mensagem = "Não existem sessões de treino";
            return $response;
        }


        $response = new ResponseCiclismo();
        $response->success = true;
        $response->ciclismo = $ciclismos;
        return $response;
    }


    // Atualiza um treino do User
    public function actionUpdate($id)
    {
        $treino = Ciclismo::findOne($id);

        if($treino == null){
            $response = new ResponseCiclismo();
            $response->success = false;
            $response->mensagem = "Não existe uma sessão de treino com esse ID";
            return $response;
        }

        // Verifica se o utilizador que acede é o mesmo que este está a ser chamado nos dados
        if (Yii::$app->user->can('updateActivity', ['activity' => $treino])) {
            // Recebe os dados enviados e atualiza-os
            $treino->nome_percurso = Yii::$app->request->post('nome_percurso');

            // Guarda as alterações do utilizador e das informações deste
            if($treino->validate()) {
                $treino->save();

                $response = new ResponseCiclismo();
                $response->success = true;
                $response->ciclismo = $treino;
                return $response;
            }else{
                $response = new ResponseCiclismo();
                $response->mensagem = "Erro a editar a sessão de treino";
                $response->success = false;
                return $response;
            }
        } else {
            $response = new ResponseCiclismo();
            $response->success = false;
            $response->mensagem = "O utilizador não tem permissões para atualizar treinos de outros utilizadores";
            return $response;
        }
    }

    // Apaga um treino do utilizador com o login feito
    public function actionDelete($id)
    {
        $treino = Ciclismo::findOne($id);

        if($treino == null){
            $response = new ResponseCiclismo();
            $response->success = false;
            $response->mensagem = "Não existe uma sessão de treino com esse ID";
            return $response;
        }

        // Verifica se o utilizador que acede é o mesmo que este está a ser chamado nos dados
        if (Yii::$app->user->can('deleteActivity', ['activity' => $treino])) {
            $treino->delete();

            $treino = Ciclismo::findOne($id);

            $response = new ResponseCiclismo();

            if ($treino == null) {
                $response->success = true;
            } else {
                $response->success = false;
                $response->mensagem = "Erro a apagar a sessão de treino";
            }
            return $response;
        } else {
                $response = new ResponseCiclismo();
                $response->success = false;
                $response->mensagem = "O utilizador não tem permissões para apagar treinos de outros utilizadores";
                return $response;
        }
    }


    /**
     * @throws \yii\base\InvalidConfigException
     */
    // Permite fazer a sincronização dos treinos da DB local (SQLITE) com a DB da API
    public function actionSync()
    {
        $treinos = Yii::$app->request->post();

        foreach ($treinos as $treino) {
            $ciclismo = new Ciclismo();

            $ciclismo->nome_percurso = $treino["nome_percurso"];
            $ciclismo->duracao = $treino["duracao"];
            $ciclismo->distancia = $treino["distancia"];
            $ciclismo->velocidade_media = $treino["velocidade_media"];
            $ciclismo->velocidade_maxima = $treino["velocidade_maxima"];
            $ciclismo->velocidade_grafico = $treino["velocidade_grafico"];
            $ciclismo->rota = $treino["rota"];
            $ciclismo->data_treino = Yii::$app->formatter->asDateTime('now', 'yyyy-MM-dd HH-mm-ss');
            $ciclismo->user_id = Yii::$app->user->getId();

            $bestDistancia = Ciclismo::find()->select(['user_id', 'MAX(distancia) as distancia'])->orderBy(['MAX(distancia)' => SORT_DESC])->groupBy(['user_id'])->one();
            $bestTempo = Ciclismo::find()->select(['user_id', 'MAX(duracao) as duracao'])->orderBy(['MAX(duracao)' => SORT_DESC])->groupBy(['user_id'])->one();
            $bestVelocidade = Ciclismo::find()->select(['user_id', 'MAX(velocidade_media) as velocidade_media'])->orderBy(['MAX(velocidade_media)' => SORT_DESC])->groupBy(['user_id'])->one();


            if ($ciclismo->validate()) {
                if ($bestDistancia->distancia < $ciclismo->distancia) {
                    $canal = "leaderboard";
                    $msg = "Novo recorde de distancia: " . Converter::distanceConverter($ciclismo->distancia) . " por " . $ciclismo->user->username;
                    Mosquitto::FazPublish($canal, $msg);
                }
                if ($bestTempo->duracao < $ciclismo->duracao) {
                    $canal = "leaderboard";
                    $msg = "Novo recorde de duração: " . Converter::timeConverter($ciclismo->duracao) . " por " . $ciclismo->user->username;
                    Mosquitto::FazPublish($canal, $msg);
                }
                if ($bestVelocidade->velocidade_media < $ciclismo->velocidade_media) {
                    $canal = "leaderboard";
                    $msg = "Novo recorde de velocidade média: " . Converter::velocityConverter($ciclismo->velocidade_media) . " por " . $ciclismo->user->username;
                    Mosquitto::FazPublish($canal, $msg);
                }
                $ciclismo->save();
            }
        }

        $ciclismos = Ciclismo::find()->where(['user_id' => Yii::$app->user->id])->all();

        $response = new ResponseCiclismo();
        $response->success = true;
        $response->ciclismo = $ciclismos;
        return $response;
    }
}
