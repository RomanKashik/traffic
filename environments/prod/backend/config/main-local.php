<?php
return [
    'id' => 'app-backend',
    'language' => 'ru',
    'sourceLanguage' => 'ru-RU',
    'defaultRoute'=>'site/index',
    'name'=>'TRAFFIC',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '',
        ],
    ],
];
