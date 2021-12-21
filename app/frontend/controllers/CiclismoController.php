<?php

namespace frontend\controllers;

use common\models\Ciclismo;
use app\models\CiclismoSearch;
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
    public function actionIndex()
    {
        /*
        $searchModel = new CiclismoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);*/

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
    public function actionView($id)
    {
        $publicar = true;
        if(Publicacao::find()->where(['ciclismo_id' => $id])->one() != null){
            $publicar = false;
        }
        return $this->render('view', [
            'model' => $this->findModel($id), 'publicar' => $publicar
        ]);
    }

    /**
     * Creates a new Ciclismo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Ciclismo();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Ciclismo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Ciclismo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
