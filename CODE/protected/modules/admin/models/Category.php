<?php
/**
 * 
 * Category class file 
 * @author ihbvietnam <hotro@ihbvietnam.com>
 * @link http://iphoenix.vn
 * @copyright Copyright &copy; 2012 IHB Vietnam
 * @license http://iphoenix.vn/license
 *
 */

/**
 * Category includes attributes and methods of Category class  
 */
class Category extends CActiveRecord
{	
	/**
	 * Config maximun rank in a group
	 */
	const MAX_RANK=4;	
	/**
	 * Config code error when delete category
	 */
	const DELETE_OK=1;
	const DELETE_HAS_CHILD=2;
	const DELETE_HAS_ITEMS=3;
	/**
	 * Config code (id) of the main category groups which have parent_id=0
	 */
	const TYPE_STATICPAGE=1;
	const TYPE_NEWS=2;
	const TYPE_PRODUCT=3;
	const TYPE_MANUFACTURER=4;
	const TYPE_ALBUM=5;
	const TYPE_GALLERYVIDEO=6;
	const TYPE_KEYWORD=7;
	const TYPE_QA=8;
	const TYPE_SUPPORT=9;
	const TYPE_RECRUITMENT=10;
	const TYPE_APP=11;

	/**
	 * Config special
	 * SPECIAL_REMARK when group is news, category news is viewed at homepage
	 */
	const SPECIAL_REMARK=0;

	/**
	 * @var array config list other attributes of the banner
	 * these attributes is stored in other field of article table	 
	 */
	
	const META_LENGTH=30;	
	private $config_other_attributes=array('amount','introimage','description','modified','metadesc');	
	private $list_other_attributes;
	
	public $list_special;
	// Template var that store data when tree traversal
	public $tmp_list;
	// Store old order view
	public $old_order_view;
	// Store old parent id
	public $old_parent_id;
	//Store name
	public $old_name;
	//Store keyword
	public $old_keyword;
	
	public $config_type;
	public function init(){
			parent::init();
			//Get list all language
			$configFile = Yii::app ()->theme->basePath.'/config/config_categories.php';
    		$this->config_type=require($configFile); 
	}
	/**
  	 * Get max rank
  	 */
	public function getMax_rank(){
		return $this->config_type[$this->type]['max_rank'];
	}
	/**
	 * Get all specials of class Category
	 * Use in drop select when create, update banner
	 */
	static function getList_label_specials()
 	{
	return array(
			self::SPECIAL_REMARK=>'Hiển thị ở trang chủ',
		);
 	}
 	/**
 	 * Get specials attributes of a category object
 	 * Used in page list admin views
 	 */
	public function getLabel_specials()
 	{
		$label_specials=array();
		foreach ($this->list_special as $special) {
			$list_label_specials=self::getList_label_specials();
			$label_specials[]= $list_label_specials[$special];
		}
		return $label_specials;
 	}
 	
