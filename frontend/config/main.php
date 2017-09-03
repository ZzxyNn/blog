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
	'language'=>'zh-CN',
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
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
		
		//url地址美化
		'urlManager'=>[
			'enablePrettyUrl'=>true,	//对url进行美化
			'showScriptName'=>false,	//隐藏index.php
			'suffix'=>'.html',
			'rules'=>[
					'<controller:\w+>/<id:\d+>'=>'<controller>/view',
			]
		],
		
		//语言包配置
		'i18n' => [
    		'translations' => [
    			'*' => [
        			'class' => 'yii\i18n\PhpMessageSource',
            		//'basePath' => '/messages',
            		'fileMap' => [
                		'common' => 'common.php',
                		'test' => 'test.php'
             		],
        		],
    		],
		],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => [ 'warning'],
                ],
            	[
	            	'class' => 'yii\log\FileTarget',
	            	'levels' => ['error'],
	            	'logVars'=>['_GET'],
	            	'logFile' => '@app/runtime/logs/test.log',
	            	'maxFileSize' => 1024 * 2,
	            	'maxLogFiles' => 20,
            	],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
];
