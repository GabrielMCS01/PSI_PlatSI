<?php

namespace frontend\controllers;

use common\models\Comentario;
use frontend\models\ComentarioSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ComentarioController implements the CRUD actions for Comentario model.
 */
class ComentarioController extends Controller
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

                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Comentario models.
     * @return mixed
     */
    // Página para o moderador gerir todos os comentários dos utilizadores
    public function actionIndex()
    {
        // Se não tiver login e não tiver as permissões de moderador volta para a página principal
        if(Yii::$app->user->isGuest || !Yii::$app->user->can("deleteCommentModerator")){
            return $this->goHome();
        }

        // Procura todos os comentários e limita a apresentação paar 10 em cada página
        $comentarios = Comentario::find()->all();

        $pagination = new Pagination(['defaultPageSize' => 10, 'totalCount' => count($comentarios)]);

        $comentarios =  Comentario::find()->offset($pagination->offset)->limit($pagination->limit)->all();

        return $this->render('index', [
            'pagination' => $pagination,
            'comentarios' => $comentarios,
        ]);
    }

    // Pagina de todos os comentários da publicação
    public function actionIndexpost($id){
        // Se não tiver login volta para a página principal
        if(Yii::$app->user->isGuest){
            return $this->goHome();
        }

        // Procura todos os comentários pelo ID da publicação
        $comentarios = Comentario::find()->where(['publicacao_id' => $id])->all();

        $pagination = new Pagination(['defaultPageSize' => 10, 'totalCount' => count($comentarios)]);

        $comentarios =  Comentario::find()->where(['publicacao_id' => $id])->orderBy(['createtime' => SORT_DESC])->offset($pagination->offset)->limit($pagination->limit)->all();

        return $this->render('indexpost', [
            'pagination' => $pagination,
            'comentarios' => $comentarios,
            'id' => $id,
        ]);
    }
    /**
     * Displays a single Comentario model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Página para ver um comentário, que permite apagar ou editar
    public function actionView($id)
    {
        if(Yii::$app->user->isGuest){
            return $this->goHome();
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Comentario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    // Página para criar um comentário
    public function actionCreate($id)
    {
        if(Yii::$app->user->isGuest){
            return $this->goHome();
        }

        // Cria um novo comentário e preenche os dados
        $model = new Comentario();

        if ($this->request->isPost) {
            $model->publicacao_id = $id;
            $model->user_id = Yii::$app->user->getId();
            $model->createtime = Yii::$app->formatter->asDateTime('now', 'yyyy-MM-dd HH-mm-ss');
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['indexpost', 'id' => $id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'id' => $id,
        ]);
    }

    /**
     * Updates an existing Comentario model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Página para atualizar o comentário do utilizador
    public function actionUpdate($id)
    {
        if(Yii::$app->user->isGuest){
            return $this->goHome();
        }

        $model = $this->findModel($id);

        if(Yii::$app->user->can("UpdateComment", ['comentario' => $model])) {
            if ($this->request->isPost) {
                $model->load($this->request->post());
                $model->content = $model->content . ' (Editado)';
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }

            }
            return $this->render('update', [
                'model' => $model,
            ]);
        }else{
            return $this->goHome();
        }
    }

    /**
     * Deletes an existing Comentario model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Apaga o comentário do utilizador
    public function actionDelete($id)
    {
        if(Yii::$app->user->isGuest){
            return $this->goHome();
        }

        $comentario = Comentario::find()->where(['id' => $id])->one();

        if(Yii::$app->user->can("deleteCommentModerator", ['comentario' => $comentario])) {
            $id = $comentario->publicacao_id;
            $comentario->delete();
            return $this->redirect(['indexpost', 'id' => $id]);
        }else{
            return $this->goHome();
        }
    }

    // O moderador apaga o comentário de qualquer utilizador
    public function actionDeletemoderador($id)
    {
        if(Yii::$app->user->isGuest || !Yii::$app->user->can("deleteCommentModerator")){
            return $this->goHome();
        }

        $comentario = $this->findModel($id);
        $comentario->delete();

        return $this->redirect(['index']);
    }


    /**
     * Finds the Comentario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Comentario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Comentario::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
