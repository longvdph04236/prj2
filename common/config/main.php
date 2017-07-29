<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'sms' => [
            'class' => 'miserenkov\sms\Sms',
            'gateway' => 'smscentre.com',     // gateway, through which will sending sms, default 'smsc.ua'
            'login' => 'samwicky',              // login
            'password' => '18101911',           // password or lowercase password MD5-hash
            'senderName' => 'yeu bong da',         // sender name
            'options' => [
                'useHttps' => true,     // use secure HTTPS connection, default true
            ],
        ],
    ],
];
