<?php

class AdminModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'admin.models.*',
			'admin.components.*',
		));
		if (!isset ( Yii::app ()->session ['view'] )) 
			Yii::app ()->session ['view']='basic';
		else 
		{
			if (Yii::app ()->session ['view'] != 'advance')
				Yii::app ()->session ['view']='basic';
		}
		//Configure layout path of modules Admin
		$this->viewPath = Yii::getPathOfAlias('admin.views.'.Yii::app ()->session ['view']);
	}
	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
				Yii::app()->language=Language::DEFAULT_LANGUAGE;
			return true;
		}
		else
			return false;
	}
}
