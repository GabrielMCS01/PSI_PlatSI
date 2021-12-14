<?php

namespace frontend\controllers;

use common\models\UserInfo;
use Yii;
use yii\filters\VerbFilter;

class UserInfoController extends \yii\web\Controller
{
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }


    public function actionPerfil(){
        $model = UserInfo::find()->where(["user_id" => Yii::$app->user->getId()])->one();


        if ($model->load(Yii::$app->request->post())) {
            $model->save(true);
            return $this->goHome();
        }else{
            return $this->render('perfil', [
                'model' => $model,
            ]);
        }
    }

}
