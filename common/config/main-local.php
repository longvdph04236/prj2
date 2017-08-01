<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=johnny.heliohost.org;dbname=samwicky_timsan',
            'username' => 'samwicky_admin',
            'password' => '18101911',
            'charset' => 'utf8',
            /*'dsn' => 'mysql:host=mysql.hostinger.vn;dbname=u107395002_db',
            'username' => 'u107395002_admin',
            'password' => '18101911',
            'charset' => 'utf8',*/
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
    ],
];
