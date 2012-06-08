<?php

class SearchController extends Controller
{
	/**
	 * This is the action to handle view search page
	 */
	public function actionProduct()
	{
		$search=new SearchForm();
		$criteria = new CDbCriteria ();
		if(isset($_GET['SearchForm'])){
			$search->attributes=$_GET['SearchForm'];
			$criteria->compare ( 'name', $search->name, true );
			//Filter catid
			$cat = Category::model ()->findByPk ( $search->catid );
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
			if($search->end_price != '')
				$criteria->addCondition('num_price <= '.$search->end_price);
			if($search->start_price != '')
				$criteria->addCondition('num_price >= '. $search->start_price);
		}
		$criteria->order = "id DESC";
		$result=new CActiveDataProvider ( 'Product', array ('criteria' => $criteria, 'pagination' => array ('pageSize' => Setting::s('SEARCH_PAGE_SIZE','Product' ) ) ) );
		$this->render( 'product',array('result'=>$result) );
	}		
}