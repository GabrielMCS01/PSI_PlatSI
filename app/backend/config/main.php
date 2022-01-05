<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'name' => 'Ciclodias',
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
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_identity-backend',
                'httpOnly' => true,
            ],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/publicacao', 'pluralize' => false,
                    'extraPatterns' => [
                        'GET user' => 'user', // 'user é 'actionUser'
                    ],
                ],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/gosto', 'pluralize' => false,
                    'extraPatterns' =>[
                        'GET numgostospub/{publicacaoid}' => 'numgostospub', // 'numgostospub' e 'actionNumgostospub'
                        'GET numgostos' => 'numgostos', // 'numgostos' é 'actionNumgostos'
                        'GET numgostosuser' => 'numgostosuser', // 'numgostosuser' é 'actionNumgostosuser
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\d+>',
                        '{publicacaoid}' => '<publicacaoid:\\d+>',
                    ],
                ],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/comentario', 'pluralize' => false,
                    'extraPatterns' =>[
                      'GET getcomentpub/{publicacaoid}' => 'getcomentpub', // 'getcomentpub' é 'actionGetcomentpub'
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\d+>',
                        '{publicacaoid}' => '<publicacaoid:\\d+>',
                    ],
                ],
            ],
        ],

    ],
    'params' => $params,
];
