<?php
return [
    'language' => 'ru-RU',
    'sourceLanguage' => 'ru-RU',
    'timeZone' => 'Europe/Moscow',
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=traffic',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
        ],
    ],
    'modules' => [
        'gridview' => [
            'class' => 'kartik\grid\Module',
            'downloadAction' => 'gridview/export/download',

            // other module settings
        ],
        'tracking' => [
            'class' => 'common\modules\tracking\Module',
        ],
    ],
];
