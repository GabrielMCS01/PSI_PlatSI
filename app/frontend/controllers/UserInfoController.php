<?php

namespace frontend\controllers;

use common\models\Ciclismo;
use common\models\Comentario;
use common\models\Gosto;
use common\models\Publicacao;
use common\models\User;
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
        if(Yii::$app->user->isGuest){
            return $this->goHome();
        }

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

    public function actionDelete(){
        $user = User::findOne(Yii::$app->user->getId());

        $ciclismos = Ciclismo::find()->where(['user_id' => $user->id])->all();

        foreach ($ciclismos as $ciclismo){
            if (Publicacao::find()->where(['ciclismo_id' => $ciclismo->id])->one() == true) {
                Comentario::deleteAll(['publicacao_id' => $ciclismo->publicacao->id]);
                Gosto::deleteAll(['publicacao_id' => $ciclismo->publicacao->id]);
                Publicacao::deleteAll(['ciclismo_id' => $ciclismo->id]);
            }
            $ciclismo->delete();
        }

        Comentario::deleteAll(['user_id' => $user->id]);
        Gosto::deleteAll(['user_id' => $user->id]);
        $user->userinfo->delete();
        $user->delete();

        $user = User::findOne(Yii::$app->user->getId());

        if($user == null){
            Yii::$app->user->logout();
            return $this->goHome();
        }

        return $this->actionPerfil();
    }

}
