<?php
/**
 * 
 * Role class file 
 * @author ihbvietnam <hotro@ihbvietnam.com>
 * @link http://iphoenix.vn
 * @copyright Copyright &copy; 2012 IHB Vietnam
 * @license http://iphoenix.vn/license
 *
 */

/**
 * Role includes attributes and methods of Role class  
 */
class Role extends CActiveRecord
{	
	/**
	 * Config maximun rank in a type
	 */
	const MAX_RANK=4;	
	/**
	 * Config code error when delete role
	 */
	const DELETE_OK=1;
	const DELETE_HAS_CHILD=2;
	const DELETE_HAS_ITEMS=3;
	/**
	 * Config code (id) of the main role types which have parent_id=0
	 */
	const TYPE_OPERATION=1;
	const TYPE_TASK=2;
	const TYPE_ROLE=3;

	/**
	 * @var array config list other attributes of the banner
	 * these attributes is stored in other field of article table	 
	 */
	
	private $config_other_attributes=array('description','value','modified','bizRule');	
	private $list_other_attributes;
	
	// Template var that store data when tree traversal
	public $tmp_list;
	// Store old parent id
	public $old_parent_id;
	//Store old value
	public $old_value;
	//Store old name
	public $old_name;
	//Store old biz rule
	public $old_bizRule;
	
