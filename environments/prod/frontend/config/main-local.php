<?php
return [
    'language' => 'ru-RU',
    'sourceLanguage' => 'ru-RU',
    'name'=>'TRAFFIC',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
            'authTimeout'=>1200,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
    ],
];
