<?php

namespace frontend\controllers;

use common\models\Ciclismo;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\SignupForm;

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
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     *
     * Displays homepage.
     *
     * @return mixed
     */
    // Envia todos os dados para a página principal
    public function actionIndex()
    {
        $velocidademed = Ciclismo::find()->select(['user_id', 'MAX(velocidade_media) as velocidade_media'])->orderBy(['MAX(velocidade_media)' => SORT_DESC])->groupBy(['user_id'])->limit(10)->all();

        $distancias = Ciclismo::find()->select(['user_id', 'MAX(distancia) as distancia'])->orderBy(['MAX(distancia)' => SORT_DESC])->groupBy(['user_id'])->limit(10)->all();

        $tempos = Ciclismo::find()->select(['user_id', 'MAX(duracao) as duracao'])->orderBy(['MAX(duracao)' => SORT_DESC])->groupBy(['user_id'])->limit(10)->all();


        return $this->render('index', ['velocidademed' => $velocidademed, 'distancias' => $distancias, 'tempos' => $tempos]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    // Login do Utilizador/Moderador
    public function actionLogin()
    {
        $auth = Yii::$app->authManager;

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        // Recebe os dados inseridos pelo utilizador e inicia sessão (POST)
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            // Se o utilizador tiver acesso á frontend mantém a sessão iniciada e volta á pagina principal
            if($auth->checkAccess(Yii::$app->user->getId(), "frontendAccess")){
                return $this->goBack();
            // Se o utilizador tiver não tiver acesso á frontend é terminada a sessão e fica na mesma página
            }else{
                $message = "Utilizador sem acesso á frontend";
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
     * Logs out the current user.
     *
     * @return mixed
     */
    // Termina a sessão iniciada anteriormente
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    // Carrega a página de registo do utilizador
    public function actionSignup()
    {
        $model = new SignupForm();

        // Caso o pedido seja POST, carregue os dados e consiga fazer registo com sucesso
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            // Notificação na página Inicial de que a conta foi criada com sucesso
            Yii::$app->session->setFlash('success', 'Obrigado por se registar');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }
}
