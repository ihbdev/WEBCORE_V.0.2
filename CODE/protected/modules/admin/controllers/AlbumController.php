<?php

class AlbumController extends Controller
{
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  
				'actions'=>array('index'),
				'roles'=>array('album_index'),
			),
			array('allow',  
				'actions'=>array('create'),
				'roles'=>array('album_create'),
			),
			array('allow',  
				'actions'=>array('suggestTitle'),
				'roles'=>array('album_suggestTitle'),
			),
			array('allow', 
				'actions'=>array('update'),
				'users'=>array('@'),
			),
			array('allow',  
				'actions'=>array('reverseStatus'),
				'roles'=>array('album_reverseStatus'),
			),
			array('allow',  
				'actions'=>array('delete'),
				'roles'=>array('album_delete'),
			),
				array('allow',  
				'actions'=>array('checkbox'),
				'roles'=>array('album_checkbox'),
			),
			array('deny', 
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Album('write');
		// Ajax validate
		$this->performAjaxValidation($model);	
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Album']))
		{
			$model->attributes=$_POST['Album'];
			if(!isset($_POST['Album']['list_special'])) $model->list_special=array();
			if($model->save())
				$this->redirect(array('update','id'=>$model->id));
		}
		//List category product
		$group=new Category();		
		$group->group=Category::GROUP_ALBUM;
		$list=$group->list_categories;
		$list_category=array();
		foreach ($list as $id=>$cat){
			$list_category[$id]=$cat;
		}
		//Group keyword
		$group=new Category();		
		$group->group=Category::GROUP_KEYWORD;
		$list_keyword_categories=$group->list_categories;
		$this->render('create',array(
			'model'=>$model,
			'list_category'=>$list_category,
			'list_keyword_categories'=>$list_keyword_categories
			
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id) {
		$model = $this->loadModel ( $id );
		if (Yii::app ()->user->checkAccess ( 'album_update', array ('album' => $model ) )) {	
		$model->scenario = 'write';
		// Ajax validate
		$this->performAjaxValidation ( $model );
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if (isset ( $_POST ['Album'] )) {
				$model->attributes = $_POST ['Album'];
				if(!isset($_POST['Album']['list_special'])) $model->list_special=array();
				if ($model->save ())
					$this->redirect ( array ('update', 'id' => $model->id ) );
			}
		//List category product
		$group=new Category();		
		$group->group=Category::GROUP_ALBUM;
		$list=$group->list_categories;
		$list_category=array();
		foreach ($list as $id=>$cat){
			$list_category[$id]=$cat;
		}
		//Group keyword
		$group=new Category();		
		$group->group=Category::GROUP_KEYWORD;
		$list_keyword_categories=$group->list_categories;
		$this->render ( 'update', array (
			'model' => $model, 
			'list_category'=>$list_category,
			'list_keyword_categories'=>$list_keyword_categories			
		));
		}
		else
			throw new CHttpException(400,'Bạn không có quyền chỉnh sửa bài viết này.');	
	}
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.		 
	 */
	public function actionIndex()
	{
		$this->initCheckbox('checked-album-list');
		$model=new Album('search');		
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Album']))
			$model->attributes=$_GET['Album'];
	//List category product
		$group=new Category();		
		$group->group=Category::GROUP_ALBUM;
		$list=$group->list_categories;
		$list_category=array();
		foreach ($list as $id=>$cat){
			$list_category[$id]=$cat;
		}
		//Group keyword
		$group=new Category();		
		$group->group=Category::GROUP_KEYWORD;
		$list_keyword_categories=$group->list_categories;
		$this->render('index',array(
			'model'=>$model,
			'list_category'=>$list_category,
			'list_keyword_categories'=>$list_keyword_categories
		));
	}
	/**
	 * Reverse status of news
	 * If reversion is successful, the Album status will be change from Pending to Active and vice verser
	 * @param integer $id the ID of the model to be Reverse
	 */
	public function actionReverseStatus($id)
	{
		$src=Album::reverseStatus($id);
			if($src) 
				echo json_encode(array('success'=>true,'src'=>$src));
			else 
				echo json_encode(array('success'=>false));		
	}
	
	/**
	 * Suggests title of news.
	 * GET keyword characters from keyboard and return the list of title similar to the keyword
	 */
	public function actionSuggestTitle()
	{
		if(isset($_GET['q']) && ($keyword=trim($_GET['q']))!=='')
		{
			$titles=Album::model()->suggestTitle($keyword);
			if($titles!==array())
				echo implode("\n",$titles);
		}
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 * @return Album which had id as $id
	 */
	public function loadModel($id)
	{
		$model=Album::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(Yii::app()->getRequest()->getIsAjaxRequest())
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	/**
	 * Performs the action with multi-selected album from checked albums in section
	 * @param string action to perform
	 * @return boolean, true if the action is procced successfully, otherwise return false
	 */
	public function actionCheckbox($action)
	{
		$this->initCheckbox('checked-album-list');
		$list_checked = Yii::app()->session["checked-album-list"];
		switch ($action) {
			case 'delete' :
				if (Yii::app ()->user->checkAccess ( 'update')) {
					foreach ( $list_checked as $id ) {
						$item = Album::model ()->findByPk ( $id );
						if (isset ( $item ))
							if (! $item->delete ()) {
								echo 'false';
								Yii::app ()->end ();
							}
					}
					Yii::app ()->session ["checked-album-list"] = array ();
				} else {
					echo 'false';
					Yii::app ()->end ();
				}
				break;
		}
		echo 'true';
		Yii::app()->end();
		
	}
	
	/**
	 * Init checkbox selection
	 * @param $name_params, name of section to work	 
	 */
	public function initCheckbox($name_params){
		if (! isset ( Yii::app ()->session [$name_params] ))
			Yii::app ()->session [$name_params] = array ();
		if (! Yii::app ()->getRequest ()->getIsAjaxRequest ())
			Yii::app ()->session [$name_params] = array ();
		else {
			if (isset ( $_POST ['list-checked'] )) {
				$list_new = array_diff ( explode ( ',', $_POST ['list-checked'] ), array ('' ) );
				$list_old = Yii::app ()->session [$name_params];
				$list = $list_old;
				foreach ( $list_new as $id ) {
					if (! in_array ( $id, $list_old ))
						$list [] = $id;
				}
				Yii::app ()->session [$name_params] = $list;
			}
			if (isset ( $_POST ['list-unchecked'] )) {
				$list_unchecked = array_diff ( explode ( ',', $_POST ['list-unchecked'] ), array ('' ) );
				$list_old = Yii::app ()->session [$name_params];
				$list = array ();
				foreach ( $list_old as $id ) {
					if (! in_array ( $id, $list_unchecked )) {
						$list [] = $id;
					}
				}
				Yii::app ()->session [$name_params] = $list;
			}
		}
	}
}

