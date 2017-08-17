<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'defaultRoute' => 'home/',
    'components' => [
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => '130033160929313',
                    'clientSecret' => '67a6ba73955ce4aebb1a986d7f869fd7',
                ],
            ],
        ],
        'i18n' => [
            'translations' => [
                'file-input*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => dirname(__FILE__).'/../vendor/2amigos/yii2-file-input-widget/src/messages/',
                ],
            ],
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'class' => 'common\components\Request',
            'web'=> '/frontend/web',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
                'san-bong/chi-tiet/<id:.+>' => 'san-bong/index',
                'san-bong/xoa/<id:\d+>/<s:\d+>' => 'san-bong/xoa',
                'san-bong/xoa-lich/<id:\d+>/' => 'san-bong/xoa-lich',
                'san-bong/sua/<id:\d+>/' => 'san-bong/sua',
                'quan-ly-san/xoa/<id:\d+>' => 'quan-ly-san/xoa'
            ],
        ],
        'assetManager' => [
            'bundles' => [
                'dosamigos\google\maps\MapAsset' => [
                    'options' => [
                        'key' => 'AIzaSyCyyQrlF4nWCZT_x7GC0Syh5jsdcJXzoqw',
                        'language' => 'vn',
                        'version' => '3.1.18'
                    ]
                ]
            ]
        ],

    ],
    'params' => $params,
];
