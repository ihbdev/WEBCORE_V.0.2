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
 * This is the model class for table "image".
 */
class Image extends CActiveRecord
{
	/**
	 * Config max size of thumb image
	 */
	const MAX_WIDTH_THUMB_IMAGE_UPDATE=300;
	const MAX_WIDTH_THUMB_AUTO=100;
	
	/**
	 * Config status of image
	 */
	const STATUS_PENDING=0;
	const STATUS_ACTIVE=1;	
	/**
	 * Config group of categories images
	 */
	static $config_category=array(
		'News'=>'News',
		'Product'=>'Product',
		'Album'=>'Album',
		'GalleryVideo'=>'GalleryVideo',
		'Banner'=>'Banner',
		'StaticPage'=>'StaticPage',
		'Category'=>'Category'
	);
	/**
	 * Config size of thumb
	 */
	static function getConfig_thumb_size(){
		$configFile = Yii::app ()->theme->basePath.'/config/size_image.php';
    	$list=require($configFile); 
    	return $list;
	}
	/**
	 * Config thumb_type 
	 * declare thumb_type images
	 */
	private $config_other_attributes=array();	
	private $list_other_attributes;
	public $group_parent;
	
	/**
	 * Get path of origin image
	 * @return string the absoluted path of this image
	 */
	public function getPathOrigin(){
		return Yii::getPathOfAlias('webroot').'/'.$this->src.'/origin/'.$this->filename.'.'.$this->extension;
	}
	/**
	 * Get url of origin image
	 * @return string the absoluted url of this image
	 */
	public function getUrlOrigin(){
		if(file_exists(Yii::app()->request->getBaseUrl(true).'/'.$this->src.'/origin/'.$this->filename.'.'.$this->extension))
			return Yii::app()->request->getBaseUrl(true).'/'.$this->src.'/origin/'.$this->filename.'.'.$this->extension;
		else
			return Yii::app()->request->getBaseUrl(true).'/images/default/default.jpg';
	}
	
	/**
	 * Get width of this origin image
	 */
	public function getWidth(){
		if(file_exists($this->pathOrigin)){
			$size=getimagesize($this->pathOrigin);
			return $size[0];
		}
		else
			return 0;
	}
	
	/**
	 * Get height of this origin image
	 */
	public function getHeight(){
		if(file_exists($this->pathOrigin)){
			$size=getimagesize($this->pathOrigin);
			return $size[1];
		}
		else
			 return 0;
	}
	
	/**
	 * Get size of this origin image
	 */
	public function getSize(){
		return $this->width .'x'. $this->height;
	}
	/**
	 * Get url of this image
	 * @return string $url, url of this image
	 */
	public function getUrl()
 	{
 		if($this->url !="") 
 			return $this->url;
 		else 
 			return "";
 	}
 	