	public $list_max_rank=array(
		self::TYPE_OPERATION=>2,
		self::TYPE_ROLE=>3,
		self::TYPE_TASK=>3,
	);
  	/**
  	 * Get max rank
  	 */
	public function getMax_rank(){
		$list_max_rank=$this->list_max_rank;
		return $list_max_rank[$this->type];
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
		$criteria->order='category';
		$list_roles=self::model()->findAll($criteria);	
		foreach ($list_roles as $role){
			$result += array($role->id => 1);
			$this->tmp_list=array();
			$this->treeTraversal($role->id, 1, $this->max_rank);
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
	 * Return ancestor nodes of the role 
	 * Used in bread crumb
	 * @return array $bread_crumb ancestor array of this role
	 */
	public function getBread_crumb(){
		$bread_crumb=array();
		$check=true;
		$current_id=$this->id;
		while ($check){
			$current=Role::model()->findByPk($current_id);
			$bread_crumb[]=$current_id;
			if(in_array($current->parent_id,array(Role::TYPE_OPERATION,Role::TYPE_TASK,Role::TYPE_ROLE))){
				$check=false;
			}
			else 
				$current_id=$current->parent_id;
		}
		return $bread_crumb;
	}
	
	/**
	 * Return ancestor of the role which has level 1 in the role type.
	 * @return integer $current_id, the ID of root role
	 */
	public function getRoot(){
		$check=true;
		$current_id=$this->id;
		while ($check){
			$current=Role::model()->findByPk($current_id);
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
	 * Returns the rank of role 
	 * @return integer $result, the rank of this role
	 */
	public function getRank(){
		$result=0;
		foreach ($this->child_nodes as $level){
			if($level > $result) $result=$level;
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
		//Remove the role
		$black_list[]=$this->id;
		//Remove all child of role
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
			$list_role=Role::model()->findAll($criteria);
			foreach ($list_role as $role){
				//Get route and params if type is menu
				$this->tmp_list[$role->id]=$new_level;
				if($new_level<$rank){
					$this->treeTraversal($role->id, $new_level, $rank);
				}
			}
		}
	}
	/*
	 * Returns the level of the role in type
	 */
	public function getLevel(){
		foreach ($this->list_nodes as $id=>$role) {
			if($this->id==$id) return $role['level'];
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
	 * @return Role the static model class
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
		return 'tbl_role';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('name', 'required'),
			array('name','unique'),
			array('value','safe'),
			array('parent_id','validatorParent'),
			array('name', 'length', 'max'=>64),
			array('description,bizRule,category','safe')
			
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
			$parent=Role::model()->findByPk($this->parent_id);
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
			'author'=>array(self::BELONGS_TO,'User','created_by'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'name' => 'Tên',
			'parent_id'	=> 'Thuộc',
			'max_rank'=>'Mức cấp con',
			'value'=>'Gán quyền',
			'description'=>'Miêu tả',
			'category'=>'Nhóm'
		);
	}
	
	/**
	 * This event is raised after the record is instantiated by a find method.
	 * @param CEvent $event the event parameter
	 */
	public function afterFind()
	{
		//Store old parent id
		if($this->parent_id != ""){
			$this->old_parent_id=$this->parent_id;
		}
		//Decode attribute other to set other attributes
		$this->list_other_attributes=(array)json_decode($this->other);
		$this->old_value=$this->value;
		$this->old_name=$this->name;	
		$this->old_bizRule=$this->bizRule;
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
			}	
			else {
				$modified=$this->modified;
				$modified[time()]=Yii::app()->user->id;
				$this->modified = json_encode ( $modified );				
			}
			if($this->type == Role::TYPE_OPERATION){
				if($this->old_name != $this->name){
					$auth = Yii::app ()->authManager;
					if($this->old_name != '')
						$auth->removeAuthItem($this->old_name);
					$operation=$auth->createOperation ( $this->name, $this->description );	
					$command=Yii::app()->db->createCommand('UPDATE authitem SET name = "'.$this->name.'" WHERE name = "'.$this->old_name.'"');
					$command->execute();
					$command=Yii::app()->db->createCommand('UPDATE authitemchild SET parent = "'.$this->name.'" WHERE parent = "'.$this->old_name.'"');
					$command->execute();
					$command=Yii::app()->db->createCommand('UPDATE authitemchild SET child = "'.$this->name.'" WHERE child = "'.$this->old_name.'"');		
					$command->execute();
					$command=Yii::app()->db->createCommand('UPDATE authassignment SET itemname = "'.$this->name.'" WHERE itemname = "'.$this->old_name.'"');	
					$command->execute();								
				}
				if($this->old_bizRule != $this->bizRule){
					$auth = Yii::app ()->authManager;
					$auth->removeAuthItem($this->name);
					$operation=$auth->createOperation ( $this->name, $this->description, $this->bizRule );				
				}
				if($this->old_parent_id != $this->parent_id){
					$auth = Yii::app ()->authManager;					
					$parent_operation=Role::model()->findByPk($this->parent_id);
					if(isset($parent_operation))
					{
						$parent_operation=$auth->getAuthItem($parent_operation->name);
						$parent_operation->addChild ( $this->name );
					}
					$old_parent_operation=Role::model()->findByPk($this->old_parent_id);
					if(isset($old_parent_operation))
					{
						$old_parent_operation=$auth->getAuthItem($old_parent_operation->name);
						$old_parent_operation->removeChild ( $this->name );
					}
				}	
			}		
			if($this->type == Role::TYPE_TASK){
				if($this->old_name != $this->name){
					$auth = Yii::app ()->authManager;
					if($this->old_name != '')	$auth->removeAuthItem($this->old_name);
					$task=$auth->createTask ( $this->name, $this->description );					
					$command=Yii::app()->db->createCommand('UPDATE authitem SET name = "'.$this->name.'" WHERE name = "'.$this->old_name.'"');
					$command->execute();
					$command=Yii::app()->db->createCommand('UPDATE authitemchild SET parent = "'.$this->name.'" WHERE parent = "'.$this->old_name.'"');
					$command->execute();
					$command=Yii::app()->db->createCommand('UPDATE authitemchild SET child = "'.$this->name.'" WHERE child = "'.$this->old_name.'"');		
					$command->execute();
					$command=Yii::app()->db->createCommand('UPDATE authassignment SET itemname = "'.$this->name.'" WHERE itemname = "'.$this->old_name.'"');	
					$command->execute();
				}	
				if($this->old_value != $this->value){
					$auth = Yii::app ()->authManager;
					$task=$auth->getAuthItem($this->name);
					if($this->old_value != null)
						foreach ($this->old_value as $operation_id){
							$operation=Role::model()->findByPk($operation_id);
							$task->removeChild ( $operation->name );
						}	;
					foreach ($this->value as $operation_id){
						$operation=Role::model()->findByPk($operation_id);
						$task->addChild ( $operation->name );
					}	
				}	
				if($this->old_parent_id != $this->parent_id){
					$auth = Yii::app ()->authManager;
					$parent_task=Role::model()->findByPk($this->parent_id);
					if(isset($parent_task))
					{
						$parent_task=$auth->getAuthItem($parent_task->name);
						$parent_task->addChild ( $this->name );
					}
					$old_parent_task=Role::model()->findByPk($this->old_parent_id);
					if(isset($old_parent_task))
					{
						$old_parent_task=$auth->getAuthItem($old_parent_task->name);
						$old_parent_task->removeChild ( $this->name );
					}
				}				
			}	
			if($this->type == Role::TYPE_ROLE){
				if($this->old_name != $this->name){
					$auth = Yii::app ()->authManager;
					if($this->old_name != '')
					$auth->removeAuthItem($this->old_name);
					$role=$auth->createRole ( $this->name, $this->description );
					$command=Yii::app()->db->createCommand('UPDATE authitem SET name = "'.$this->name.'" WHERE name = "'.$this->old_name.'"');
					$command->execute();
					$command=Yii::app()->db->createCommand('UPDATE authitemchild SET parent = "'.$this->name.'" WHERE parent = "'.$this->old_name.'"');
					$command->execute();
					$command=Yii::app()->db->createCommand('UPDATE authitemchild SET child = "'.$this->name.'" WHERE child = "'.$this->old_name.'"');		
					$command->execute();
					$command=Yii::app()->db->createCommand('UPDATE authassignment SET itemname = "'.$this->name.'" WHERE itemname = "'.$this->old_name.'"');	
					$command->execute();
				}	
				if($this->old_value != $this->value){
					$auth = Yii::app ()->authManager;
					$role=$auth->getAuthItem($this->name);
					if($this->old_value != null)
						foreach ($this->old_value as $task_id){
							$task=Role::model()->findByPk($task_id);
							$role->removeChild ( $task->name );
						}	
					foreach ($this->value as $task_id){
						$task=Role::model()->findByPk($task_id);
						$role->addChild ( $task->name );
					}	
				}
				if($this->old_parent_id != $this->parent_id){
					$auth = Yii::app ()->authManager;
					$parent_role=Role::model()->findByPk($this->parent_id);
					if(isset($parent_role))
					{
						$parent_role=$auth->getAuthItem($parent_role->name);
						$parent_role->addChild ( $this->name );
					}
					$old_parent_role=Role::model()->findByPk($this->old_parent_id);
					if(isset($old_parent_role))
					{
						$old_parent_role=$auth->getAuthItem($old_parent_role->name);
						$old_parent_role->removeChild ( $this->name );
					}
				}					
			}				
			$this->other = json_encode ( $this->list_other_attributes );
			return true;
		} else
			return false;
	}
	/**
	 * Check delete
	 */
	public function beforeDelete(){
		if (parent::beforeDelete ()) {
				$command = Yii::app()->db->createCommand();
				$command->delete('authitem','name=:name', array(':name'=>$this->name));
				$command->delete('authitemchild','parent=:parent OR child=:child',array(':child'=>$this->name,':parent'=>$this->name));			
				$command->delete('authassignment','itemname=:itemname', array(':itemname'=>$this->name));
				return true;
			}	
	}
	/**
	 * Check delete
	 */
	public function checkDelete($id){
		$list_role=Role::model()->findAll('parent_id = '.$id);
		if(sizeof($list_role)>0){
			return self::DELETE_HAS_CHILD;
		}
		return self::DELETE_OK;
	}
}