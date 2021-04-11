<?php
/**
 * Created by PhpStorm.
 * User: ZyManch
 * Date: 28.02.2021
 * Time: 14:51
 */
// https://www.avsdemo.com/
return [
    'id' => 'ztrader',
    'name' => 'Trader',
    'vendorPath' => __DIR__ . '/vendor',
    'basePath' => __DIR__ . '/src',
    'timeZone' => 'Europe/Moscow',
    'language' => 'ru-RU',
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['debug'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'defaultRoute' => 'home/index',
    'controllerMap' => [
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationTable' => 'ztrader._migration',
            'interactive' => false,
        ],
    ],
    'container'=>[
        'definitions' => [
        ],
        'singletons' => [
        ]
    ],
    'modules' => [
        'debug' => [
            'class' => 'yii\debug\Module',
            'disableIpRestrictionWarning' => true,
            'allowedIPs'                  => [
                '127.0.0.1',
            ],
        ],
    ],
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=' . $secure['mysql']['mysqlcluster']['hostname'] . ';dbname=ztrader',
            'username' => $secure['mysql']['mysqlcluster']['username'],
            'password' => $secure['mysql']['mysqlcluster']['password'],
            'charset' => 'utf8',
            'enableSchemaCache' => true,
            'schemaCacheDuration' => 3600,
            'schemaCache' => 'cache',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'SESSID',
        ],
        'assetManager' => [
            'class' => 'backend\components\AssetManager',
        ],
        'user' => [
            'identityClass' => 'backend\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
            'loginUrl' => ['login/index'],
        ],
        'urlManager' => [
            //'class' => 'backend\components\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>/<id:\w+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
        'request' => [
            'csrfParam' => '_csrf-backend',
            'cookieValidationKey' => 'f1n861g104fvf-p13f1fv1cv19731c13-[mt',
        ],
    ],
    'params' => [
        'debug' => true,
        'salt_for_user'=>$secure['config']['salt_for_user']
    ]
];