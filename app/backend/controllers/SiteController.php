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
     * @return string|Response
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        // Recebe todos os dados que serão enviados para o menu principal da backend
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

        // ------------------------------ Número total --------------------------------------
        $numTreinos = sizeof($treinos);
        $numPublicacoes = sizeof($publicacoes);
        $numGostos = sizeof($gostos);
        $numComentarios = sizeof($comentarios);

        // -------- Foreach que faz o cálculo de todos os campos de cada atributo ------------
        foreach ($treinos as $treino){
            $velMediaTotal += $treino->velocidade_media;
            $distanciaTotal += $treino->distancia;
            $tempoTotal += $treino->duracao;
        }

        // ------------------------ Velocidade Média dos treinos ----------------------------
        // Numero de treinos a dividir pela velocidade média total
        if ($velMediaTotal != 0){
            $velMedia = $velMediaTotal / $numTreinos;
        }
        else $velMedia = 0;

        // -------------------------- Distância total dos treinos ----------------------------
        $distancia = $distanciaTotal;

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
    // Carrega a página de Login e Faz login dos administradores na backend caso já esteja a enviar os dados (POST)
    public function actionLogin()
    {
        $auth = Yii::$app->authManager;
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();

        // Se for POST e se fizer login com sucesso
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            // Verifica se o utilizador tem acesso á backend
            if($auth->checkAccess(Yii::$app->user->getId(), "backendAccess")){
                return $this->goBack();
            }else{
                // Caso contrário é enviada uma mensagem a avisar que utilizador não tem acesso á backend
                $message = "Utilizador sem acesso á backend";
                echo "<script type='text/javascript'>alert('$message');</script>";
                // Termina a sessão
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
    // Termina a sessão iniciada anteriormente e volta para a página inicial (Login)
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
