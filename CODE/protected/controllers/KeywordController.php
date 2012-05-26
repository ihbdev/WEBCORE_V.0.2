<?php

class KeywordController extends Controller
{
	/**
	 * @var string the default layout for the views. 
	 */
	public $layout='main';
	public $bread_crumbs=array();

	/**
	 * This is the action to handle view search page
	 */
	public function actionList($keyword)
	{
		$list_categories=Keyword::listCategory($keyword);
		//Get list product
		$criteria = new CDbCriteria ();
		$criteria->addInCondition('keyword',$list_categories);
		$list_product=new CActiveDataProvider ( 'Product', array (
			'criteria' => $criteria, 
			'pagination' => array (
				'pageSize' => Yii::app ()->user->getState ( 'pageSize', Setting::s('DEFAULT_PAGE_SIZE','System')) 
			), 
			'sort' => array ('defaultOrder' => 'id DESC' )
			));
			
		//Get list news
		$criteria = new CDbCriteria ();
		$criteria->addInCondition('keyword',$list_categories);
		$list_news=new CActiveDataProvider ( 'News', array (
			'criteria' => $criteria, 
			'pagination' => array (
				'pageSize' => Yii::app ()->user->getState ( 'pageSize', Setting::s('DEFAULT_PAGE_SIZE','System')) 
			), 
			'sort' => array ('defaultOrder' => 'id DESC' )
			));
			
		//Get list album
		$criteria = new CDbCriteria ();
		$criteria->addInCondition('keyword',$list_categories);
		$list_album=new CActiveDataProvider ( 'Album', array (
			'criteria' => $criteria, 
			'pagination' => array (
				'pageSize' => Yii::app ()->user->getState ( 'pageSize', Setting::s('DEFAULT_PAGE_SIZE','System')) 
			), 
			'sort' => array ('defaultOrder' => 'id DESC' )
			));
			
		//Get list video
		$criteria = new CDbCriteria ();
		$criteria->addInCondition('keyword',$list_categories);
		$list_video=new CActiveDataProvider ( 'GalleryVideo', array (
			'criteria' => $criteria, 
			'pagination' => array (
				'pageSize' => Yii::app ()->user->getState ( 'pageSize', Setting::s('DEFAULT_PAGE_SIZE','System')) 
			), 
			'sort' => array ('defaultOrder' => 'id DESC' )
			));
			
		$this->render( 'list',array(
			'keyword'=>$keyword,
			'list_product'=>$list_product,
			'list_news'=>$list_news,
			'list_album'=>$list_album,
			'list_video'=>$list_video
		));
	}		
}