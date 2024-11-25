<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'asd',
            'baseUrl' => '',
        ],

        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
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
        'db' => $db,

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                // 'something/<controller>/<id>' => '<controller>/view',
                // 'something/<controller>' => '<controller>/view',

                // 'something/<controller>/<action>/<id:\d+>' => '<controller>/<action>',
                // 'something/<controller>/<action>' => '<controller>/<action>',
                // 'something/<controller>/new' => 'product/create',
                


                // 'something/login' => 'site/login',
                // 'something/product/new' => 'product/create',
                // 'something/product/delete/<id:\d+>' => 'product/delete',
                // 'something/product/update/<id:\d+>' => 'product/update',
                // 'something/product/<id>' => 'product/view',
                // 'something/product/file/<id:\d+>' => 'product/delete-file',
                // 'something/product/hide/<id:\d+>' => 'product/hide',
                // 'something/product/' => 'product/index',
                // 'something/01/<id:\d+>' => 'public/view',
                '/login' => 'site/login',
                '/product/delete' => 'product/delete',

                '/product/new' => 'product/create',
                '/product/delete/<id>' => 'product/delete',
                '/product/update/<id>' => 'product/update',
                '/product/<id>' => 'product/view',
                '/product/file/<id>' => 'product/delete-file',
                '/product/hide/<id>' => 'product/hide',


                // '/product/' => 'product/index',

                '/01/<id>' => 'public/view',


                'something/01/<id>' => 'public/view',

                
                'something/product/new' => 'something/product/create',
                'something/product/deactivate' => 'something/product/deactivate',
                
                'something/product/update/<id>' => 'something/product/update',

                'something/product/<id>' => 'something/product/view',

                'something/login' => 'site/login',
                'something/product/delete' => 'something/product/delete',

                'something/product/delete/<id>' => 'something/product/delete',
                'something/product/file/<id>' => 'something/product/delete-file',
                'something/product/hide/<id>' => 'something/product/hide',




            ],
        ],

    ],
     'modules' => [
        'something' => [
            'class' => 'app\modules\something\Module',
            'defaultRoute' => '/site/'
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
