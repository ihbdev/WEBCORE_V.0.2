<?php
/**
 * 
 * OrderController class file 
 * @author ihbvietnam <hotro@ihbvietnam.com>
 * @link http://iphoenix.vn
 * @copyright Copyright &copy; 2012 IHB Vietnam
 * @license http://iphoenix.vn/license
 *
 */

/**
 * OrderController includes actions relevant to Order in the eCommercial website:
 *** view
 *** delete
 *** index
 *** reverse Order's status
 *** reverse Order's process status
 *** load model
 *** perform action to list of selected models from checkbox   
 */
class OrderController extends Controller
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
				'roles'=>array('order_index'),
			),
			array('allow',  
				'actions'=>array('suggestTitle'),
				'roles'=>array('order_suggestTitle'),
			),
			array('allow',  
				'actions'=>array('reverseStatus'),
				'roles'=>array('order_reverseStatus'),
			),
			array('allow',  
				'actions'=>array('delete'),
				'roles'=>array('order_delete'),
			),
			array('allow',  
				'actions'=>array('checkbox'),
				'roles'=>array('order_checkbox'),
			),
			array('allow',  
				'actions'=>array('reverseProcessStatus'),
				'roles'=>array('order_reverseProcessStatus'),
			),
			array('deny', 
				'users'=>array('*'),
			),
		);
	}

	/**
	 * 
	 * display Order model
	 * @param integer $id, the ID of model to be viewed
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
		$this->initCheckbox('checked-order-list');
		$model=new Order('search');
		$model->unsetAttributes();  // clear any default values
		$model->status=Order::STATUS_PENDING;
		if(isset($_GET['Order'])){
			$model->attributes=$_GET['Order'];
			$model->start_time = iPhoenixTime::stringToTime($_GET['order_start_time'],'-','start');
			$model->stop_time = iPhoenixTime::stringToTime($_GET['order_stop_time'],'-','end');
		}
		$this->render('index',array(
			'model'=>$model
		));
	}
	/**
	 * Reverse processing status of order
	 * @param integer $id, the ID of model
	 */
	public function actionReverseStatus($id)
	{
		$src=Order::reverseStatus($id);
			if($src) 
				echo json_encode(array('success'=>true,'src'=>$src));
			else 
				echo json_encode(array('success'=>false));		
	}
	
	/**
	 * Reverse processing status of order
	 * @param integer $id, the ID of model
	 */
	public function actionReverseProcessStatus($id)
	{
		$src=Order::reverseProcessStatus($id);
			if($src) 
				echo json_encode(array('success'=>true,'src'=>$src));
			else 
				echo json_encode(array('success'=>false));		
	}
	
	/**
	 * Suggests title of news.
	 */
	public function actionSuggestTitle()
	{
		if(isset($_GET['q']) && ($keyword=trim($_GET['q']))!=='')
		{
			$titles=Order::model()->suggestTitle($keyword);
			if($titles!==array())
				echo implode("\n",$titles);
		}
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Order::model()->findByPk($id);
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
	 * Performs the action with multi-selected orders from checked models in section
	 * @param string action to perform
	 * @return boolean, true if the action is procced successfully, otherwise return false
	 */
	public function actionCheckbox($action)
	{
		$this->initCheckbox('checked-order-list');
		$list_checked = Yii::app()->session["checked-order-list"];
		switch ($action) {
			case 'delete' :
				if (Yii::app ()->user->checkAccess ( 'order_delete')) {
					foreach ( $list_checked as $id ) {
						$item = Order::model ()->findByPk ( $id );
						if (isset ( $item ))
							if (! $item->delete ()) {
								echo 'false';
								Yii::app ()->end ();
							}
					}
					Yii::app ()->session ["checked-order-list"] = array ();
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
	 * @param string $name_params, name of section to work	 
	 */
	public function initCheckbox($name_params) {
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

