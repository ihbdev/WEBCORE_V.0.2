<?php 
Yii::import('zii.widgets.CPortlet');
class wSearch extends CPortlet
{
	public function init(){
		parent::init();
		
	}
	protected function renderContent()
	{
		$search=new SearchForm();
		$search->name='Tìm kiếm...';
		if(isset($_GET['SearchForm']))
			$search->attributes=$_GET['SearchForm'];
		//List category product
		$model=new Category();		
		$model->type=Category::TYPE_PRODUCT;
		$list=$model->list_nodes;
		$this->render('search',array(
			'search'=>$search,
			'list_category'=>$list
		));
	}
}
?>