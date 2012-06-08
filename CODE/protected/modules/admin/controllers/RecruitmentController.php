<?php

class RecruitmentController extends Controller
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
				'roles'=>array('recruitment_index'),
			),
			array('allow',  
				'actions'=>array('create'),
				'roles'=>array('recruitment_create'),
			),
			array('allow',  
				'actions'=>array('suggestTitle'),
				'roles'=>array('recruitment_suggestTitle'),
			),
			array('allow', 
				'actions'=>array('update'),
				'roles'=>array('recruitment_update'),
			),
			array('allow',  
				'actions'=>array('reverseStatus'),
				'roles'=>array('recruitment_reverseStatus'),
			),
			array('allow',  
				'actions'=>array('delete'),
				'roles'=>array('recruitment_delete'),
			),
			array('allow',  
				'actions'=>array('checkbox'),
				'roles'=>array('recruitment_checkbox'),
			),
			array('allow',  
				'actions'=>array('copy'),
				'roles'=>array('recruitment_copy'),
			),
			array('allow',  
				'actions'=>array('dynamicCat'),
				'roles'=>array('recruitment_dynamicCat'),
			),
			array('allow',  
				'actions'=>array('updateSuggest'),
				'roles'=>array('recruitment_updateSuggest'),
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
		$model=new Recruitment('write');
		// Ajax validate
		$this->performAjaxValidation($model);	
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Recruitment']))
		{
			$model->attributes=$_POST['Recruitment'];
			$file = CUploadedFile::getInstanceByName('Recruitment[attach]');
			if(isset($file)){
				$path=Image::createDir('upload/attach');
				if($file->saveAs($path.'/'.$file->name)) $model->attach=$path.'/'.$file->name;
			}
			if(!isset($_POST['Recruitment']['list_special'])) $model->list_special=array();
			if($model->save())
				$this->redirect(array('update','id'=>$model->id));
		}
		//Group categories that contains recruitment
		$group=new Category();		
		$group->type=Category::TYPE_RECRUITMENT;
		$list_category=$group->list_nodes;
		
		if (! Yii::app ()->getRequest ()->getIsAjaxRequest ())
				Yii::app ()->session ['checked-suggest-list'] = array();
		//Handler list suggest recruitment		
		$this->initCheckbox('checked-suggest-list');
		$suggest=new Recruitment('search');
		$suggest->unsetAttributes();  // clear any default values
		if(isset($_GET['catid'])) $suggest->catid=$model->catid;
		if(isset($_GET['SuggestRecruitment']))
			$suggest->attributes=$_GET['SuggestRecruitment'];
		//Group keyword
		$group=new Category();		
		$group->type=Category::TYPE_KEYWORD;
		$list_keyword_categories=$group->list_nodes;
		$this->render('create',array(
			'model'=>$model,
			'list_category'=>$list_category,
			'suggest'=>$suggest,
			'list_keyword_categories'=>$list_keyword_categories			
		));
	}
	/**
	 * Copy a new model
	 */
	public function actionCopy($id)
	{
		$copy=Recruitment::copy($id);
		if(isset($copy))
		{
				$this->redirect(array('update','id'=>$copy->id));
		}
	}
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$model->scenario = 'write';
		// Ajax validate
		$this->performAjaxValidation($model);	
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['Recruitment']))
		{
			$file = CUploadedFile::getInstanceByName('Recruitment[attach]');
			if(isset($file)){
				$path=Image::createDir('upload/attach');
				if($file->saveAs($path.'/'.$file->name)) $model->attach=$path.'/'.$file->name;
			}
			if(!isset($_POST['Recruitment']['list_special'])) $model->list_special=array();
			$model->attributes=$_POST['Recruitment'];
			if($model->save())
				$this->redirect(array('update','id'=>$model->id));
		}
		//Group categories that contains recruitment
		$group=new Category();		
		$group->type=Category::TYPE_RECRUITMENT;
		$list_category=$group->list_nodes;
		
		if (! Yii::app ()->getRequest ()->getIsAjaxRequest ())
				Yii::app ()->session ['checked-suggest-list'] = array_diff ( explode ( ',', $model->list_suggest ), array ('' ) );
		//Handler list suggest recruitment
		$this->initCheckbox('checked-suggest-list');
		$suggest=new Recruitment('search');
		$suggest->unsetAttributes();  // clear any default values
		if(isset($_GET['catid'])) $suggest->catid=$model->catid;
		if(isset($_GET['SuggestRecruitment']))
			$suggest->attributes=$_GET['SuggestRecruitment'];
			//Group keyword
		$group=new Category();		
		$group->type=Category::TYPE_KEYWORD;
		$list_keyword_categories=$group->list_nodes;	
		$this->render('update',array(
			'model'=>$model,
			'list_category'=>$list_category,
			'suggest'=>$suggest,
			'list_keyword_categories'=>$list_keyword_categories
		));		
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
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionCheckbox($action)
	{
		$this->initCheckbox('checked-recruitment-list');
		$list_checked = Yii::app()->session["checked-recruitment-list"];
		switch ($action) {
			case 'delete' :
				if (Yii::app ()->user->checkAccess ( 'recruitment_delete')) {
					foreach ( $list_checked as $id ) {
						$item = Recruitment::model ()->findByPk ( (int)$id );
						if (isset ( $item ))
							if (! $item->delete ()) {
								echo 'false';
								Yii::app ()->end ();
							}
					}
				} else {
					echo 'false';
					Yii::app ()->end ();
				}
				break;
			case 'copy' :
				foreach ( $list_checked as $id ) {
					$copy=Recruitment::copy((int)$id);
					if(!isset($copy))
					{
						echo 'false';
						Yii::app ()->end ();
					}
				}
				break;
		}
		echo 'true';
		Yii::app()->end();
		
	}
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->initCheckbox('checked-recruitment-list');
		$model=new Recruitment('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['catid'])) $model->catid=$_GET['catid'];
		$model->lang=Language::DEFAULT_LANGUAGE;
		if(isset($_GET['Recruitment']))
			$model->attributes=$_GET['Recruitment'];	
		//Group categories that contains recruitment
		$group=new Category();		
		$group->type=Category::TYPE_RECRUITMENT;
		$list_category=$group->list_nodes;
		//Group keyword
		$group=new Category();		
		$group->type=Category::TYPE_KEYWORD;
		$list_keyword_categories=$group->list_nodes;
		$this->render('index',array(
			'model'=>$model,
			'list_category'=>$list_category,
			'list_keyword_categories'=>$list_keyword_categories
		));
	}
	/**
	 * Reverse status of recruitment
	 */
	public function actionReverseStatus($id)
	{
		$src=Recruitment::reverseStatus($id);
			if($src) 
				echo json_encode(array('success'=>true,'src'=>$src));
			else 
				echo json_encode(array('success'=>false));		
	}
	/**
	 * Suggests title of recruitment.
	 */
	public function actionSuggestTitle()
	{
		if(isset($_GET['q']) && ($keyword=trim($_GET['q']))!=='')
		{
			$titles=Recruitment::model()->suggestTitle($keyword);
			if($titles!==array())
				echo implode("\n",$titles);
		}
	}
	/*
	 * Init checkbox
	 */
	public function initCheckbox($name_params){
		if (! isset ( Yii::app ()->session [$name_params] ))
			Yii::app ()->session [$name_params] = array ();
		if (! Yii::app ()->getRequest ()->getIsAjaxRequest () && $name_params != 'checked-suggest-list')
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
	/*
	 * List recruitment suggest 
	 */
	public function actionUpdateSuggest()
	{
		$this->initCheckbox('checked-suggest-list');
		$list_checked = Yii::app()->session["checked-suggest-list"];
		echo implode(',',$list_checked);
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Recruitment::model()->findByPk($id);
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
		if(Yii::app()->getRequest()->getIsAjaxRequest() )
		{
		if( !isset($_GET['ajax'] )  || ($_GET['ajax'] != 'recruitment-list-suggest' && $_GET['ajax'] != 'recruitment-list')){
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		}
	}
}

