<?php

use yii\i18n\PhpMessageSource;
use yii\caching\FileCache;

return [
    'name' => 'Cosh',
    'language' => 'en-US',
    'vendorPath' => dirname(__DIR__, 2) . '/vendor',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'cache' => [
            'class' => FileCache::class,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        'formatter' => [
            'class' => \yii\i18n\Formatter::class,
            'dateFormat'        => 'dd-MM-yyyy',
            'datetimeFormat'    => 'dd-MM-yyyy hh:mm:ss',
            'timeFormat'        => 'hh:mm:ss',
            'decimalSeparator'  => ',',
            'thousandSeparator' => '.',
            'currencyCode'      => 'EUR',
        ],
        // Disable caching assets in debug mode
        'assetManager' => [
            'forceCopy' => YII_DEBUG
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => PhpMessageSource::class,
                    'basePath' => '@common/translations',
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',
                    ],
                ],
                '*' => [
                    'class' => \yii\i18n\PhpMessageSource::class,
                    'basePath' => '@common/translations',
                ],
            ],
        ],
    ],
];
