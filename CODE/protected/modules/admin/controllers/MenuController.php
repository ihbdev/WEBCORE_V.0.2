<?php
/**
 * 
 * MenuController class file 
 * @author ihbvietnam <hotro@ihbvietnam.com>
 * @link http://iphoenix.vn
 * @copyright Copyright &copy; 2012 IHB Vietnam
 * @license http://iphoenix.vn/license
 *
 */

/**
 * MenuController includes actions relevant to Menu:
 *** create new Menu
 *** update information of a Menu
 *** delete Menu
 *** validate menu
 *** index menu
 *** write 
 *** update list order view
 *** load model Banner from banner's id
 *** perform action to list of selected banner from checkbox  
 */
class MenuController extends Controller
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
				'roles'=>array('menu_index'),
			),
			array('allow',  
				'actions'=>array('create'),
				'roles'=>array('menu_create'),
			),
			array('allow',  
				'actions'=>array('write'),
				'roles'=>array('menu_write'),
			),
			array('allow',  
				'actions'=>array('validate'),
				'roles'=>array('menu_validate'),
			),
			array('allow', 
				'actions'=>array('update'),
				'roles'=>array('menu_update'),
			),
			array('allow',  
				'actions'=>array('updateListOrderView'),
				'roles'=>array('menu_updateListOrderView'),
			),
			array('allow',  
				'actions'=>array('delete'),
				'roles'=>array('menu_delete'),
			),
			array('allow',  
				'actions'=>array('configUrl'),
				'roles'=>array('menu_configUrl'),
			),
			array('allow',  
				'actions'=>array('setActiveAdminMenu'),
				'roles'=>array('menu_setActiveAdminMenu'),
			),
			array('deny', 
				'users'=>array('*'),
			),
		);
	}


	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @param $type type of menu, like below constant
	 */
	public function actionCreate($type)
	{
			$action="create";
			$model=new Menu();
			$model->type=$type;			
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			$html_tree=$this->renderPartial('_tree',array(
					'list_nodes'=>$model->list_nodes,
			),true);
			
			$html_form = $this->renderPartial('_form',array(
					'model'=>$model,'action'=>$action
				),true,true); 
			echo $html_form.$html_tree;
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
			$action="update";
			$model=$this->loadModel($id);			
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			$html_tree=$this->renderPartial('_tree',array(
					'list_nodes'=>$model->list_nodes,
			),true);
			$html_form = $this->renderPartial('_form',array(
					'model'=>$model,'action'=>$action
				),true,true); 
			echo $html_form.$html_tree;
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id,$current_id)
	{
			$result=array();
			$model=$this->loadModel($id);
			$type=$model->type;
			switch ($model->checkDelete($id))	{
				case Menu::DELETE_OK:		
					if($model->delete()) {
						$result['status']=true;
						if($id!=$current_id && $current_id!=0){
							$model=$this->loadModel($current_id);
							$action="update";
						}
						else {
							$model=new Menu();
							$model->type=$type;
							$action="create";
						}
						Yii::app()->clientScript->scriptMap['jquery.js'] = false;
						$html_tree=$this->renderPartial('_tree',array(
							'list_nodes'=>$model->list_nodes,
							),true);
						$html_form = $this->renderPartial('_form',array(
							'model'=>$model,'action'=>$action
							),true,true); 
						$result['content']=$html_form.$html_tree;	
					}
					else {
						$result['status']='false';
						$action['content']='Hệ thống đang quá tải';
					}
					break;
				case Menu::DELETE_HAS_CHILD:
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
	 * Validate menu
	 * @param Group $type of menu
	 * @return 
	 */
	public function actionValidate()
	{
		if(Yii::app()->getRequest()->getIsAjaxRequest())
		{
			if($_POST['id']>0){
				$model=Menu::model()->findByPk($_POST['id']);
			}
			else {
				$model=new Menu();
			}
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	/**
	 * Display list of menu.
	 * @param integer $type, id of menu type
	 * @return
	 */
	public function actionIndex($type)
	{
		$model=new Menu();
		$model->type=$type;
		$this->render('index',array(
			'model'=>$model,
			'type'=>$type,
			'action'=>'create'
		));
	}
	/**
	 * Creates and updates a new Menu model.
	 * @param integer $type, id of menu type
	 * @return 
	 */
	public function actionWrite($type)
	{	
		if(isset($_POST['Menu']))
		{
			$id=(int)$_POST['id'];
			if ( is_int($id) && $id>0){
				$action="update";
				$model=$this->loadModel($id);
			}
			else {
				$action="create";
				$model=new Menu();
				$model->type=$type;
			}			
			$model->attributes=$_POST['Menu'];
			if(!isset($_POST['Menu']['params'])){
				$model->params="";
			}
			if($model->save()){	
				if($action == 'update') $model->changeOrderView();			
				if($action=="create"){
					$model=new Menu();
					$model->type=$type;
				}
			}
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			$html_tree=$this->renderPartial('_tree',array(
					'list_nodes'=>$model->list_nodes,
				),true)
				;
			$html_form = $this->renderPartial('_form',array(
					'model'=>$model,'action'=>$action
				),true,true); 
			echo $html_form.$html_tree;
		}
	}
	
	/**
	 * Updates list order view.
	 * @param integer $parent_id id of parent menu
	 */
	public function actionUpdateListOrderView($parent_id)
	{	
		$list=Menu::model()->findAll('parent_id='.$parent_id);
		$max_order=sizeof($list)+1;
		echo $max_order;
	}
	/**
	 * Updates list params that create url for menus
	 * @param integer $id, id of model
	 * @param controller $controller, controller of url
	 * @param action $action, action of url
	 */
	public function actionConfigUrl($id,$controller,$action)
	{
		$model= new Menu();
		if(isset($_GET['type']))
			$model->type=$_GET['type'];
		$list_action = $model->codeUrl ( 'action', array ('controller' => $controller ) );
		$result ['list_action'] = $list_action;
		$key = array_keys ( $list_action );
		$select_action = $key ['0'];
		$select_param="";
		if ($id > 0) {
			$model = Menu::model ()->findByPk ( $id );
			if (isset ( $model->controller ) && $model->controller == $controller) {
				if (isset ( $model->action )) {
					if($action == "")
					{
						$select_action = $model->action;
						$action=$select_action;
					}
					else {
						if ($model->action == $action) {
							$select_param = $model->params;
						} 
					}
				} 
			}
		}
		if($action == "") $action=$key['0'];
		$list_params = Menu::getListParams ( $controller, $action );
		$result = array ();
		$result ['count'] = sizeof ( $list_params );
		$result ['list_params'] = $list_params;
		$result ['list_action'] = $list_action;
		$result ['selected_params'] = $select_param;
		$result ['selected_action'] = $select_action;
		echo json_encode ( $result );
	}
	

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Menu::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}