 	/**
 	 * Special attributes are encoded before save in database
 	 * Function get all code of the special
 	 */
	static function getCode_special($index=null)
 	{
 		$result=array();
 		$full=range(0,pow(2,sizeof(self::getList_label_specials()))-1);
 		if($index === null){
 			$result=$full;
 		}
 		else {			
 			foreach ($full as $num){
 				if(in_array($index, iPhoenixStatus::decodeStatus($num))){
 					$result[]=$num;
 				}
 			}
 		}
 		return $result;
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
	 * @return array $bread_crumb ancestor array of this node
	 */
	public function getAncestor_nodes(){
		$bread_crumb=array();
		$check=true;
		$current_id=$this->id;
		while ($check){
			$current=self::model()->findByPk($current_id);
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
			$current=self::model()->findByPk($current_id);
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
		$list=self::model()->findAll($criteria);
		
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
			$list_menu=self::model()->findAll($criteria);
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
	 * @return Category the static model class
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
		return 'tbl_category';
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
			array('description,metadesc,keyword,introimage', 'safe'),
			array('order_view','numerical'),
			array('list_special,lang','safe')
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
			$parent=self::model()->findByPk($this->parent_id);
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
			'list_special' => 'Nhóm hiển thị',
			'lang'=>'Ngôn ngữ',
			'amount'=>'Số đối tượng chứa các từ khóa trên',
			'introimage'=>'Ảnh đại diện'
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
		//Store old name
		$this->old_name=$this->name;
		//Store old keyword
		$this->old_keyword=$this->keyword;
		//Get list special
		if($this->special != ""){
			$this->list_special=iPhoenixStatus::decodeStatus($this->special);	
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
				$this->list_special=array(Category::SPECIAL_REMARK); 
				$alias=iPhoenixString::createAlias($this->name);
				if(sizeof(Category::model()->findAll('alias ="'.$alias.'"'))>0)
				{
					$parent=Category::model()->findByPk($this->parent_id);
					if(isset($parent))	$alias = $alias.'-'.$parent->alias;
				}
				while(sizeof(Category::model()->findAll('alias ="'.$alias.'"'))>0){
					$suffix=rand(1,9);
					$alias =$alias.'-'.$suffix;
				}
				$this->alias=$alias;				
			}	
			else {
				$modified=$this->modified;
				$modified[time()]=Yii::app()->user->id;
				$this->modified = json_encode ( $modified );
				if ($this->name != $this->old_name) {
					$alias = iPhoenixString::createAlias ( $this->name );
					if (sizeof ( Category::model ()->findAll ( 'alias ="' . $alias . '"' ) ) > 0) {
						$parent = Category::model ()->findByPk ( $model->parent_id );
						if (isset ( $parent ))
							$alias = $alias.'-'.$parent->alias;
					}
					while ( sizeof ( Category::model ()->findAll ( 'alias ="' . $alias . '"' ) ) > 0 ) {
						$suffix = rand ( 1, 9 );
						$alias = $alias . '-' . $suffix;
					}
					$this->alias = $alias;
				}
			}
			if($this->metadesc == ''){
					$description=$this->description;
					$this->metadesc=iPhoenixString::createIntrotext($description,self::META_LENGTH);
			}
			//Handler keyword
			if($this->old_keyword != $this->keyword || $this->isNewRecord){
				$old_category=Category::model()->findByPk($this->old_keyword);
				if(isset($old_category)){
					$old_category->amount=$old_category->amount-1;
					if($old_category->amount < 0) $old_category->amount=0;
					$old_category->save();	
				}
				$new_category=Category::model()->findByPk($this->keyword);
				if(isset($new_category)){
					$new_category->amount=$new_category->amount+1;
					$new_category->save();	
				}
			}
			//Encode special
			$this->special=iPhoenixStatus::encodeStatus($this->list_special);
			//Encode other attributes  		
			$this->other = json_encode ( $this->list_other_attributes );
			return true;
		} else
			return false;
	}
	/**
	 * Change order view of a category
	 * @return boolean false if it is not changed successfully
	 * otherwise, it changed the order of this category
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
						$category = Category::model ()->findByPk ( $id );
						if ($category->order_view < $this->old_order_view )
							$category->order_view = $order + 1;
						if (! $category->save ()){
							return false;
						}
					}
				}
			}
			if ($this->order_view > $this->old_order_view) {
				foreach ( $this->list_order_view as $id => $order ) {
					if ($id != $this->id && $order <= $this->order_view) {
						$category = Category::model ()->findByPk ( $id );
						if ($category->order_view > $this->old_order_view )
							$category->order_view = $order - 1;
						if (! $category->save ())
							return false;
					}
				}
			}
		} else {
			//Fix order view in old parent category
			$list = Category::model ()->findAll ( 'parent_id=' . $this->old_parent_id );
			foreach ( $list as $cat ) {
				if ($cat->order_view > $this->old_order_view) {
					$cat->order_view = $cat->order_view - 1;
					if (!$cat->save ())
						return false;
				}
			}
			//Fix order view in new parent category
			foreach ( $this->list_order_view as $id => $order ) {
				if ($id != $this->id && $order >= $this->order_view) {
					$category = Category::model ()->findByPk ( $id );
					$category->order_view = $order + 1;
					if (! $category->save ())
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
		$list_category=Category::model()->findAll('parent_id = '.$id);
		if(sizeof($list_category)>0){
			return self::DELETE_HAS_CHILD;
		}
		/*
		switch($this->type){
			case self::TYPE_NEWS:
				$list_news=News::model()->findAll('catid = '. $id);
				if(sizeof($list_news)>0) return self::DELETE_HAS_ITEMS;
				break;
			case self::TYPE_PRODUCT:
				$list_product=Product::model()->findAll('catid = '. $id);
				if(sizeof($list_product)>0) return self::DELETE_HAS_ITEMS;
				break;
			case self::TYPE_STATICPAGE:
				$list_page=StaticPage::model()->findAll('catid = '. $id);
				if(sizeof($list_page)>0) return self::DELETE_HAS_ITEMS;
				break;
			case self::TYPE_ALBUM:
				$list_album=Album::model()->findAll('catid = '. $id);
				if(sizeof($list_album)>0) return self::DELETE_HAS_ITEMS;
				break;
			case self::TYPE_GALLERYVIDEO:
				$list_video=GalleryVideo::model()->findAll('catid = '. $id);
				if(sizeof($list_video)>0) return self::DELETE_HAS_ITEMS;
				break;
			case self::TYPE_QA:
				$list_qa=QA::model()->findAll('catid = '. $id);
				if(sizeof($list_qa)>0) return self::DELETE_HAS_ITEMS;
				break;
			case self::TYPE_SUPPORT:
				$list_support=Support::model()->findAll('catid = '. $id);
				if(sizeof($list_support)>0) return self::DELETE_HAS_ITEMS;
				break;
			case self::TYPE_RECRUITMENT:
				$list_recuitment=Recruitment::model()->findAll('catid = '. $id);
				if(sizeof($list_recruitment)>0) return self::DELETE_HAS_ITEMS;
				break;
			
		}
		*/
		$class=$this->config_type[$this->type]['class'];
		$object= new $class;
		$list=$object->findAll('catid = '. $id);
		if(sizeof($list)>0) 
			return self::DELETE_HAS_ITEMS;
		return self::DELETE_OK;
	}

