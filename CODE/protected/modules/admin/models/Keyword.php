<?php
/**
 * 
 * Setting class file 
 * @author ihbvietnam <hotro@ihbvietnam.com>
 * @link http://iphoenix.vn
 * @copyright Copyright &copy; 2012 IHB Vietnam
 * @license http://iphoenix.vn/license
 *
 */
/**
 * This is the model class for table "setting".
 */
class Keyword extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/**
	 * @return string the associated database table name
	 */	
	public function tableName()
	{
		return 'tbl_keyword';
	}
	/**
	 * @return array validation rules for model attributes.
	 */	
	public function rules()
	{
		return array(
			array('value,catid','required'),
			array('amount','safe')
		);
	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */	
	public function attributeLabels()
	{
		return array(
			'value' => 'Từ khóa',
			'catid'=>'Nhóm',
			'amount'=>'Số lần xuất hiện'
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
		);
	}
	/**
	 * Return amount object (product, article, album ...) which contains keyword
	 * @return amount object
	 */
	public function getAmount() {
		$result=0;
		$cat=$this->category;
		$list_parents=$cat->bread_crumb;
		foreach ($list_parents as $id){
			$parent_cat= Category::model()->findByPk($id);
			$result += $parent_cat->amount;
		}
		return $result;
	}
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		$criteria = new CDbCriteria ();
		$criteria->compare ( 'value', $this->value );
		//Filter keyword category
		$cat = Category::model ()->findByPk ( $this->catid );
		if ($cat != null) {
			$child_categories = $cat->child_categories;
			$list_child_id = array ();
			//Set itself
			$list_child_id [] = $cat->id;
			if ($child_categories != null)
				foreach ( $child_categories as $id => $child_cat ) {
					$list_child_id [] = $id;
				}
			$criteria->addInCondition ( 'catid', $list_child_id );
		}
		if (isset ( $_GET ['pageSize'] ))
			Yii::app ()->user->setState ( 'pageSize', $_GET ['pageSize'] );
		return new CActiveDataProvider ( $this, array ('criteria' => $criteria, 'pagination' => array ('pageSize' => Yii::app ()->user->getState ( 'pageSize', Setting::s('DEFAULT_PAGE_SIZE','System') ) ), 'sort' => array ('defaultOrder' => 'catid ASC' )    		
		));
	}
	/**
	 * Suggests a list of existing names matching the specified keyword.
	 * @param string the keyword to be matched
	 * @param integer maximum number of tags to be returned
	 * @return array list of matching username names
	 */
	public function suggestName($keyword,$limit=20)
	{
		$list_keywords=$this->findAll(array(
			'condition'=>'value LIKE :keyword',
			'order'=>'value DESC',
			'limit'=>$limit,
			'params'=>array(
				':keyword'=>'%'.strtr($keyword,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')).'%',
			),
		));
		$names=array();
		foreach($list_keywords as $keywords)
			$names[]=$keywords->value;
			return $names;
	}	
	/**
	 * Get list keywords
	 */
	static function listKeyword($catid)
	{
		$criteria = new CDbCriteria ();
		$cat=Category::model()->findByPk($catid);
		$child_categories=$cat->child_categories;
 		$list_child_id=array();
 		//Set itself
 		$list_child_id[]=$cat->id;
 		foreach ($child_categories as $id=>$child_cat){
 			$list_child_id[]=$id;
 		}
		$criteria->addInCondition('catid',$list_child_id);
		$criteria->order = 'value desc';
		$list=Keyword::model()->findAll($criteria);
		$list_keywords=array();
		foreach ($list as $keyword){
			$list_keywords[]=$keyword->value;
		}		
		return implode(', ', array_unique($list_keywords));
	}	
}