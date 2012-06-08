<?php
/**
 * 
 * Menu class file 
 * @author ihbvietnam <hotro@ihbvietnam.com>
 * @link http://iphoenix.vn
 * @copyright Copyright &copy; 2012 IHB Vietnam
 * @license http://iphoenix.vn/license
 *
 */

/**
 * Menu includes attributes and methods of Menu class  
 */
class Menu extends CActiveRecord
{	
	/**
	 * Config maximun rank in a group
	 */
	const MAX_RANK=4;	
	/**
	 * Config code error when delete node
	 */
	const DELETE_OK=1;
	const DELETE_HAS_CHILD=2;
	
	const CONTROLLER_DEFAULT='product';
	const ACTION_DEFAULT='index';
	/**
	 * Config code (id) of the main node groups which have parent_id=0
	 */
	const TYPE_ADVANCE_ADMIN_MENU=1;
	const TYPE_USER_MENU=2;
	const TYPE_ADMIN_MENU=3;
	const TYPE_TEST_MENU=4;
		
	private $config_other_attributes=array('params','action','controller','description','modified');	
	private $list_other_attributes;

	public $tmp_list;
	// Store old order view
	public $old_order_view;
	// Store old parent id
	public $old_parent_id;
	
	public $config_type;
	public function init(){
			parent::init();
			//Get list all language
			$configFile = Yii::app ()->theme->basePath.'/config/config_menu.php';
    		$this->config_type=require($configFile); 
	}
	/**
  	 * Get max rank
  	 */
	public function getMax_rank(){
		return $this->config_type[$this->type]['max_rank'];
	}
 	
	/**
	 * Returns all nodes in the type
	 * @return array $result all nodes in the type
	 */
	public function getList_nodes(){
		$result=array();
		$criteria=new CDbCriteria;
		$criteria->compare('type', $this->type);
		$criteria->compare('parent_id', 0);
		$criteria->order='order_view';
		$list_nodes=self::model()->findAll($criteria);	
		foreach ($list_nodes as $node){
			$result += array($node->id => 1);
			$this->tmp_list=array();
			$this->treeTraversal($node->id, 1, $this->max_rank);
			$result += $this->tmp_list;
		}
		return $result;
	}
	/**
	 * Returns all child of the node.
	 * @return array $result array of sub-nodes of this node
	 */
	public function getChild_nodes(){
		$result=array();
		$this->tmp_list=array();
		$this->treeTraversal($this->id, 0, PHP_INT_MAX);
		$result=$this->tmp_list;
		return $result;
	}
	/**
	 * Return ancestor nodes of the node 
	 * Used in bread crumb
	 * @return array ancestor array of this node
	 */
	public function getAncestor_nodes(){
		$bread_crumb=array();
		$check=true;
		$current_id=$this->id;
		while ($check){
			$current=Menu::model()->findByPk($current_id);
			$bread_crumb[]=$current_id;
			if($current->parent_id==0){
				$check=false;
			}
			else 
				$current_id=$current->parent_id;
		}
		return $bread_crumb;
	}
	
	/**
	 * Return ancestor of the node which has level 1 in the type.
	 * @return integer $current_id, the ID of root
	 */
	public function getRoot(){
		$check=true;
		$current_id=$this->id;
		while ($check){
			$current=Menu::model()->findByPk($current_id);
			if($current->parent_id==0)
			{
				$check=false;
			}
			else 
				$current_id=$current->parent_id;
		}
		return $current_id;
	}
	
	/**
	 * Returns the rank of menu 
	 * @return integer $result, the rank of this menu
	 */
	public function getRank(){
		$result=0;
		foreach ($this->child_nodes as $level){
			if($level > $result) $result=$level;
		}
		return $result;
	}
	
	/**
	 * Returns order view of brother nodes
	 * @return array $result, the array sibling of this node
	 */
	public function getList_order_view(){
		$result=array();	
		$criteria=new CDbCriteria;
		$criteria->compare('parent_id', $this->parent_id);
		$criteria->compare('type',$this->type);
		$list=Menu::model()->findAll($criteria);
		
		foreach ($list as $cat){
			$result[$cat->id]=$cat->order_view;
		}
		return $result;
	}
	
