<?php

$db = require __DIR__ . '/../../config/db.php';
$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'api',
    'basePath' => dirname(__DIR__) . '/..',
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            'class' => 'app\api\modules\v1\ApiModel',
        ],
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '-sbT6_FHkfbhgJgUwuD5NF5hHZNxxd3-',
            'class' => '\yii\web\Request',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'response' => [
            'format' => yii\web\Response::FORMAT_JSON,
            'charset' => 'UTF-8',
            'on beforeSend' => function ($event) {
                $response = $event->sender;
                if ($response->data !== null && $response->statusCode === 200) {
                    $response->data = [
                        'status' => 'success',
                        'code' => $response->statusCode,
                        'data' => $response->data
                    ];
                } elseif ($response->data !== null) {
                    $response->data = [
                        'status' => 'error',
                        'code' => $response->statusCode,
                        'message' => $response->data['message'],
                    ];
                }
            },
        ],
        'user' => [
            'identityClass' => 'app\api\modules\v1\models\User',
            'enableAutoLogin' => false,
            'enableSession' => false,
        ],
//        'errorHandler' => [
//            'errorAction' => 'site/error',
//        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'logFile' => '@app/runtime/logs/api.log',
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'v1/user', 
                    'extraPatterns' => ['POST login' => 'login']
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v1/rates'],
                    'pluralize' => false,
                    'patterns' => [
                        'GET' => 'index',
                    ]
                ],              
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v1/convert'], 
                    'pluralize' => false,
                    'patterns' => [
                        'POST' => 'index'
                    ],
                ],              
                
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
