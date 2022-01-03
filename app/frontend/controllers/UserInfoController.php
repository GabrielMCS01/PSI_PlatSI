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
use yii\web\Controller;

class UserInfoController extends Controller
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


    // Página para visualizar os dados do utilizador
    public function actionPerfil(){
        if(Yii::$app->user->isGuest){
            return $this->goHome();
        }

        // Procura todos os dados do utilizador com login feito
        $model = UserInfo::find()->where(["user_id" => Yii::$app->user->getId()])->one();

        // Caso o utilizador tenha feito alterações nos seus dados
        if ($model->load(Yii::$app->request->post())) {
            // Faz validação dos novos dados
            $model->save(true);
            return $this->goHome();
        }else{
            return $this->render('perfil', [
                'model' => $model,
            ]);
        }
    }

    // Apaga o perfil do utilizador com login feito
    public function actionDelete(){
        // Recebe o ID do utilizador
        $user = User::findOne(Yii::$app->user->getId());

        // Recebe todos os treinos que este utilizador tenha feito
        $ciclismos = Ciclismo::find()->where(['user_id' => $user->id])->all();

        // Para cada treino é verificado
        foreach ($ciclismos as $ciclismo){
            // Caso a sessão de treino tenha uma publicação
            if (Publicacao::find()->where(['ciclismo_id' => $ciclismo->id])->one() == true) {
                // Apaga todos os Comentários, Gostos, e a própria publicação
                Comentario::deleteAll(['publicacao_id' => $ciclismo->publicacao->id]);
                Gosto::deleteAll(['publicacao_id' => $ciclismo->publicacao->id]);
                Publicacao::deleteAll(['ciclismo_id' => $ciclismo->id]);
            }
            // Apaga a sessão de treino
            $ciclismo->delete();
        }

        // Apaga todos os Comentários, Gostos feitos pelo utilizador e dados do próprio
        Comentario::deleteAll(['user_id' => $user->id]);
        Gosto::deleteAll(['user_id' => $user->id]);
        $user->userinfo->delete();
        $user->delete();

        // Verifica se o utilizador já foi apagado
        $user = User::findOne(Yii::$app->user->getId());

        // Caso tenha sido apagado é terminada a sessão e é redirecionado para a página inicial
        if($user == null){
            Yii::$app->user->logout();
            return $this->goHome();
        }

        // Caso tenha ocorrido alguma erro o user fica na mesma página
        return $this->actionPerfil();
    }

}
