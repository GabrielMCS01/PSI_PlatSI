<?php

namespace frontend\controllers;

use common\models\Ciclismo;
use common\models\Publicacao;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CiclismoController implements the CRUD actions for Ciclismo model.
 */
class CiclismoController extends Controller
{
    /**
     * @inheritDoc
     */
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

    /**
     * Lists all Ciclismo models.
     * @return mixed
     */
    // Mostra todos os treinos do utilizador
    public function actionIndex()
    {
        // Caso não tenha login feita volta á página principal
        if(Yii::$app->user->isGuest){
            return $this->goHome();
        }

        $ciclismos = Ciclismo::find()->where(['user_id' => Yii::$app->user->getId()])->all();

        $pagination = new Pagination(['defaultPageSize' => 10, 'totalCount' => count($ciclismos),]);

        $ciclismos = Ciclismo::find()->where(['user_id' => Yii::$app->user->getId()])->offset($pagination->offset)->limit($pagination->limit)->all();

        return $this->render('index', ["ciclismos" => $ciclismos, "pagination" => $pagination]);
    }

    /**
     * Displays a single Ciclismo model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Ver um treino do utilizador
    public function actionView($id)
    {
        if(Yii::$app->user->isGuest){
            return $this->goHome();
        }

        // Verifica se existe alguma publicação desta sessão de treino
        $publicar = true;
        if(Publicacao::find()->where(['ciclismo_id' => $id])->one() != null){
            $publicar = false;
        }

        return $this->render('view', [
            'model' => $this->findModel($id), 'publicar' => $publicar
        ]);
    }


    /**
     * Finds the Ciclismo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Ciclismo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ciclismo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
