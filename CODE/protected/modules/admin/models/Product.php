<?php
/**
 * 
 * Product class file 
 * @author ihbvietnam <hotro@ihbvietnam.com>
 * @link http://iphoenix.vn
 * @copyright Copyright &copy; 2012 IHB Vietnam
 * @license http://iphoenix.vn/license
 *
 */
/**
 * This is the model class for table "product".
 */
class Product extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */	
	public function tableName()
	{
		return 'tbl_product';
	}
   /**
	* Config status of product
	*/
	const STATUS_PENDING=0;
	const STATUS_ACTIVE=1;
	/**
	 * Config special
	 * SPECIAL_REMARK product is viewed at homepage
	 */
	const SPECIAL_REMARK=0;
	const SPECIAL_BESTSELLER=1;
	
	const LIST_PRODUCT=1;
	const LIST_SEARCH=1;
	const LIST_ORDER=10;
	
	const LIST_ADMIN=10;
	const PRESENT_CATEGORY=31;
	
	const META_LENGTH=30;
	
	/**
	 * @var array $config_unit_price, config the unit of product price
	 */
	static $config_unit_price = array('VND'=>'VND');	
	public $num_price;
	public $unit_price;
	public $old_video;
	public $old_introimage;
	public $old_name;
	public $old_keyword;
	public $list_special;
	private $config_other_attributes=array('list_suggest','modified','unit_price','introimage','otherimage','metakey','metadesc');	
	private $list_other_attributes;
	public $config_other_tag;
	public function init(){
			parent::init();
			$configFile = Yii::app ()->theme->basePath.'/config/config_product.php';
    		$this->config_other_tag=require($configFile); 
	}
	/**
	 * Get image url which display status of contact
	 * @return string path to enable.png if this status is STATUS_ACTIVE
	 * path to disable.png if status is STATUS_PENDING
	 */
 	public function getImageStatus()
 	{
 		switch ($this->status) {
 			case self::STATUS_ACTIVE: 
 				return Yii::app()->request->baseUrl.'/images/admin/enable.png';
 				break;
 			case self::STATUS_PENDING:
 				return Yii::app()->request->baseUrl.'/images/admin/disable.png';
 				break;
 		}	
 	}
	/**
	 * Get url of image which displays amount status of product 
	 * @return string, absoluted url of status image
	 */
 	public function getImageAmountStatus()
 	{
 		switch ($this->amount_status) {
 			case self::STATUS_ACTIVE: 
 				return Yii::app()->request->baseUrl.'/images/admin/enable.png';
 				break;
 			case self::STATUS_PENDING:
 				return Yii::app()->request->baseUrl.'/images/admin/disable.png';
 				break;
 		}	
 	}
	/**
	 * Get update url of product
	 * @return update product's url
	 */
	public function getUpdate_url()
 	{
 		$url=Yii::app()->createUrl("admin/product/update",array('id'=>$this->id));
		return $url;
 	}
	/**
	 * Get url of this image
	 * @return string $url, url of this product
	 */
 	public function getUrl(){
		$cat_alias=$this->category->alias;
 		$alias=$this->alias;
		$url=Yii::app()->createUrl("product/view",array('cat_alias'=>$cat_alias,'product_alias'=>$alias)); 
		return $url;
	}
 	
 	/**
	 * Get url product thumb image
	 * @return string, absoluted path of thumb image
	 */
	public function getThumb_url($type,$class="img"){
		$alt=$this->name;
		if($this->introimage>0){
			$image=Image::model()->findByPk($this->introimage);
			if(isset($image)){
				$src=$image->getThumb('Product',$type);
				if( $image->title != '')	$alt=$image->title;
			}
			else {
				$src=Image::getDefaultThumb('Product', $type);
			}
			return '<img class="'.$class.'" src="'.$src.'" alt="'.$alt.'">';
		}
		else {
			
			return '<img class="'.$class.'" src="'.Image::getDefaultThumb('Product', $type).'" alt="'.$alt.'">';
		}
	}

	/**
	 * Get all specials of class Product
	 * Used in dropDownList when create or update product
	 */
	public function getList_similar(){
		if($this->list_suggest != ''){
			$list = array_diff ( explode ( ',', $this->list_suggest ), array ('' ) );
			$result=array();
			$index=0;
			foreach ($list as $id){
				$product=Product::model()->findByPk($id);
				if(isset($product)){
					$index++;
					if($index <= Setting::s('LIMIT_SIMILAR_PRODUCT','Product'))
						$result[]=Product::model()->findByPk($id);
				}
				else{
					$list_clear=array_diff(explode(',',$this->list_suggest),array(''));
					$list_filter=array_diff($list_clear,array($id));
					$this->list_suggest=implode(',', $list_filter);
					$this->save();
				}
			}
		}
		else {
			$criteria=new CDbCriteria;
			$criteria->compare('status', Product::STATUS_ACTIVE);
			$criteria->order='id desc';
			$criteria->compare ( 'status', QA::STATUS_ACTIVE );
			$criteria->compare('catid',$this->catid);
			$criteria->limit=Setting::s('LIMIT_SIMILAR_PRODUCT','Product');
			$criteria->addCondition('id <>'. $this->id);
			$result=Product::model()->findAll($criteria);		
		}
		return $result;
	}
	/**
	 * Get all specials of class Product
	 * Use in drop select when create, update album
	 */
	static function getList_label_specials()
 	{
		return array(
			self::SPECIAL_REMARK=>'Hiển thị trong phần sản phẩm nổi bật',
			self::SPECIAL_BESTSELLER=>'Hiển thị trong phần sản phẩm bán chạy',
		);
 	}
 	/**
 	 * Get specials label of a product object
 	 * Used in list page of admin board
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
 	 * Special is encoded before save in database
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
	 * PHP setter magic method for other attributes
	 * @param $name the attribute name
	 * @param $value the attribute value
	 * set value into particular attribute
	 */
	public function __set($name,$value)
	{
		$list= array_merge($this->config_other_attributes,array_keys($this->config_other_tag));
		if(in_array($name,$list))
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
		$list= array_merge($this->config_other_attributes,array_keys($this->config_other_tag));
		if(in_array($name,$list))
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
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		$other_tag=implode(',',array_keys($this->config_other_tag));
		return array(
			array('name,catid,code,introimage,manufacturer_id','required','on'=>'write'),
			array($other_tag.',list_special,lang,unit_price,otherimage,list_suggest,metadesc,keyword', 'safe','on'=>'write'),
			array('num_price', 'numerical', 'integerOnly'=>true,'on'=>'write'),
			array('name,lang, manufacturer_id, catid,special, amount_status, keyword','safe','on'=>'search'),	
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'category'=>array(self::BELONGS_TO,'Category','catid'),
			'manufacturer'=>array(self::BELONGS_TO,'Category','manufacturer_id'),
			'author'=>array(self::BELONGS_TO,'User','created_by')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'name' => 'Tên sản phẩm',
			'catid'=>'Nhóm sản phẩm',
			'manufacturer_id'=>'Nhà sản xuất',
			'code'=>'Mã sản phẩm',
			'unit'=>'Đơn vị tính',
			'price'=>'Giá',
			'year'=>'Năm sản xuất',
			'created_by' => 'Người tạo',
			'created_date'=>'Ngày tạo',
			'list_special'=>'Hiển thị',
			'model'=>'Kiểu dáng',
			'description'=>'Miêu tả',
			'unit_price'=>'Đơn vị tiền',
			'special'=>'Trạng thái hiển thị',
			'introimage'=>'Ảnh giới thiệu',
			'otherimage'=>'Các ảnh khác',
			'amount_status'=>'Trạng thái',
			'list_suggest'=>'Sản phẩm liên quan',
			'sold_products'=>'Đã bán',
			'visits'=>'Đã xem',
		);
	}
	/**
	 * This event is raised after the record is instantiated by a find method.
	 * @param CEvent $event the event parameter
	 */
	public function afterFind()
	{
		//Decode attribute other to set other attributes
		$this->list_other_attributes=(array)json_decode($this->other);	
		//Store old video
		//$this->old_video=$this->video;
		//Store introimage 
		$this->old_introimage=$this->introimage;
		//Get list special
		$this->list_special=iPhoenixStatus::decodeStatus($this->special);
		//Store old name
		$this->old_name=$this->name;
		$this->old_keyword=$this->keyword;
		
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
				$this->status=PRODUCT::STATUS_ACTIVE;
				//Set alias
				$alias=iPhoenixString::createAlias($this->name);	
				while(sizeof(Product::model()->findAll('alias = "'.$alias.'"'))>0){
					$suffix=rand(1,99);
					$alias =$alias.'-'.$suffix;
				}
				$this->alias=$alias;				
			}	
			else {
				$modified=$this->modified;
				$modified[time()]=Yii::app()->user->id;
				$this->modified=json_encode($modified);	
				if($this->name != $this->old_name) {
					$alias=iPhoenixString::createAlias($this->name);	
					while(sizeof(Product::model()->findAll('alias = "'.$alias.'"'))>0){
						$suffix=rand(1,99);
						$alias =$alias.'-'.$suffix;
					}
					$this->alias=$alias;
				}
				//Handler list suggest news
				$list_clear=array_diff(explode(',',$this->list_suggest),array(''));
				$list_filter=array_diff($list_clear,array($this->id));
				$this->list_suggest=implode(',', $list_filter);
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
			$this->other=json_encode($this->list_other_attributes);
			return true;
		}
	}
	
	/**
	 * This method is invoked after saving a record successfully.
	 * The default implementation raises the {@link onAfterSave} event.
	 * You may override this method to do postprocessing after record saving.
	 * Make sure you call the parent implementation so that the event is raised properly.
	 */
	public function afterSave(){
		if($this->old_introimage != $this->introimage){
			$introimage = Image::model()->findByPk($this->introimage);
			if(isset($introimage)){
				$introimage->parent_id=$this->id;
				if($introimage->save()) 
					return parent::afterSave();
				else 
					return false;
				}
			else 
				return true;
			}
		return true;
	}
	
	/**
	 * This method is invoked before delete a record 
	 */
	public function beforeDelete() {
			//Delete introimage	
		if (parent::beforeDelete ()) {
			$introimage = Image::model ()->findByPk ( $this->introimage );
			if (isset ( $introimage )) {
				if (! $introimage->delete ())
					return false;
			}
			//Delete otherimage
			$list = array_diff ( explode ( ',', $this->otherimage ), array ('' ) );
			foreach ( $list as $id ) {
				$image = Image::model ()->findByPk ( $id );
				if (isset ( $image )) {
					if (! $image->delete ())
						return false;
				}
			}
			return true;
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
		

		$criteria = new CDbCriteria ();
		$criteria->compare ( 'lang', $this->lang );
		$criteria->compare ( 'name', $this->name, true );
		$criteria->compare ('amount_status',$this->amount_status);	
		if (!Yii::app ()->user->checkAccess ( 'product_update') && Yii::app()->controller->id == 'product' && Yii::app()->controller->action->id == 'index') {
			$criteria->compare ( 'created_by', Yii::app()->user->id);
		}	
		//Filter catid
		$cat = Category::model ()->findByPk ( $this->catid );
		if ($cat != null) {
			$child_categories = $cat->child_nodes;
			$list_child_id = array ();
			//Set itself
			$list_child_id [] = $cat->id;
			if ($child_categories != null)
				foreach ( $child_categories as $id => $child_cat ) {
					$list_child_id [] = $id;
				}
			$criteria->addInCondition ( 'catid', $list_child_id );
		}
		//Filter manufacturer
		$cat = Category::model ()->findByPk ( $this->manufacturer_id );
		if ($cat != null) {
			$child_categories = $cat->child_nodes;
			$list_child_id = array ();
			//Set itself
			$list_child_id [] = $cat->id;
			if ($child_categories != null)
				foreach ( $child_categories as $id => $child_cat ) {
					$list_child_id [] = $id;
				}
			$criteria->addInCondition ( 'manufacturer_id', $list_child_id );
		}
		//Filter keyword category
		$cat = Category::model ()->findByPk ( $this->keyword );
		if ($cat != null) {
			$criteria->addInCondition ( 'keyword', $cat->ancestor_nodes );
		}
		if (isset ( $_GET ['pageSize'] ))
			Yii::app ()->user->setState ( 'pageSize', $_GET ['pageSize'] );
		if ($this->special != '') {
			$criteria->addInCondition ( 'special', self::getCode_special ( $this->special ) );
		}
		return new CActiveDataProvider ( $this, array (
					'criteria' => $criteria, 
					'pagination' => array ('pageSize' => Yii::app ()->user->getState ( 'pageSize', Setting::s('DEFAULT_PAGE_SIZE','System') ) ),
					'sort' => array ('defaultOrder' => 'id DESC')
				) );
	}
	/**
	 * Suggests a list of existing names matching the specified keyword.
	 * @param string the keyword to be matched
	 * @param integer maximum number of tags to be returned
	 * @return array list of matching username names
	 */
	public function suggestName($keyword,$limit=20)
	{
		$list_qa=$this->findAll(array(
			'condition'=>'name LIKE :keyword',
			'order'=>'name DESC',
			'limit'=>$limit,
			'params'=>array(
				':keyword'=>'%'.strtr($keyword,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')).'%',
			),
		));
		$names=array();
		foreach($list_qa as $qa)
			$names[]=$qa->name;
			return $names;
	}
	/**
	 * Change status of product
	 * @param integer $id, the ID of product model
	 */
	static function reverseStatus($id){
		$command=Yii::app()->db->createCommand()
		->select('status')
		->from('tbl_product')
		->where('id=:id',array(':id'=>$id))
		->queryRow();
		switch ($command['status']){
			case self::STATUS_PENDING:
				 $status=self::STATUS_ACTIVE;
				 break;
			case self::STATUS_ACTIVE:
				$status=self::STATUS_PENDING;
				break;
		}
		$sql='UPDATE tbl_product SET status = '.$status.' WHERE id = '.$id;
		$command=Yii::app()->db->createCommand($sql);
		if($command->execute()) {
			switch ($status) {
 			case self::STATUS_ACTIVE: 
 				$src=Yii::app()->request->baseUrl.'/images/admin/enable.png';
 				break;
 			case self::STATUS_PENDING:
 				$src=Yii::app()->request->baseUrl.'/images/admin/disable.png';
 				break;
 		}	
			return $src;
		}
		else return false;
	}
	/**
	 * Change status of Amount
	 * @param integer $id, the ID of product model
	 */
	static function reverseAmountStatus($id){
		$command=Yii::app()->db->createCommand()
		->select('amount_status')
		->from('tbl_product')
		->where('id=:id',array(':id'=>$id))
		->queryRow();
		switch ($command['amount_status']){
			case self::STATUS_PENDING:
				 $status=self::STATUS_ACTIVE;
				 break;
			case self::STATUS_ACTIVE:
				$status=self::STATUS_PENDING;
				break;
		}
		$sql='UPDATE tbl_product SET amount_status = '.$status.' WHERE id = '.$id;
		$command=Yii::app()->db->createCommand($sql);
		if($command->execute()) {
			switch ($status) {
 			case self::STATUS_ACTIVE: 
 				$src=Yii::app()->request->baseUrl.'/images/admin/enable.png';
 				break;
 			case self::STATUS_PENDING:
 				$src=Yii::app()->request->baseUrl.'/images/admin/disable.png';
 				break;
 		}	
			return $src;
		}
		else return false;
	}	
}