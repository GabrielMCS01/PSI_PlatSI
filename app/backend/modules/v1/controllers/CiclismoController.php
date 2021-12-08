<?php

namespace app\modules\v1\controllers;

use app\modules\v1\models\ResponseSync;
use common\models\Ciclismo;
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


    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function actionSync(){

        $ids = Yii::$app->request->post("ids");
        $treinos = Yii::$app->request->post("treinos");

        $response = new ResponseSync();
        foreach ($ids as $id){
            $edit = true;
            if(Ciclismo::findOne($id) != null){
                foreach ($treinos as $treino){
                    if($treino["id"] == $id){
                        $ciclismo = Ciclismo::findOne($id);

                        $ciclismo->nome_percurso = $treino["nome_percurso"];

                        $ciclismo->save(true);

                        $response->ids[$id] = -1;

                        $edit = false;
                    }
                }
                if($edit) {
                    $ciclismo = Ciclismo::findOne($id);

                    try {
                        $ciclismo->delete();
                        $response->ids[$id] = -1;
                    } catch (StaleObjectException $e) {

                    } catch (\Throwable $e) {

                    }
                }
            }else{
                foreach ($treinos as $treino) {
                    if ($treino["id"] == $id) {
                        $ciclismo = new Ciclismo();

                        $ciclismo->nome_percurso = $treino["nome_percurso"];
                        $ciclismo->duracao = $treino["duracao"];
                        $ciclismo->distancia = $treino["distancia"];
                        $ciclismo->velocidade_media = $treino["velocidade_media"];
                        $ciclismo->velocidade_maxima = $treino["velocidade_maxima"];
                        $ciclismo->velocidade_grafico = null;
                        $ciclismo->rota = null;
                        $ciclismo->data_treino =Yii::$app->formatter->asDateTime('now', 'yyyy-MM-dd HH-mm-ss');
                        $ciclismo->user_id = Yii::$app->user->getId();


                        $response->ids[$id] = $ciclismo->id;

                        $ciclismo->save(true);
                    }
                }
            }

        }

        return $response;

    }
}
