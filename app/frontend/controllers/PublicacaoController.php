<?php

namespace frontend\controllers;

use common\models\Comentario;
use common\models\Publicacao;
use app\models\PublicacaoSearch;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PublicacaoController implements the CRUD actions for Publicacao model.
 */
class PublicacaoController extends Controller
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
     * Lists all Publicacao models.
     * @return mixed
     */
    public function actionIndex()
    {

        $publicacoes = Publicacao::find()->orderBy(['id' => SORT_DESC])->all();

        $pagination = new Pagination(['defaultPageSize' => 10, 'totalCount' => count($publicacoes),]);

        $publicacoes = Publicacao::find()->orderBy(['id' => SORT_DESC])->offset($pagination->offset)->limit($pagination->limit)->all();

        return $this->render('index', [
            "publicacoes" => $publicacoes,
            "pagination" => $pagination,
        ]);
    }

    /**
     * Displays a single Publicacao model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Publicacao model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new Publicacao();

        $model->ciclismo_id = $id;
        $model->createtime = Yii::$app->formatter->asDateTime('now', 'yyyy-MM-dd HH-mm-ss');
        $model->save();


        $this->redirect(['index']);
    }

    /**
     * Updates an existing Publicacao model.
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
     * Deletes an existing Publicacao model.
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


    public function actionDeletec($id){
        $publicacao = Publicacao::find()->where(['ciclismo_id' => $id])->one();

        Comentario::deleteAll(['publicacao_id' => $publicacao->id]);

        /*$comentarios = Comentario::find()->where(['publicacao_id' => $publicacao->id])->all();

        foreach ($comentarios as $comentario){
            $comentario->deleteAll();
        }*/

        $publicacao->delete();

        return $this->redirect(['ciclismo/view', 'id' => $id]);

    }
    /**
     * Finds the Publicacao model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Publicacao the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Publicacao::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGosto(){
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['success' => true];
        }
    }
}
