<?php

class StaticPageController extends Controller
{
	public $layout='right';
	/**
	 * Displays all news
	 */
	public function actionIndex()
	{
		$criteria = new CDbCriteria ();
		$criteria->compare ( 'status', News::STATUS_ACTIVE );
		$criteria->order = 'id desc';
		$list_news = new CActiveDataProvider ( 'StaticPage', array ('pagination' => array ('pageSize' => Setting::s ( 'NEWS_PAGE_SIZE', 'News' ) ), 'criteria' => $criteria ) );
		$this->render ( 'list-news', array ('list_news' => $list_news ) );
	}	
	/**
	 * Displays static page
	 */
	public function actionList($cat_alias)
	{	
		$criteria = new CDbCriteria ();
		$criteria->compare ( 'alias', $cat_alias );
		$criteria->compare('type',Category::TYPE_STATICPAGE);
		$cat = Category::model ()->find( $criteria );
		if(isset($cat)) {
				$child_categories=$cat->child_nodes;
 				$list_child_id=array();
 				//Set itself
 				$list_child_id[]=$cat->id;
 				foreach ($child_categories as $id=>$child_cat){
 					$list_child_id[]=$id;
 				}
				$criteria=new CDbCriteria;
				$criteria->addInCondition('catid',$list_child_id);
				$criteria->compare('status',StaticPage::STATUS_ACTIVE);
				$criteria->order='id desc';
				$list_page=new CActiveDataProvider('StaticPage', array(
					'pagination'=>array(
						'pageSize'=>Setting::s('STATICPAGE_PAGE_SIZE','StaticPage'),
					),
					'criteria'=>$criteria,
				));
				$this->render('list-page',array(
					'cat'=>$cat,
					'list_page'=>$list_page
				));
		}	
	}	
	public function actionView($cat_alias,$staticPage_alias="")
	{
		$criteria = new CDbCriteria ();
		$criteria->compare ( 'alias', $cat_alias );
		$criteria->compare('type',Category::TYPE_STATICPAGE);
		$cat = Category::model ()->find( $criteria );
		if(isset($cat)) {
		$criteria = new CDbCriteria ();
		if (isset ( $cat ))
			$criteria->compare ( 'catid', $cat->id );
		$criteria->compare ( 'alias', $staticPage_alias );
		$page = StaticPage::model ()->find ( $criteria );
		if (isset ( $page )) {
			$page->visits=$page->visits+1;
			$page->save();
			$this->render ( 'page', array ('cat' => $cat, 'page' => $page ) );
		}
		}
	}			
}