	/**
	 * Returns all nodes that can be parent of this node.
	 */
	public function getParent_nodes(){
		$result=$this->list_nodes;
		foreach ($result as $node_id=>$level){
			if($level >= $this->max_rank) unset($result[$node_id]);
		}
		$black_list=array();
		//Remove the menu
		if($this->id > 0)
			$black_list[]=$this->id;
		//Remove all child of menu
		foreach ($this->child_nodes as $node_id=>$level){
			$black_list[]=$node_id;
		}
		foreach ($black_list as $node_id) {
			unset($result[$node_id]);
		}		
		return $result;
	}
	/**
	 * Recursive algorithms for tree traversals
	 */
	public function treeTraversal($node_id,$level,$rank){
		if($node_id > 0){
			$new_level=$level+1;
			$criteria=new CDbCriteria;
			$criteria->compare('parent_id', $node_id);
			$criteria->order='order_view';
			$list_menu=Menu::model()->findAll($criteria);
			foreach ($list_menu as $menu){
				//Get route and params if type is menu
				$this->tmp_list[$menu->id]=$new_level;
				if($new_level<$rank){
					$this->treeTraversal($menu->id, $new_level, $rank);
				}
			}
		}
	}
	/*
	 * Returns the level of the node in group
	 */
	public function getLevel(){
		foreach ($this->list_nodes as $id=>$node) {
			if($this->id==$id) return $node['level'];
		}
	}
	
	/**
	 * PHP setter magic method for other attributes
	 * @param $name the attribute name
	 * @param $value the attribute value
	 * set value into particular attribute
	 */
	public function __set($name,$value)
	{
		if(in_array($name,$this->config_other_attributes))
			$this->list_other_attributes[$name]=$value;
		else 
			parent::__set($name,$value);
	}
	