	/**
	 * Get url update f album
	 * @return album's url
	 */
	public function getUpdate_url()
 	{
 		$url=Yii::app()->createUrl("admin/category/index");
		return $url;
 	}
/**
	 * Create params for url of menu
	 * @return string, the url of menu
	 */
	public function getUrl() {
		/*
		switch ($this->type){
			case Category::TYPE_NEWS:		
 			$cat_alias=$this->alias;
 			$url=Yii::app()->createUrl("/news/list",array('cat_alias'=>$cat_alias));
 			break;
			case Category::TYPE_STATICPAGE:			
 			$cat_alias=$this->alias;
 			$url=Yii::app()->createUrl("/staticPage/index",array('cat_alias'=>$cat_alias));
			break;
			case Category::TYPE_ALBUM:			
 			$cat_alias=$this->alias;
 			$url=Yii::app()->createUrl("/album/index",array('album_alias'=>$cat_alias));
			break;
			case Category::TYPE_GALLERYVIDEO:			
 			$cat_alias=$this->alias;
 			$url=Yii::app()->createUrl("/galleryVideo/index",array('galleryVideo_alias'=>$cat_alias));
			break;
			case Category::TYPE_PRODUCT:
 			$cat_alias=$this->alias;
 			$url=Yii::app()->createUrl("/product/list",array('cat_alias'=>$cat_alias));
			break;
			case Category::TYPE_APP:
 			$cat_alias=$this->alias;
 			$url=Yii::app()->createUrl("/app/list",array('cat_alias'=>$cat_alias));
			break;
			case Category::TYPE_QA:
 			$cat_alias=$this->alias;
 			$url=Yii::app()->createUrl("/qA/list",array('cat_alias'=>$cat_alias));
			break;
		}
		*/
		$cat_alias=$this->alias;
		$url=Yii::app()->createUrl("/".$this->config_type[$this->type]['code']."/list",array('cat_alias'=>$cat_alias));
		return $url;
	}
	/**
	 * Get active menu
	 * @return array $result, the active menu in admin board
	 */
	public function findActiveMenu($current_catid) {
		$result = array ();
		$cat = Category::model ()->findByPk ( $current_catid );
		if(isset($cat))
			$result = $cat->ancestor_nodes;
		else
			$result=array();
		return $result;
	}
}