 	/**
 	 * Get auto thumb of image
 	 * @return string, html code of this default thumb image 
 	 */
	public function getAutoThumb(){
			$type="auto_thumb";
			$url=Yii::getPathOfAlias('webroot').'/'.$this->src.'/'.$type.'/'.$this->filename.'.'.$this->extension;
			if(!file_exists($url)){
			if(!file_exists(Yii::getPathOfAlias('webroot').'/'.$this->src.'/'.$type)){
				mkdir(Yii::getPathOfAlias('webroot').'/'.$this->src.'/'.$type);
			}
			if(file_exists(Yii::getPathOfAlias('webroot').'/'.$this->src.'/origin/'.$this->filename.'.'.$this->extension)){
				$thumb=new ResizeImage(Yii::getPathOfAlias('webroot').'/'.$this->src.'/origin/'.$this->filename.'.'.$this->extension);
				$zoom=(int)Image::MAX_WIDTH_THUMB_AUTO/$this->width;
				$w=$zoom*$this->width;
				$h=$zoom*$this->height;
				$thumb->resize_image($w,$h);
				$thumb->save($url);
			}
		}
		if(file_exists(Yii::getPathOfAlias('webroot').'/'.$this->src.'/'.$type.'/'.$this->filename.'.'.$this->extension))
			$src=Yii::app()->request->getBaseUrl(true).'/'.$this->src.'/'.$type.'/'.$this->filename.'.'.$this->extension;
		else 
			$src=self::getDefaultThumb($category=null,$type);
		return '<img class="img" src="'.$src.'" alt="'.$this->title.'">';
	}
	/**
	 * Get thumb of image
	 * @param string $category, category of image
	 * @param string $type, type of thumb image
	 * @return string, absoluted path of thumb image
	 */
	public function getThumb($category=null,$type=null){
		if($category != null && $type != null){
		$config_thumb_size=self::getConfig_thumb_size();
		$size_type=$config_thumb_size[$category][$type]['w'].'x'.$config_thumb_size[$category][$type]['h'];
		$url=Yii::getPathOfAlias('webroot').'/'.$this->src.'/'.$size_type.'/'.$this->filename.'.'.$this->extension;
		if(!file_exists($url)){
			if(!file_exists(Yii::getPathOfAlias('webroot').'/'.$this->src.'/'.$size_type)){
				mkdir(Yii::getPathOfAlias('webroot').'/'.$this->src.'/'.$size_type);
			}
			if(file_exists(Yii::getPathOfAlias('webroot').'/'.$this->src.'/origin/'.$this->filename.'.'.$this->extension)){
				$thumb=new ResizeImage(Yii::getPathOfAlias('webroot').'/'.$this->src.'/origin/'.$this->filename.'.'.$this->extension);
				$thumb->resize_image($config_thumb_size[$category][$type]['w'],$config_thumb_size[$category][$type]['h']);
				$thumb->save($url);
			}
		}
		if(file_exists(Yii::getPathOfAlias('webroot').'/'.$this->src.'/'.$size_type.'/'.$this->filename.'.'.$this->extension))
			return Yii::app()->request->getBaseUrl(true).'/'.$this->src.'/'.$size_type.'/'.$this->filename.'.'.$this->extension;
		else 
			return self::getDefaultThumb($category,$type);
		}
		else {
			$type="auto_thumb";
			$zoom=(int)Image::MAX_WIDTH_THUMB_AUTO/$this->width;
			$w=$zoom*$this->width;
			$h=$zoom*$this->height;
			$size_type=$w.'x'.$h;
			$url=Yii::getPathOfAlias('webroot').'/'.$this->src.'/'.$size_type.'/'.$this->filename.'.'.$this->extension;
			if(!file_exists($url)){
			if(!file_exists(Yii::getPathOfAlias('webroot').'/'.$this->src.'/'.$size_type)){
				mkdir(Yii::getPathOfAlias('webroot').'/'.$this->src.'/'.$size_type);
			}
			if(file_exists(Yii::getPathOfAlias('webroot').'/'.$this->src.'/origin/'.$this->filename.'.'.$this->extension)){
				$thumb=new ResizeImage(Yii::getPathOfAlias('webroot').'/'.$this->src.'/origin/'.$this->filename.'.'.$this->extension);
				$thumb->resize_image($w,$h);
				$thumb->save($url);
			}
		}
		if(file_exists(Yii::getPathOfAlias('webroot').'/'.$this->src.'/'.$size_type.'/'.$this->filename.'.'.$this->extension))
			return Yii::app()->request->getBaseUrl(true).'/'.$this->src.'/'.$size_type.'/'.$this->filename.'.'.$this->extension;
		else 
			return self::getDefaultThumb($category,$type);
		}
	}
	/**
	 * Return default thumb of this image
	 * @param string $category, category of image
	 * @param string $type, type of thumb image
	 * @return string, absoluted path of default thumb image	  
	 */
	static function getDefaultThumb($category=null,$type=null){
		$config_thumb_size=self::getConfig_thumb_size();
		if($category != null && $type != null){
			$size_type=$config_thumb_size[$category][$type]['w'].'x'.$config_thumb_size[$category][$type]['h'];
			$url='/images/default/'.$size_type.'/default.jpg';
			if(file_exists(Yii::getPathOfAlias('webroot').'/images/default/default.jpg')){
				if(!file_exists(Yii::getPathOfAlias('webroot').'/images/default/'.$size_type)){
					mkdir(Yii::getPathOfAlias('webroot').'/images/default/'.$size_type);
				}
				$thumb=new ResizeImage(Yii::getPathOfAlias('webroot').'/images/default/default.jpg');
				$thumb->resize_image($config_thumb_size[$category][$type]['w'],$config_thumb_size[$category][$type]['h']);
				$thumb->save(Yii::getPathOfAlias('webroot').$url);
			}
			return Yii::app()->request->getBaseUrl(true).$url;
		}
		else{
			return Yii::app()->request->getBaseUrl(true).'/images/default/default.jpg';
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
	 * Get image url which display status of contact
	 * @return string path to enable.png if this status is STATUS_ACTIVE
	 * path to disable.png if status is STATUS_PENDING
	 */
 	public function getImageStatus()
 	{
 		switch ($this->status) {
 			case self::STATUS_ACTIVE: 
 				return Yii::app()->request->getBaseUrl(true).'/images/admin/enable.png';
 				break;
 			case self::STATUS_PENDING :
				return Yii::app ()->request->getBaseUrl ( true ) . '/images/admin/disable.png';
				break;
		}
	}
	/**
	 * Get parent of image
	 * @return link update of parent
	 */
	public function getParent_url() {
		$parent=$this->parent;
		if (isset ( $parent->update_url ))
			return 'Ảnh sử dụng cho thuộc tính ' . $this->parent_attribute.' của một đối tượng '.$this->category.' ( id = '.$this->parent_id.' ) <a href='.$parent->update_url.'>Click vào đây để chỉnh sửa đối tượng cha</a>';
		else
			return 'Ảnh rác';
 	}
/**
	 * Get parent of image
	 * @return link update of parent
	 */
 	public function getParent()
 	{
 			if ($this->parent_id > 0) {
 				/*
				switch ($this->category) {
					case self::$config_category ['News'] :
						$parent = News::model ()->findByPk ( $this->parent_id );
						break;
					case self::$config_category ['Product'] :
						$parent = Product::model ()->findByPk ( $this->parent_id );
						break;
					case self::$config_category ['Album'] :
						$parent = Album::model ()->findByPk ( $this->parent_id );
						break;
					case self::$config_category ['StaticPage'] :
						$parent = StaticPage::model ()->findByPk ( $this->parent_id );
						break;
					case self::$config_category ['Banner'] :
						$parent = Banner::model ()->findByPk ( $this->parent_id );
						break;
					case self::$config_category ['GalleryVideo'] :
						$parent = GalleryVideo::model ()->findByPk ( $this->parent_id );
						break;
				}
				*/
 				$class=$this->category;
				$object=new $class;
 				$parent = $object->findByPk($this->parent_id);
				return $parent;
 			}
			else {
				return null;
			}
 	}
	/** 
	 * Get list categories
	 * @return array $list, list categories
	 */
	public function getList_categories(){
		$dbCommand = Yii::app()->db->createCommand("
   			SELECT category FROM `".$this->tableName()."` GROUP BY `category`
		");
		$data = $dbCommand->queryAll();
		$list=array();	 
		foreach ($data as $item){
			$list[$item['category']]=$item['category'];			
		}
        return $list;
    }
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Image the static model class
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
		return 'tbl_image';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('src,filename,extension', 'required'),
			array('other', 'length', 'max'=>2048),
			array('title,url','safe','on'=>'update'),
			array('group_parent,category','safe','on'=>'search')
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
			'author'=>array(self::BELONGS_TO,'User','created_by')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'title'=>'Tên ảnh',
			'url'=>'Link liên kết',
			'thumb'=>'Ảnh',
			'author'=>'Tác giả',
			'created_date'=>'Ngày tạo',
			'parent'=>'Đối tượng cha',
			'group_parent'=>'Trạng thái',
			'category'=>'Nhóm đối tượng',
			'size'=>'Kích thước ảnh gốc'
		);
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria = new CDbCriteria ();
		if ($this->group_parent != null) {
			if ($this->group_parent == 0)
				$criteria->compare('parent_id','0');
		if($this->group_parent == 1)
			$criteria->addCondition('parent_id > 0');
		}
		$criteria->compare('category',$this->category);
		if (isset ( $_GET ['pageSize'] ))
			Yii::app ()->user->setState ( 'pageSize', $_GET ['pageSize'] );
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array ('pageSize' => Yii::app ()->user->getState ( 'pageSize', Setting::s('DEFAULT_PAGE_SIZE','System') )), 
			'sort' => array ('defaultOrder' => 'id DESC')
		));
	}
	/**
	 * This event is raised after the record is instantiated by a find method.
	 * @param CEvent $event the event parameter
	 */
	public function afterFind()
	{
		//Decode attribute other to set other attributes
		$this->list_other_attributes=(array)json_decode($this->other);	
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
			//Encode other attributes  		
			$this->other = json_encode ( $this->list_other_attributes );
			return true;	
		} 
		else
			return false;
	}
	/**
	 * This method is invoked after saving a record successfully.
	 * The default implementation raises the {@link onAfterSave} event.
	 * You may override this method to do postprocessing after record saving.
	 * Make sure you call the parent implementation so that the event is raised properly.
	 */
	protected function afterSave()
	{
		if($this->isNewRecord){
			if ($this->parent_id > 0) {
				/*
				switch ($this->category) {
					case self::$config_category ['News'] :
						$parent = News::model ()->findByPk ( $this->parent_id );
						$parent->scenario = 'upload-image';
						break;
					case self::$config_category ['Album'] :
						$parent = Album::model ()->findByPk ( $this->parent_id );
						$parent->scenario = 'upload-image';
						break;
					case self::$config_category ['Product'] :
						$parent = Product::model ()->findByPk ( $this->parent_id );
						$parent->scenario = 'upload-image';
						break;
					case self::$config_category ['StaticPage'] :
						$parent = StaticPage::model ()->findByPk ( $this->parent_id );
						$parent->scenario = 'upload-image';
						break;
					case self::$config_category ['Banner'] :
						$parent = Banner::model ()->findByPk ( $this->parent_id );
						$parent->scenario = 'upload-image';
						break;
					case self::$config_category ['GalleryVideo'] :
						$parent = GalleryVideo::model ()->findByPk ( $this->parent_id );
						$parent->scenario = 'upload-image';
						break;
					case self::$config_category ['Category'] :
						$parent = Category::model ()->findByPk ( $this->parent_id );
						$parent->scenario = 'upload-image';
						break;
				}
			*/
			$class=$this->category;
			$object= new $class;
 			$parent = $object->findByPk($this->parent_id);
 			$parent->scenario = 'upload-image';
			$attribute=$this->parent_attribute;
			$old_attributes = array_diff ( explode ( ',', $parent->$attribute ), array ('' ) );
			if(!in_array($this->id,$old_attributes)) 
			{
				$old_attributes[]=$this->id;		
				$parent->$attribute = implode ( ',', $old_attributes);
				if($parent->save())
					return true;
				else 
					return false;
			}
			}
		}
		return parent::afterSave();
	}
	/**
	 * This method is invoked before delete a record 
	 */
	public function beforeDelete() {
		if (parent::beforeDelete ()) {
			$list_thumb_type=array('origin');
			$config_thumb_size=self::getConfig_thumb_size();
			$model=$config_thumb_size[$this->category];
			foreach ($model as $type => $size){
				$list_thumb_type[]=$type;
			}
			foreach ($list_thumb_type as $type){
				$dir = Yii::getPathOfAlias ( 'webroot' ) . '/' . $this->src . '/' . $type;
				$file = $dir . '/' . $this->filename . '.' . $this->extension;
				if (file_exists ( $file )) {
					unlink ( $file );
					if (count ( scandir ( $dir ) ) == 2) {
						rmdir ( $dir );
					}
				}
			}
		if ($this->parent_id > 0) {
				/*
				switch ($this->category) {
					case self::$config_category ['News'] :
						$parent = News::model ()->findByPk ( $this->parent_id );
						break;
					case self::$config_category ['Product'] :
						$parent = Product::model ()->findByPk ( $this->parent_id );
						break;
					case self::$config_category ['Album'] :
						$parent = Album::model ()->findByPk ( $this->parent_id );
						break;
					case self::$config_category ['StaticPage'] :
						$parent = StaticPage::model ()->findByPk ( $this->parent_id );
						break;
					case self::$config_category ['Banner'] :
						$parent = Banner::model ()->findByPk ( $this->parent_id );
						break;
					case self::$config_category ['GalleryVideo'] :
						$parent = GalleryVideo::model ()->findByPk ( $this->parent_id );
						break;
					case self::$config_category ['Category'] :
						$parent = Category::model ()->findByPk ( $this->parent_id );
						break;
				}
				*/
				$class=$this->category;
				$object=new $class;
 				$parent = $object->findByPk($this->parent_id);
 				
				$attribute = $this->parent_attribute;
				$old_attributes = array_diff ( explode ( ',', $parent->$attribute ), array ('' ) );
				foreach ( $old_attributes as $id => $image_id ) {
	 				if ($image_id == $this->id) {
						unset ( $old_attributes [$id] );
					}
				}
				$parent->$attribute = implode ( ',', $old_attributes);
			if(isset($parent->id)){
				if($parent->save())
					return true;
				else 
					return false;
				}
			}
			else {
				return true;
			}
		}
		else
			return false;
	}
	//Create directory which contains image
	static function createDir($path){
		$dir=$path;
		$dir .= '/'.date('Y',time());
		if(!file_exists(Yii::getPathOfAlias('webroot').'/'.$dir)){
			mkdir(Yii::getPathOfAlias('webroot').'/'.$dir);
		}
		$dir .= '/'.date('m',time());
		if(!file_exists(Yii::getPathOfAlias('webroot').'/'.$dir)){
			mkdir(Yii::getPathOfAlias('webroot').'/'.$dir);
		}
		$dir .= '/'.date( 'd', time () );
		if (! file_exists ( Yii::getPathOfAlias ( 'webroot' ) . '/' . $dir )) {
			mkdir ( Yii::getPathOfAlias ( 'webroot' ) . '/' . $dir );
		}
		return $dir;
	}
	/**
	 * 
	 * Find images from html
	 * @param string $html, html
	 * @return array $list_src, list of image path
	 */
	static function findImages($html) {
		if ($html == "")
			return array ();
		else {
			/*
			$doc = new DOMDocument ();
			$doc->loadHTML ( $html );
			$xml = simplexml_import_dom ( $doc ); // just to make xpath more simple
			$images = $xml->xpath ( '//img' );
			$list_src = array ();
			foreach ( $images as $img ) {
				$src = $img ['src']->__toString ();
				$pos = strpos ( $src, Yii::app ()->request->serverName);
    		if($pos>0){
    			$list_src[]=substr($src, $pos+strlen(Yii::app()->request->serverName));
    		}
		}	
		return $list_src;
		*/
		preg_match_all('/src="([^"]+)"/',$html, $result);
		$files=$result[1];
		$list_src=array();
		foreach ($files as $src){
				$pos = strpos ( $src, Yii::app ()->request->serverName);
    		if($pos>0){
    			$list_src[]=substr($src, $pos+strlen(Yii::app()->request->serverName));
			}
		}
		return $list_src;
		}
	}
	/**
	 * Copy image to another place
	 * @param integer $origin_id, ID of the image to be copied
	 * @param integer $new_parent_id, ID of the place the image belongs to
	 */
	static function copy($origin_id,$new_parent_id){
		$origin=Image::model()->findByPk($origin_id);
		$copy= new Image();
		$filename=$origin->filename;
        $copy->extension=$origin->extension;
        $copy->parent_attribute=$origin->parent_attribute;
        $copy->category=$origin->category;
        $copy->parent_id=$new_parent_id;
        $origin_directory=Yii::getPathOfAlias('webroot').'/'.$origin->src.'/';
        $new_folder=Image::createDir('upload');
        $new_directory=Yii::getPathOfAlias('webroot').'/'.$new_folder.'/';
		if(!file_exists($new_directory .'/origin')){
				mkdir($new_directory .'/origin');
			}
        while ( file_exists ( $new_directory . '/origin/' . $filename . '.' . $origin->extension ) ) {
			$filename = $filename . '-' . rand ( 10, 99 );
		}
		if (file_exists ( $origin_directory . '/origin/' . $origin->filename . '.' . $origin->extension )) {
			if (copy ( $origin_directory . '/origin/' . $origin->filename . '.' . $origin->extension, $new_directory . '/origin/' . $filename . '.' . $origin->extension )) {
				$copy->src = $new_folder;
				$copy->filename=$filename;
        }
        else 	
        {
        	$copy->src=$origin->src;
        	$copy->filename=$origin->filename;   
        }
        }
        if($copy->save()){
        	return $copy->id;
        }
        else
        	return false;
	}
	/**
	 * Suggests a list image which matching the specified keyword.
	 * @param string $keyword, the input keyword to compare
	 */
	public function suggestTitle($keyword,$limit=20)
	{
		$list_qa=$this->findAll(array(
			'condition'=>'title LIKE :keyword',
			'order'=>'title DESC',
			'limit'=>$limit,
			'params'=>array(
				':keyword'=>'%'.strtr($keyword,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')).'%',
			),
		));
		$titles=array();
		foreach($list_qa as $qa)
			$titles[]=$qa->title;
			return $titles;
	}
	/**
	 * Change status of image
	 * @param integer $id, the ID of image model
	 */
	static function reverseStatus($id){
		$command=Yii::app()->db->createCommand()
		->select('status')
		->from('tbl_image')
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
		$sql='UPDATE tbl_image SET status = '.$status.' WHERE id = '.$id;
		$command=Yii::app()->db->createCommand($sql);
		if($command->execute()) {
			switch ($status) {
 			case self::STATUS_ACTIVE: 
 				$src=Yii::app()->request->getBaseUrl(true).'/images/admin/enable.png';
 				break;
 			case self::STATUS_PENDING:
 				$src=Yii::app()->request->getBaseUrl(true).'/images/admin/disable.png';
 				break;
 			}	
 			$image=Image::model()->findByPk($id);
 			if($image->category=='Banner' && in_array($image->parent_id,array(Banner::CODE_TOP_EN,Banner::CODE_TOP_VI,Banner::CODE_MAIN)))
 			{	
 				$sql='UPDATE image SET status = 0 WHERE id <> '.$id.' AND category = "'.$image->category.'" AND parent_id ='.$image->parent_id;
 				$command=Yii::app()->db->createCommand($sql);
 				$command->execute();
 			}
			return $src;
		}
		else return false;
	}
}