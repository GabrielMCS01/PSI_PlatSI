<?php

namespace backend\controllers;

use common\models\AuthAssignment;
use common\models\AuthItem;
use common\models\Ciclismo;
use common\models\Comentario;
use common\models\Gosto;
use common\models\Publicacao;
use common\models\UserInfo;
use Yii;
use common\models\User;
use common\models\UserSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */

    public function actionIndex()
    {
        if(Yii::$app->user->isGuest){
            return $this->goHome();
        }

        // Encontra todos os nomes das roles possiveis de se selecionar
        $roles = AuthItem::find()->select(['name'])->where(['type' => 1])->all();

        // Para cada role preeche no array com dados da devida query á BD
        for($i = 0; $i < count($roles); $i++){
            // Procura todos os utilizadores para cada tipo de Role
            $dataProvider[$i] = new ActiveDataProvider([
                'query' => User::find()->innerJoin(['auth_assignment'], 'user.id = auth_assignment.user_id')->where(['auth_assignment.item_name' => $roles[$i]])->orderBy(['user.id' => SORT_ASC]),
                'pagination' => [
                    'pageSize' => 10
                ]
            ]);
        }

        $searchModel = new UserSearch();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'roles' => $roles,
        ]);
    }

    /**
     * Displays a single User model.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Mostra os dados mais relevantes do utilizador selecionado
    public function actionView($id)
    {
        if(Yii::$app->user->isGuest){
            return $this->goHome();
        }

        // Pesquisa as informações do utilizador selecionado
        $user_info = UserInfo::find()->where(['user_id' => $id])->one();

        return $this->render('view', [
            'model' => $this->findModel($id), 'user_info' => $user_info
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Carrega a página ou atualiza os dados do utilizador dependendo do pedido feito
    public function actionUpdate($id)
    {
        if(Yii::$app->user->isGuest){
            return $this->goHome();
        }

        // Encontra o utilizador pelo ID
        $model = $this->findModel($id);

        // Pesquisa todos os tipos de roles possiveis de serem selecionadas
        $roles = AuthItem::find()->select(['name'])->where(['type' => 1])->all();

        // Pesquisa o nome da role do utilizador selecionado
        $auth_model = AuthAssignment::find()->where(['user_id' => $id])->one();
        $role_name = $auth_model->item_name;

        // Pesquisa os dados extra do utilizador selecionado
        $user_info = UserInfo::find()->where(['user_id' => $id])->one();

        // Recebe os dados individualmente (variaveis e atribuir aos devidos models)
        if (Yii::$app->request->isPost) {

            $user_info->load(Yii::$app->request->post());
            $auth_model->load(Yii::$app->request->post());

            // Escreve o nome da nova role
            $auth_model->item_name = $roles[$auth_model->item_name]->name;

            // Se guardar com sucesso é redirecionado para a página de visualização do utilizador
            if($auth_model->save() && $user_info->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model, 'auth_model' => $auth_model ,'role_name' => $role_name, 'user_info' => $user_info, 'roles' => $roles
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Apaga o utilizador selecionado
    public function actionDelete($id)
    {
        // Recebe o utilizador com o ID
        $user = User::findOne($id);

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
        $user = User::findOne($id);

        // Caso tenha sido apagado é redirecionado para a página de utilizadores
        if($user == null){
            return $this->redirect(['index']);
        }

        // Caso tenha ocorrido algum erro o user fica na página do utilizador selecionado
        return $this->redirect(['view']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
