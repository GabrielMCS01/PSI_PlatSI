<?php

namespace backend\controllers;

use common\models\Ciclismo;
use common\models\Comentario;
use common\models\Gosto;
use common\models\LoginForm;
use common\models\Publicacao;
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
        $publicacoes = Publicacao::find()->all();
        $gostos = Gosto::find()->all();
        $comentarios = Comentario::find()->all();
        $treinos = Ciclismo::find()->all();
        $users = User::find()->all();

        $numUsers = 0;
        $velMediaTotal = 0;
        $distanciaTotal = 0;
        $tempoTotal = 0;

        // ------------------------ Retorna o número total de Utilizadores ------------------
        $auth = Yii::$app->authManager;

        // Recebe todos os utilizadores
        foreach ($users as $user) {
            // Se o utilizador tiver acesso á Frontend soma +1
            if($auth->checkAccess($user->getId(), "frontendAccess")){
                $numUsers++;
            }
        }

        // --------------------------- Número total --------------------------------------
        $numTreinos = sizeof($treinos);
        $numPublicacoes = sizeof($publicacoes);
        $numGostos = sizeof($gostos);
        $numComentarios = sizeof($comentarios);

        // ------ Função que faz o cálculo de todos os campos de cada atributo ---------------
        // Distancia, Velocidade media e tempo total dos treinos
        foreach ($treinos as $treino){
            $velMediaTotal += $treino->velocidade_media;
            $distanciaTotal += $treino->distancia;
            $tempoTotal += $treino->duracao;
        }

        // ------------------------ Velocidade Média dos treinos ----------------------------
        // Numero de treinos a dividir pela velocidade média total
        if ($velMediaTotal != 0){
            $velMedia = round(($velMediaTotal / $numTreinos), 2);
        }
        else $velMedia = 0;

        // -------------------------- Distância total dos treinos ----------------------------
        $distancia = $distanciaTotal / 1000;
        $distancia = round($distancia, 3);

        // Tempo tem de ser convertido para Horas, dias, semanas ETC
        //$tempoTotal

        // Retorna a view index com todos os dados para os widgets
        return $this->render('index', ['numUsers' => $numUsers, 'numTreinos' => $numTreinos,
            'velMedia' => $velMedia, 'distancia' => $distancia, 'tempoTotal' => $tempoTotal,
            'numPublicacoes' => $numPublicacoes, 'numGostos' => $numGostos, 'numComentarios' => $numComentarios]);
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
