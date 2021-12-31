<?php

namespace frontend\controllers;

use common\models\Gosto;
use Yii;
use yii\web\Response;

class GostoController extends \yii\web\Controller
{
    // Função para colocar ou remover gosto
    public function actionGosto($id){
        // Se o pedido for AJAX faz
        if (Yii::$app->request->isAjax) {
            // Se não encontrar nenhum gosto para o utilizador na publicação faz
            if(Gosto::find()->where(['publicacao_id' => $id, 'user_id' => Yii::$app->user->getId()])->one() == null){
                $gosto = new Gosto();
                $gosto->user_id = Yii::$app->user->getId();
                $gosto->publicacao_id = $id;
                $gosto->save(true);
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['success' => true, 'create' => true];
            // Se encontrar um gosto para o utilizador na publicação faz
            }else{
                $gosto = Gosto::find()->where(['publicacao_id' => $id, 'user_id' => Yii::$app->user->getId()])->one();
                $gosto->delete();
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['success' => true, 'create' => false];
            }
        }
    }
}
