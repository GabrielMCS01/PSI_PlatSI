<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'name'=>'Ciclodias',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            'class' => 'app\modules\v1\Module',
        ],
    ],
    'components' => [
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
            'csrfParam' => '_csrf-backend',
            'csrfCookie' => [
            'httpOnly' => true,
            'path' => '/admin',
            ],
        ],
        'user' => [
             'identityClass' => 'common\models\User',
        'enableAutoLogin' => true,
        'identityCookie' => [
            'name' => '_identity-backend',
            'path' => '/admin',
            'httpOnly' => true,
        ],
        ],
        'session' => [
        // this is the name of the session cookie used for login on the backend
        'name' => 'advanced-backend',
        'cookieParams' => [
            'path' => '/admin',
        ],
    ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/user', 'pluralize' => false],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/userinfo', 'pluralize' => false],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/ciclismo', 'pluralize' => false,
                    'extraPatterns' => [
                      'POST sync' => 'sync', // 'sync' é 'actionSync'

                    ],
                ],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/login', 'pluralize' => false,
                    'extraPatterns' => [
                        'POST login' => 'login', // 'login' é 'actionLogin'
                    ],
                ],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/registo', 'pluralize' => false,
                    'extraPatterns' => [
                        'POST signup' => 'signup', // 'signup' é 'actionSignup'
                    ],
                ],
            ],
        ],

    ],
    'params' => $params,
];
