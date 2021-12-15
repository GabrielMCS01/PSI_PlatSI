<?php

namespace backend\controllers;

use common\models\AuthAssignment;
use common\models\AuthItem;
use common\models\UserInfo;
use Yii;
use common\models\User;
use common\models\UserSearch;
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
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $auth_model = AuthAssignment::find()->where(['user_id' => $id])->one();
        $role_name = $auth_model->item_name;

        $user_info = UserInfo::find()->where(['user_id' => $id])->one();

        return $this->render('view', [
            'model' => $this->findModel($id), 'role_name' => $role_name, 'user_info' => $user_info
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $roles = AuthItem::find()->select(['name'])->where(['type' => 1])->all();
        $auth_model = AuthAssignment::find()->where(['user_id' => $id])->one();
        $role_name = $auth_model->item_name;

        $user_info = UserInfo::find()->where(['user_id' => $id])->one();

        // Receber cada post individualmente (variaveis e atribuir aos devidos models)
        if (Yii::$app->request->isPost) {

            $user_info->load(Yii::$app->request->post());
            $auth_model->load(Yii::$app->request->post());

            $auth_model->item_name = $roles[$auth_model->item_name]->name;

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
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
