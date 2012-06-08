<?php
/**
 * 
 * RegisterController class file 
 * @author ihbvietnam <hotro@ihbvietnam.com>
 * @link http://iphoenix.vn
 * @copyright Copyright &copy; 2012 IHB Vietnam
 * @license http://iphoenix.vn/license
 *
 */

/**
 * RegisterController includes actions relevant to Register:
 *** view register 
 *** delete register 
 *** index register
 *** reverse status 
 *** suggest title of register
 *** perform action to list of selected banner from checkbox  
 */
class RegisterController extends Controller
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
				'actions'=>array('view'),
				'roles'=>array('register_view'),
			),
			array('allow',  
				'actions'=>array('index'),
				'roles'=>array('register_index'),
			),
			array('allow',  
				'actions'=>array('suggestName'),
				'roles'=>array('register_suggestName'),
			),
			array('allow',  
				'actions'=>array('suggestEmail'),
				'roles'=>array('register_suggestEmail'),
			),
			array('allow',  
				'actions'=>array('reverseStatus'),
				'roles'=>array('register_reverseStatus'),
			),
			array('allow',  
				'actions'=>array('delete'),
				'roles'=>array('register_delete'),
			),
			array('allow',  
				'actions'=>array('checkbox'),
				'roles'=>array('register_checkbox'),
			),
			array('deny', 
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Display the register information
	 * @param integer $id, id of register model	 
	 */
	public function actionView($id)
	{
		$model=$this->loadModel($id);			
		$this->render('view',array(
			'model'=>$model
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
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->initCheckbox('checked-register-list');
		$model=new Register('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Register']))
			$model->attributes=$_GET['Register'];
		$this->render('index',array(
			'model'=>$model
		));
	}
	
	/**
	 * Suggests title of register
	 */
	public function actionSuggestName()
	{
		if(isset($_GET['q']) && ($keyword=trim($_GET['q']))!=='')
		{
			$names=Register::model()->suggestName($keyword);
			if($names!==array())
				echo implode("\n",$names);
		}
	}
	/**
	 * Suggests title of register
	 */
	public function actionSuggestEmail()
	{
		if(isset($_GET['q']) && ($keyword=trim($_GET['q']))!=='')
		{
			$emails=Register::model()->suggestEmail($keyword);
			if($emails!==array())
				echo implode("\n",$emails);
		}
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Register::model()->findByPk($id);
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
	 * Performs the action with multi-selected model from checked register in section
	 * @param string action to perform
	 * @return boolean, true if the action is procced successfully, otherwise return false
	 */	
	public function actionCheckbox($action)
	{
		$this->initCheckbox('checked-register-list');
		$list_checked = Yii::app()->session["checked-register-list"];
		switch ($action) {
			case 'delete' :
				if (Yii::app ()->user->checkAccess ( 'register_delete')) {
					foreach ( $list_checked as $id ) {
						$item = Register::model ()->findByPk ( $id );
						if (isset ( $item ))
							if (! $item->delete ()) {
								echo 'false';
								Yii::app ()->end ();
							}
					}
					Yii::app ()->session ["checked-register-list"] = array ();
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
