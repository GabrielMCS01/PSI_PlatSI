<?php

namespace backend\controllers;

use common\models\Ciclismo;
use common\models\LoginForm;
use common\models\User;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        // ------------------------ Retorna o numero total de Utilizadores ------------------
        $numUsers = 0;
        $auth = Yii::$app->authManager;

        // Recebe todos os utilizadores
        $users = User::find()->all();
        foreach ($users as $user) {
            // Se o utilizador tiver acesso á Frontend soma +1
            if($auth->checkAccess($user->getId(), "frontendAccess")){
                $numUsers++;
            }
        }
        // -------------------------------------------------------------------------------
        // ------------------------- Nº de Sessões de Treino -----------------------------
        $treinos = Ciclismo::find()->all();
        $numTreinos = sizeof($treinos);


        // Retorna a view index com todos os dados para os widgets
        return $this->render('index', ['numUsers' => $numUsers, 'numTreinos' => $numTreinos
        ]);
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        $auth = Yii::$app->authManager;
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if($auth->checkAccess(Yii::$app->user->getId(), "backendAccess")){
                return $this->goBack();
            }else{
                $message = "Utilizador sem acesso á backend";
                echo "<script type='text/javascript'>alert('$message');</script>";
                Yii::$app->user->logout();
            }
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
