<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Pannónia Néptáncegyüttes',

	// preloading 'log' component
	'preload'=>array(
		'log',
		'bootstrap',
	),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.modules.*',
	),

	'modules'=>array(

		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'enter  the  gii',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		
		'liveMigration',
		
        'gallery',
		
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		*/

		'db'=>array(
			'connectionString'	=> 'mysql:host=localhost;dbname=pannonia_test',
			'emulatePrepare'	=> true,
			'username'			=> 'root',
			'password'			=> '',
			'charset'			=> 'utf8',
		),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				array(
					'class'			=> 'application.modules.gallery.extensions.ai-logger.AiLogRoute',
					'categories'	=> array(
										'AiLog.*',
										'php',
										'exception.*'
									),
				),
				// uncomment the following to show log messages on web pages
				
				array(
					'class'		=> 'CWebLogRoute',
					'enabled'	=> false,
				),
				
			),
		),
		
		'clientScript'=>array(
            'packages'=>array(
                'jquery'=>array(
                    'baseUrl'=>'//ajax.googleapis.com/ajax/libs/jquery/2.0.3/',
                    'js'=>array('jquery.min.js'),
                ),
                'jquery.ui'=>array(
                    'baseUrl'=>'//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/',
                    'js'=>array('jquery-ui.min.js'),
                ),
            ),
        ),
		
		'bootstrap' => array(
			'class' => 'ext.yii-booster.components.Bootstrap',
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);