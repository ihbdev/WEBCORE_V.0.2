<?php

class SiteController extends Controller
{
	/**
	 * This is the action to handle view home page
	 */
	public function actionIndex()
	{
		$this->layout="index";
		$this->render( 'index');
	}
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
			$this->layout="main";
			if ($error = Yii::app ()->errorHandler->error) {
				if (Yii::app ()->request->isAjaxRequest)
					echo $error ['message'];
				else
					$this->render( 'error', $error );
			}
	}
	/**
	 * This is the action to handle view home page
	 */
	public function actionContact()
	{
		$this->layout='right';
		$model=new Contact('create');
		if(isset($_POST['Contact'])){
			$model->attributes=$_POST['Contact'];
			if($model->save())
				Yii::app()->user->setFlash('success', Language::t('Liên hệ đã được gửi thành công'));
		}
		$this->render( 'contact' ,array('model'=>$model));
	}		
	/**
	 * This is the action to handle view home page
	 */
	public function actionHome()
	{
		$this->layout='right';
		//List products
		$criteria=new CDbCriteria;
		$criteria->compare('status', Product::STATUS_ACTIVE);
		$criteria->limit=4;
		$criteria->order='id desc';		
		$list_product=Product::model()->findAll($criteria);
		//List news
		$criteria=new CDbCriteria;
		$criteria->compare('status', Product::STATUS_ACTIVE);
		$criteria->limit=2;
		$criteria->order='id desc';		
		$list_news=News::model()->findAll($criteria);
		//Static Page
		$static_page=StaticPage::model()->findByPk(StaticPage::HOMEPAGE_ID);
		$this->render( 'home' ,array(
			'list_product'=>$list_product,
			'list_news'=>$list_news,
			'static_page'=>$static_page
			));
	}	
	/**
	 * This is the action to handle view search page
	 */
	public function actionSearch()
	{
		$search=new SearchForm();
		$criteria = new CDbCriteria ();
		if(isset($_GET['SearchForm'])){
			$search->attributes=$_GET['SearchForm'];
			$criteria->compare ( 'name', $search->name, true );
			$criteria->compare ( 'catid', $search->catid );
			if($search->end_price != '')
				$criteria->addCondition('num_price <= '.$search->end_price);
			if($search->start_price != '')
				$criteria->addCondition('num_price >= '. $search->start_price);
		}
		$criteria->order = "id DESC";
		$result=new CActiveDataProvider ( 'Product', array ('criteria' => $criteria, 'pagination' => array ('pageSize' => Setting::s('SEARCH_PAGE_SIZE','Product' ) ) ) );
		$this->render( 'search',array('result'=>$result) );
	}	
	/**
	 * This is the action to handle view home page
	 */
	public function actionLanguage($language)
	{
		Yii::app()->session['language']=$language;
		Yii::app()->request->redirect(Yii::app()->getRequest()->getUrlReferrer());
	}	
	function actionDownload($path){
		$list_element=explode('/',$path);
		$filename=end($list_element);
  		$filecontent=file_get_contents(Yii::getPathOfAlias('webroot').'/'.$path);
  		header("Content-Type: text/plain");
  		header("Content-disposition: attachment; filename=$filename");
  		header("Pragma: no-cache");
  		echo $filecontent;
  		exit;
	}
}