	/**
	 * PHP getter magic method for other attributes
	 * @param $name the attribute name
	 * @return value of {$name} attribute
	 */
	public function __get($name)
	{
		if(in_array($name,$this->config_other_attributes))
			if(isset($this->list_other_attributes[$name])) 
				return $this->list_other_attributes[$name];
			else 
		 		return null;
		else
			return parent::__get($name);
	}
	
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Menu the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_menu';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('name,parent_id', 'required'),
			array('parent_id','validatorParent'),
			array('name', 'length', 'max'=>256),
			array('description', 'safe'),
			array('order_view','numerical'),
			array('controller,action','required'),
			array('params','safe'),
		);
	}
	
	/**
	 * Function validator role
	 */
	public function validatorMaxRank($attributes,$params){
		if($this->id > 0){
			if($this->rank>$this->max_rank) 
				$this->addError('max_rank', 'Nhóm thư mục này hiện đã vượt quá cấp mà bạn chọn.');
		}			
	}
	/**
	 * 
	 * Function validator role
	 */
	public function validatorParent($attributes,$params){
		if($this->type>0 && $this->id>0){
			$max_rank=$this->max_rank;
			$parent=Menu::model()->findByPk($this->parent_id);
			if(($parent->level+$this->rank)>=$max_rank){
				$this->addError('parent_id', 'Vượt quá cấp quy định. Bạn không thể chuyển tới thư mục này.');
			}
		}
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'author'=>array(self::BELONGS_TO,'User','created_by')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'name' => 'Tên',
			'description' => 'Miêu tả',
			'parent_id'	=> 'Thuộc',
			'max_rank'=>'Mức cấp con',
			'order_view'=>'Thứ tự hiển thị',
			'params'=>'Cấu hình tham số 3 cho URL',
			'controller'=>'Cấu hình tham số 1 cho URL',
			'action'=>'Cấu hình tham số 2 cho URL',
			'list_special' => 'Nhóm hiển thị',
			'lang'=>'Ngôn ngữ',
			'amount'=>'Số đối tượng chứa các từ khóa trên'
		);
	}
	
	/**
	 * This event is raised after the record is instantiated by a find method.
	 * @param CEvent $event the event parameter
	 */
	public function afterFind()
	{
		//Store old order view	
		if($this->order_view !=""){
			$this->old_order_view=$this->order_view;
		}
		//Store old parent id
		if($this->parent_id != ""){
			$this->old_parent_id=$this->parent_id;
		}
		//Decode attribute other to set other attributes
		$this->list_other_attributes=(array)json_decode($this->other);	
		if(isset($this->list_other_attributes['modified']))
			$this->list_other_attributes['modified']=(array)json_decode($this->list_other_attributes['modified']);
		else 
			$this->list_other_attributes['modified']=array();
		return parent::afterFind();
	}
	
	/**
	 * This method is invoked before saving a record (after validation, if any).
	 * The default implementation raises the {@link onBeforeSave} event.
	 * You may override this method to do any preparation work for record saving.
	 * Use {@link isNewRecord} to determine whether the saving is
	 * for inserting or updating record.
	 * Make sure you call the parent implementation so that the event is raised properly.
	 * @return boolean whether the saving should be executed. Defaults to true.
	 */
	public function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->isNewRecord)
			{
				$this->created_date=time();
				$this->created_by=Yii::app()->user->id;
				//Set order view
				$this->order_view=sizeof($this->list_order_view)+1;								
			}	
			else {
				$modified=$this->modified;
				$modified[time()]=Yii::app()->user->id;
				$this->modified = json_encode ( $modified );				
			}
			//Encode other attributes  		
			$this->other = json_encode ( $this->list_other_attributes );
			return true;
		} else
			return false;
	}
	/**
	 * Change order view of a node
	 * @return boolean false if it is not changed successfully
	 * otherwise, it changed the order of this node
	 */
	
	public function changeOrderView() {
		if(!isset($this->old_parent_id) || $this->old_parent_id == ""){
			$this->old_parent_id=0;
		}
			//Change order view
		if ($this->parent_id == $this->old_parent_id) {
			if ($this->order_view < $this->old_order_view) {
				foreach ( $this->list_order_view as $id => $order ) {
					if ($id != $this->id && $order >= $this->order_view) {
						$node = Menu::model ()->findByPk ( $id );
						if ($node->order_view < $this->old_order_view )
							$node->order_view = $order + 1;
						if (! $node->save ())
							return false;
					}
				}
			}
			if ($this->order_view > $this->old_order_view) {				
				foreach ( $this->list_order_view as $id => $order ) {
					if ($id != $this->id && $order <= $this->order_view) {
						$node = Menu::model ()->findByPk ( $id );
						if ($node->order_view > $this->old_order_view )
							$node->order_view = $order - 1;
						if (! $node->save ())
							return false;
					}
				}
			}
		} else {
			//Fix order view in old parent node
			$list = Menu::model ()->findAll ( 'parent_id=' . $this->old_parent_id );
			foreach ( $list as $cat ) {
				if ($cat->order_view > $this->old_order_view) {
					$cat->order_view = $cat->order_view - 1;
					if (!$cat->save ())
						return false;
				}
			}
			//Fix order view in new parent node
			foreach ( $this->list_order_view as $id => $order ) {
				if ($id != $this->id && $order >= $this->order_view) {
					$node = Menu::model ()->findByPk ( $id );
					$node->order_view = $order + 1;
					if (! $node->save ())
						return false;
				}
			}
		}
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('child_id',$this->child_id);
		$criteria->compare('other',$this->other,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	/**
	 * Recursive algorithms for tree traversals
	 */
	public function checkDelete($id){
		$list_node=Menu::model()->findAll('parent_id = '.$id);
		if(sizeof($list_node)>0){
			return self::DELETE_HAS_CHILD;
		}
		return self::DELETE_OK;
	}
	/**
	 * Config menu of node, each menu have corresponding controller/action
	 * @param string $type, controller or action
	 * @param array $value, the information of corresponding url
	 * @return array
	 */
	public function codeUrl($type,$value=array()){
		$configFile = dirname ( __FILE__ ).'/../config/'.DIRECTORY_SEPARATOR.'/menu/config_menu_controller.php';
    	$config_controller=require($configFile); 
    	$configFile = dirname ( __FILE__ ).'/../config/'.DIRECTORY_SEPARATOR.'/menu/config_menu_action.php';
    	$config_action=require($configFile); 		
		switch ($type) {
			case 'controller': 
				return $config_controller;
				break;
			case 'action':
				return $config_action[$value['controller']];				
				break;			
		}
	}
	/**
	 * Get list params for menu
	 * @param string $controller, the controller of menu
	 * @param string $action, the action of menu
	 */
	static function getListParams($controller, $action) {
		
		//Get params for action view_categories
		$configFile = dirname ( __FILE__ ).'/../config/'.DIRECTORY_SEPARATOR.'/config_categories.php';
    	$config_categories=require($configFile); 
		$result = array ();
		if ($action == 'view_categories') {
			$group = new Category ();
			foreach ($config_categories as $index=>$info){
				if($info['code']==$controller)
					$group->type=$index;
			}
			$list_node = $group->list_nodes;
			foreach ( $list_node as $id => $level ) {
				$cat = Category::model ()->findByPk ( $id );
				$index = json_encode ( array ('cat_alias' => $cat->alias ) );
				$view = "";
				for($i = 1; $i < $level; $i ++) {
					$view .= "---";
				}
				$label = $view . " " . $cat->name . " " . $view;
				$result [$index] = $label;
			}
			return $result;	
		}
		$result=array();
		switch ($controller){
			case 'menu':
				switch ($action) {
					case 'manager': 
						$result=array();
						$configFile = Yii::app ()->theme->basePath.'/config/config_menu.php';
    					$config_menu=require($configFile); 
    					foreach ($config_menu as $index=>$info){
    						$value=json_encode(array('type'=>$index));
    						$result[$value]=$info['label'];
    					}
						return $result;
				}
				break;
			case 'staticPage':
				switch ($action) {
					case 'view_page':
						$criteria=new CDbCriteria;
						$group=new Category();		
						$group->type=Category::TYPE_STATICPAGE;
						$list_category = array ();
						//Set itself
						$list_child_id [] = $cat->id;
						foreach ( $group->list_nodes as $id => $content ) {
								$list_category [] = $id;
						}
						$criteria->addInCondition('catid',$list_category);
						$criteria->compare('status',StaticPage::STATUS_ACTIVE);
						$list_page=StaticPage::model()->findAll($criteria);
						foreach ($list_page as $page){
							$index=json_encode(array('cat_alias'=>$page->category->alias,'staticPage_alias'=>$page->alias));
							$result[$index]=$page->title;
						}
						return $result;	
						break;			
					default:
						return $result;
				}
				break;
			default:
				return $result;
		}
		return $result;
	}
	
	/**
	 * Create route for url of menu
	 * @return string the corresponding url of this controller/action
	 */	
	public function getRoute(){
		$configFile = dirname ( __FILE__ ).'/../config/'.DIRECTORY_SEPARATOR.'/menu/config_menu_route.php';
    	$config_route=require($configFile); 
		if(isset($config_route [$this->controller] [$this->action]))
			return $config_route [$this->controller] [$this->action];
		else
			return '/site/home';
	}
	/**
	 * Create params for url of menu
	 * @return string, the url of menu
	 */
	public function getUrl() {	
		$configFile = dirname ( __FILE__ ).'/../config/'.DIRECTORY_SEPARATOR.'/menu/config_menu_params.php';
    	$config_params=require($configFile);	
			if ($this->params != "") {
				$params = ( array ) json_decode ( $this->params );
			} elseif (isset ( $config_params [$this->controller] [$this->action] ))
				$params = $config_params [$this->controller] [$this->action];
			if (isset ( $params ))
				$url = Yii::app ()->createUrl ( $this->route, $params );
			else
				$url = Yii::app ()->createUrl ( $this->route );				
		return $url;
	}
	/**
	 * Get active menu
	 * @return array $result, the active menu in admin board
	 */
	public function findActiveMenu(){
		$list=$this->list_nodes;	
		$result=array();
		foreach ($list as $id=>$level){
			$menu=Menu::model()->findByPk($id);
			if($menu->url== Yii::app()->request->requestUri)
			{
				$current=Menu::model()->findByPk($id);
				$result=$current->ancestor_nodes;
			}
		}
		return $result;
	}
}