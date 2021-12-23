<?php

namespace frontend\controllers;

use common\models\Gosto;
use Yii;
use yii\web\Response;

class GostoController extends \yii\web\Controller
{
    public function actionGosto($id){
        if (Yii::$app->request->isAjax) {
            if(Gosto::find()->where(['publicacao_id' => $id, 'user_id' => Yii::$app->user->getId()])->one() == null){
                $gosto = new Gosto();
                $gosto->user_id = Yii::$app->user->getId();
                $gosto->publicacao_id = $id;
                $gosto->save(true);
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['success' => true, 'create' => true];
            }else{
                $gosto = Gosto::find()->where(['publicacao_id' => $id, 'user_id' => Yii::$app->user->getId()])->one();
                $gosto->delete();
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['success' => true, 'create' => false];
            }
        }
    }
}
