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
	const TYPE_BOLD=0;
	const TYPE_LINK=1;
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
	 * Get url of keyword
	 * @return keyword's url
	 */
	public function getUrl()
 	{
 		$url=Yii::app()->createUrl("keyword/list",array('keyword'=>$this->value));
		return $url;
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
		$list=array();
		$criteria = new CDbCriteria ();
		$cat=Category::model()->findByPk($catid);
		if(isset($cat)){
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
		}
		return $list;
	}
	/**
	 * Get list keywords
	 */
	static function viewListKeyword($catid)
	{
		$criteria = new CDbCriteria ();
		$cat=Category::model()->findByPk($catid);
		if(isset($cat)){
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
			return implode(', ', array_unique( $list_keywords ) );
		} else {
			return Setting::s ( 'META_KEYWORD', 'System' );
		}
	}
	/**
	 * Get list keywords
	 */
	static function viewListKeywordLink($catid)
	{
		$criteria = new CDbCriteria ();
		$cat=Category::model()->findByPk($catid);
		if(isset($cat)){
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
			$list_keywords[]='<a href='.$keyword->url.'>'.$keyword->value.'</a>';
		}		
			return implode(', ', array_unique( $list_keywords ) );
		} else {
			return Setting::s ( 'META_KEYWORD', 'System' );
		}
	}
	/**
	 * Get list keywords
	 */
	static function listCategory($keyword) {
		//Find keyword
		$criteria = new CDbCriteria ();
		$criteria->compare ( 'value', $keyword );
		$list_keyword = Keyword::model ()->findAll ( $criteria );
		$list_categories=array();
		foreach ( $list_keyword as $keyword ) {
			$criteria = new CDbCriteria ();
			$cat = Category::model ()->findByPk ( $keyword->catid );
			if (isset ( $cat )) {
				$child_categories = $cat->bread_crumb;
 				foreach ($child_categories as $id){
	 				$list_categories[]=$id;
	 			}
			}
		}
		return array_unique($list_categories);
	}	
	/**
	 * Auto create link
	 */
	static function autoCreate($object_id,$keyword,$origin) {
		$list_categories=array();
		$cat = Category::model ()->findByPk ( $keyword->catid );
			if (isset ( $cat )) {
				$child_categories = $cat->bread_crumb;
 				foreach ($child_categories as $id){
	 				$list_categories[]=$id;
	 			}
			}
		$criteria = new CDbCriteria ();
		$criteria->addInCondition('keyword',$list_categories);
		$criteria->addCondition('id <> '.$object_id);
		$criteria->order='Rand()';
		$product=News::model()->find($criteria);
		switch(array_rand(array(self::TYPE_BOLD,self::TYPE_LINK))){
			case self::TYPE_BOLD :
				$change='<b>'.$keyword->value.'</b>';
				break;
			case self::TYPE_LINK :
				$change='<a href="'.$product->url.'">'.$keyword->value.'</a>';
				break;
		}
		$origin=html_entity_decode ($origin, ENT_NOQUOTES ,'UTF-8');	
		$result=preg_replace('/'.$keyword->value.'/',$change,$origin,1);
		return $result;
	}	
}