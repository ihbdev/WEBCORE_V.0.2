<?php

class NewsController extends Controller
{
	/**
	 * Displays all news
	 */
	public function actionIndex()
	{	
				$criteria=new CDbCriteria;				
				$criteria->compare('status',News::STATUS_ACTIVE);				
				$criteria->order='id desc';
				$list_news=new CActiveDataProvider('News', array(
					'pagination'=>array(
						'pageSize'=>Setting::s('NEWS_PAGE_SIZE','News'),
					),
					'criteria'=>$criteria,
				));
				$this->render('list-news',array(
					'list_news'=>$list_news
				));
	}	
	/**
	 * Displays news
	 */
	public function actionList($cat_alias)
	{	
		$criteria = new CDbCriteria ();
		$criteria->compare ( 'alias', $cat_alias );
		$criteria->compare('type',Category::TYPE_NEWS);
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
				$criteria->compare('status',News::STATUS_ACTIVE);
				$criteria->order='id desc';
				$list_news=new CActiveDataProvider('News', array(
					'pagination'=>array(
						'pageSize'=>Setting::s('NEWS_PAGE_SIZE','News'),
					),
					'criteria'=>$criteria,
				));
				$this->render('list-news',array(
					'cat'=>$cat,
					'list_news'=>$list_news
				));
		}
	}	
	public function actionView($cat_alias,$news_alias)
	{
		$criteria = new CDbCriteria ();
		$criteria->compare ( 'alias', $cat_alias );
		$criteria->compare('type',Category::TYPE_NEWS);
		$cat = Category::model ()->find( $criteria );
		if(isset($cat)){
		$criteria = new CDbCriteria ();
		$criteria->compare ( 'catid', $cat->id );
		$criteria->compare ( 'alias', $news_alias );
		$news = News::model ()->find ( $criteria );
		if (isset ( $news )) {
			$news->visits=$news->visits+1;
			$news->save();
			$this->render ( 'news', array ('cat' => $cat, 'news' => $news ) );
		}
		}
	}	
}
