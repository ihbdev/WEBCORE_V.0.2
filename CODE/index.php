<?php
// change the following paths if necessary
$yii = dirname ( __FILE__ ) . '/framework/yiilite.php';
$config = dirname ( __FILE__ ) . '/protected/config/main.php';

// remove the following lines when in production mode
defined ( 'YII_DEBUG' ) or define ( 'YII_DEBUG', true );
// specify how many levels of call stack should be shown in each log message
defined ( 'YII_TRACE_LEVEL' ) or define ( 'YII_TRACE_LEVEL', 3 );

require_once ($yii);
$app = Yii::createWebApplication ( $config );
Yii::setPathOfAlias ( 'theme', Yii::app ()->theme->basePath );
if (isset ( Yii::app ()->controller->module->id ) && Yii::app ()->controller->module->id != 'admin' && isset ( Yii::app ()->session ['language'] ))
	Yii::app ()->language = Yii::app ()->session ['language'];
$app->run ();
