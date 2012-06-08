<?php 
Yii::import('zii.widgets.CPortlet');
class wSupport extends CPortlet
{
	public $view;
	public $limit;
	public $special;
	public function init(){
		parent::init();
		
	}
	protected function renderContent()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('status', GalleryVideo::STATUS_ACTIVE);
		$criteria->limit=$this->limit;
		$list_support=Support::model()->findAll($criteria);
		$this->render($this->view,array(
			'list_support'=>$list_support
		));
	}
}
?>
