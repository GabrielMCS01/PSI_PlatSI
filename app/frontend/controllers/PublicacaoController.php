<?php

namespace frontend\controllers;

use common\models\Comentario;
use common\models\Gosto;
use common\models\Publicacao;
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
    // Página de feed de notícias que mostra todas as publicações de todos os utilizadores
    public function actionIndex()
    {
        if(Yii::$app->user->isGuest){
            return $this->goHome();
        }

        // Recebe todas as publicações e ordena-as pela mais recente
        $publicacoes = Publicacao::find()->orderBy(['createtime' => SORT_DESC])->all();

        $pagination = new Pagination(['defaultPageSize' => 10, 'totalCount' => count($publicacoes),]);

        $publicacoes = Publicacao::find()->orderBy(['createtime' => SORT_DESC])->offset($pagination->offset)->limit($pagination->limit)->all();

        return $this->render('index', [
            "publicacoes" => $publicacoes,
            "pagination" => $pagination,
        ]);
    }

    // Página das publicações do utilizador com sessão iniciada
    public function actionIndexuser(){

        if(Yii::$app->user->isGuest){
            return $this->goHome();
        }

        // Procura pelas publicações que pertençam ao utilizador
        $publicacoes = Publicacao::find()->innerJoin(['ciclismo'], 'publicacao.ciclismo_id = ciclismo.id')->where(['ciclismo.user_id' => Yii::$app->user->getId()])->orderBy(['createtime' => SORT_DESC])->all();

        $pagination = new Pagination(['defaultPageSize' => 10, 'totalCount' => count($publicacoes),]);

        // Procura pelas publicações que pertençam ao utilizador colocando a paginação correta
        $publicacoes = Publicacao::find()->innerJoin(['ciclismo'], 'publicacao.ciclismo_id = ciclismo.id')->where(['ciclismo.user_id' => Yii::$app->user->getId()])->orderBy(['createtime' => SORT_DESC])->offset($pagination->offset)->limit($pagination->limit)->all();

        return $this->render('indexuser', [
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
    // Página para visualizar uma publicação
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
    // Cria uma publicação
    public function actionCreate($id)
    {
        if(Yii::$app->user->isGuest){
            return $this->goHome();
        }

        $model = new Publicacao();

        $model->ciclismo_id = $id;
        $model->createtime = Yii::$app->formatter->asDateTime('now', 'yyyy-MM-dd HH-mm-ss');
        $model->save();

        // Volta para a página com todas as publicações
        $this->redirect(['index']);
    }

    /**
     * Deletes an existing Publicacao model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Apaga a publicação pelo feed de noticias/ Suas publicações
    public function actionDelete($id)
    {
        $publicacao = Publicacao::find()->where(['ciclismo_id' => $id])->one();

        Comentario::deleteAll(['publicacao_id' => $publicacao->id]);
        Gosto::deleteAll(['publicacao_id' => $publicacao->id]);

        $publicacao->delete();

        return $this->redirect(['index']);
    }

    // Apaga a publicação pelo histórico de treino
    public function actionDeletec($id){
        $publicacao = Publicacao::find()->where(['ciclismo_id' => $id])->one();

        Comentario::deleteAll(['publicacao_id' => $publicacao->id]);
        Gosto::deleteAll(['publicacao_id' => $publicacao->id]);

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

}
