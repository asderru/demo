<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
        '@homepage' => $params['frontendHostInfo'],
        '@defaultBlog' => $params['blogHostInfo'],
        '@blogPhoto' => $params['authorPhotoHostInfo'],
        '@backpage' => $params['backendHostInfo'],
        '@staticHost' => $params['staticHostInfo'],
        '@filesHost' => $params['filesHostInfo'],
        '@uploadHost' => $params['uploadHostInfo'],
        '@files' => $params['filesHostInfo'],
        '@samples' => $params['samplesHostInfo'],
        '@staticRoot' => $params['staticPath'],
        '@uploadRoot' => $params['uploadPath'],
        '@filesRoot' => $params['filesPath'],
    ],
    'vendorPath' => '/var/www/vendor',
    'bootstrap' => [
        'queue',
    ],
    'language' => 'ru-RU',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\MemCache',
            'useMemcached' => true,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'itemTable' => '{{%auth_items}}',
            'itemChildTable' => '{{%auth_item_children}}',
            'assignmentTable' => '{{%auth_assignments}}',
            'ruleTable' => '{{%auth_rules}}',
        ],
        'queue' => [
            'class' => 'yii\queue\redis\Queue',
            'as log' => 'yii\queue\LogBehavior',
        ],
        'formatter' => [
            'locale' => 'ru-RU',
            'timeZone' => 'Europe/Moscow',
            'dateFormat' => 'd.MM.Y',
            'timeFormat' => 'H:mm:ss',
            'datetimeFormat' => 'd.MM.Y H:mm',
            'currencyCode' => 'RUB',
            'numberFormatterSymbols' => [
                NumberFormatter::CURRENCY_SYMBOL => '₽',
            ],
        ],
    ],
];
