<?php
/**
 * 
 * Register class file 
 * @author ihbvietnam <hotro@ihbvietnam.com>
 * @link http://iphoenix.vn
 * @copyright Copyright &copy; 2012 IHB Vietnam
 * @license http://iphoenix.vn/license
 *
 */

/**
 * Register includes attributes and methods of Register class  
 */
class Register extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_register';
	}
	
	const LIST_ADMIN=10;
	const SIZE_INTRO_CONTENT=50;

	/**
	 * @var array config list other attributes of the banner
	 * this attribute no need to search	 
	 */
	public $old_answer;
	private $config_other_attributes=array('fax','website','company','address','phone','attach');	
	
	private $list_other_attributes;
	
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
		return array(
			array('fullname,email,recruitment_id','required','on'=>'create',),
			array('email','email','on'=>'create'),
			array('phone', 'length', 'max'=>13,'on'=>'create'),
			array('address,attach,company,fax,website', 'safe', 'on'=>'create'),
			array('fullname,email,recruitment_id,company,fax,website','safe','on'=>'search'),
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
			'recruitment'=>array(self::BELONGS_TO,'Recruitment','recruitment_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'phone' => 'Điện thoại',
			'email'=> 'Email',
			'fullname' => 'Họ và tên', 
			'address'=>'Địa chỉ', 
			'created_date'=> 'Ngày tạo',
			'attach'=>'Hồ sơ đính kèm',
			'recruitment_id'=>'Nhóm đơn',
			'fax'=>'Fax',
			'website'=>'Website',
			'company'=>'Công ty'
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
			}	
			else {
				$modified=$this->modified;
				$modified[time()]=Yii::app()->user->id;
				$this->modified=json_encode($modified);	
			}	
			$this->other=json_encode($this->list_other_attributes);
			return true;
		}
		else
			return false;
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
		$criteria->compare('email',$this->email);
		$criteria->compare('fullname',$this->fullname);
		$code=array_diff(explode(',',$this->recruitment_id),array(''));
		if($code[0]=='cat'){
			$criteria_supplement = new CDbCriteria ();
			//Filter recruitment_id
			$cat = Category::model ()->findByPk ( $code[1] );
			if ($cat != null) {
				$child_categories = $cat->child_nodes;
				$list_child_id = array ();
				//Set itself
				$list_child_id [] = $cat->id;
				if ($child_categories != null)
					foreach ( $child_categories as $id => $child_cat ) {
						$list_child_id [] = $id;
					}
				$criteria_supplement->addInCondition ( 'catid', $list_child_id );
				$criteria_supplement->compare('status', Recruitment::STATUS_ACTIVE);
				$list=Recruitment::model()->findAll($criteria_supplement);
				foreach ($list as $recruitment){
					$list_cat_id[]=$recruitment->id;
				}
			}
			$criteria->addInCondition ( 'recruitment_id', $list_cat_id );
		}
		if($code[0]=='item')
			$criteria->compare('recruitment_id',$code[1]);
		if(isset($_GET['pageSize']))
				Yii::app()->user->setState('pageSize',$_GET['pageSize']);
		return new CActiveDataProvider('Register', array(
			'criteria'=>$criteria,
			'pagination'=>array(
        		'pageSize'=>Yii::app()->user->getState('pageSize',Setting::s('DEFAULT_PAGE_SIZE','System')),
    		),
    		'sort' => array ('defaultOrder' => 'id DESC')
		));
	}
	/**
	 * Suggests a list of existing titles matching the specified keyword.
	 * @param string the keyword to be matched
	 * @param integer maximum number of tags to be returned
	 * @return array list of matching username names
	 */
	public function suggestName($keyword,$limit=20)
	{
		$list_register=$this->findAll(array(
			'condition'=>'fullname LIKE :keyword',
			'order'=>'fullname DESC',
			'limit'=>$limit,
			'params'=>array(
				':keyword'=>'%'.strtr($keyword,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')).'%',
			),
		));
		$names=array();
		foreach($list_register as $register)
			$names[]=$register->fullname;
			return $names;
	}
	/**
	 * Suggests a list of existing titles matching the specified keyword.
	 * @param string the keyword to be matched
	 * @param integer maximum number of tags to be returned
	 * @return array list of matching username names
	 */
	public function suggestEmail($keyword,$limit=20)
	{
		$list_register=$this->findAll(array(
			'condition'=>'email LIKE :keyword',
			'order'=>'email DESC',
			'limit'=>$limit,
			'params'=>array(
				':keyword'=>'%'.strtr($keyword,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')).'%',
			),
		));
		$emails=array();
		foreach($list_register as $register)
			$emails[]=$register->email;
			return $emails;
	}
}