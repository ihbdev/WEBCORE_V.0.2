<?php
/**
 * 
 * RoleController class file 
 * @author ihbvietnam <hotro@ihbvietnam.com>
 * @link http://iphoenix.vn
 * @copyright Copyright &copy; 2012 IHB Vietnam
 * @license http://iphoenix.vn/license
 *
 */

/**
 * RoleController includes actions relevant to Role:
 *** create new Role
 *** update information of a Role
 *** delete Role
 *** validate role
 *** index role
 *** write 
 *** update list order view
 *** load model Banner from banner's id
 *** perform action to list of selected banner from checkbox  
 */
class RoleController extends Controller
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
				'roles'=>array('role_index'),
			),
			array('allow',  
				'actions'=>array('create'),
				'roles'=>array('role_create'),
			),
			array('allow',  
				'actions'=>array('write'),
				'roles'=>array('role_write'),
			),
			array('allow',  
				'actions'=>array('validate'),
				'roles'=>array('role_validate'),
			),
			array('allow', 
				'actions'=>array('update'),
				'roles'=>array('role_update'),
			),
			array('allow',  
				'actions'=>array('delete'),
				'roles'=>array('role_delete'),
			),
			array('deny', 
				'users'=>array('*'),
			),
		);
	}


	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @param $type type of role, like below constant
	 */
	public function actionCreate($type)
	{
			$action="create";
			$model=new Role();			
			//Define type of role
			$model->type=$type;
			switch ($type){
				case 
				Role::TYPE_OPERATION: 
				$form='_form_operation';
				$tree='_tree_operation';
				break;
				case 
				Role::TYPE_TASK: 
				$form='_form_task';
				$tree='_tree_task';
				break;
				case 
				Role::TYPE_ROLE: 	
				$form='_form_role';
				$tree='_tree_role';
				break;			
				
			}
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			$html_tree=$this->renderPartial($tree,array(
					'list'=>$model->list_nodes,
			),true);
			
			$html_form = $this->renderPartial($form,array(
					'model'=>$model,'type'=>$type,'action'=>$action
				),true,true); 
			echo $html_form.$html_tree;
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id,$type)
	{
			$action="update";
			$model=$this->loadModel($id);
			//Define type of role
			$model->type=$type;
			switch ($type){
				case 
				Role::TYPE_OPERATION: 
				$form='_form_operation';
				$tree='_tree_operation';
				break;
				case 
				Role::TYPE_TASK: 
				$form='_form_task';
				$tree='_tree_task';
				break;
				case 
				Role::TYPE_ROLE: 	
				$form='_form_role';
				$tree='_tree_role';
				break;	
				
			}
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			$html_tree=$this->renderPartial($tree,array(
					'list'=>$model->list_nodes,
			),true);
			$html_form = $this->renderPartial($form,array(
					'model'=>$model,'type'=>$type,'action'=>$action
				),true,true); 
			echo $html_form.$html_tree;
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id,$type,$current_id)
	{
			$result=array();
			$model=$this->loadModel($id);
			//Define type of role
			$model->type=$type;
			switch ($type){
				case 
				Role::TYPE_OPERATION: 
				$form='_form_operation';
				$tree='_tree_operation';
				break;
				case 
				Role::TYPE_TASK: 
				$form='_form_task';
				$tree='_tree_task';
				break;
				case 
				Role::TYPE_ROLE: 
				$form='_form_role';
				$tree='_tree_role';
				break;	
			}
			switch ($model->checkDelete($id))	{
				case Role::DELETE_OK:		
					if($model->delete()) {
						$result['status']=true;
						if($id!=$current_id && $current_id!=0){
							$model=$this->loadModel($current_id);
							//Define type of role
							$model->type=$type;
							$action="update";
						}
						else {
							$model=new Role();
							//Define type of role
							$model->type=$type;
							$action="create";
						}
						Yii::app()->clientScript->scriptMap['jquery.js'] = false;
						$model->type=$type;
						$html_tree=$this->renderPartial($tree,array(
							'list'=>$model->list_nodes,
							),true);
						$html_form = $this->renderPartial($form,array(
							'model'=>$model,'type'=>$type,'action'=>$action
							),true,true); 
						$result['content']=$html_form.$html_tree;	
					}
					else {
						$result['status']='false';
						$action['content']='Hệ thống đang quá tải';
					}
					break;
				case Role::DELETE_HAS_CHILD:
					$result['status']= false;
					$result['content'] = "Bạn phải xóa hết các thư mục con.";
					break;
				default:
					$result['status']='false';
					$action['content']='Hệ thống đang quá tải';
					break;
			}
			echo CJSON::encode($result);
	}

	/**
	 * Validate role
	 * @param Group $type of role
	 * @return 
	 */
	public function actionValidate($type)
	{
		if(Yii::app()->getRequest()->getIsAjaxRequest())
		{
			if($_POST['id']>0){
				$model=Role::model()->findByPk($_POST['id']);
			}
			else {
				$model=new Role();
			}
			$model->type=$type;
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	/**
	 * Display list of role.
	 * @param integer $type, id of menu type
	 * @return
	 */
	public function actionIndex($type)
	{
		$model=new Role();
		$model->type=$type;
		switch ($type){
				case 
				Role::TYPE_OPERATION: 
				$form='_form_operation';
				$tree='_tree_operation';
				break;
				case 
				Role::TYPE_TASK: 
				$form='_form_task';
				$tree='_tree_task';
				break;
				case 
				Role::TYPE_ROLE: 
				$form='_form_role';
				$tree='_tree_role';
				break;	
			}
		$this->render('index',array(
			'model'=>$model,
			'type'=>$type,
			'action'=>'create'
		));
	}
	/**
	 * Creates and updates a new Role model.
	 * @param integer $type, id of menu type
	 * @return 
	 */
	public function actionWrite($type)
	{	
		if(isset($_POST['Role']))
		{
			$id=(int)$_POST['id'];
			if ( is_int($id) && $id>0){
				$action="update";
				$model=$this->loadModel($id);
			}
			else {
				$action="create";
				$model=new Role();
			}
			$model->type=$type;
			switch ($type){
				case 
				Role::TYPE_OPERATION: 
				$form='_form_operation';
				$tree='_tree_operation';
				break;
				case 
				Role::TYPE_TASK: 
				$form='_form_task';
				$tree='_tree_task';
				break;
				case 
				Role::TYPE_ROLE: 
				$form='_form_role';
				$tree='_tree_role';
				break;					
			}
			$model->attributes=$_POST['Role'];
			if(!isset($_POST['Role']['value']))
				$model->value=array();
			if($model->save()){
				if($action=="create"){
					$model=new Role();
					$model->type=$type;
				}
			}
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			$html_tree=$this->renderPartial($tree,array(
					'list'=>$model->list_nodes,
				),true)
				;
			$html_form = $this->renderPartial($form,array(
					'model'=>$model,'type'=>$type,'action'=>$action
				),true,true); 
			echo $html_form.$html_tree;
		}
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Role::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}

