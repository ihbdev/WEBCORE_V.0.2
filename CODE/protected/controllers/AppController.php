<?php

class AppController extends Controller
{
	/**
	 * Displays all app
	 */
	public function actionIndex()
	{	
				$criteria=new CDbCriteria;				
				$criteria->compare('status',App::STATUS_ACTIVE);				
				$criteria->order='id desc';
				$list_app=new CActiveDataProvider('App', array(
					'pagination'=>array(
						'pageSize'=>Setting::s('APP_PAGE_SIZE','Application'),
					),
					'criteria'=>$criteria,
				));
				$this->render('list-app',array(
					'list_app'=>$list_app
				));
	}	
	/**
	 * Displays app
	 */
	public function actionList($cat_alias)
	{	
		$criteria = new CDbCriteria ();
		$criteria->compare ( 'alias', $cat_alias );
		$criteria->compare('type',Category::TYPE_APP);
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
				$criteria->compare('status',App::STATUS_ACTIVE);
				$criteria->order='id desc';
				$list_app=new CActiveDataProvider('App', array(
					'pagination'=>array(
						'pageSize'=>Setting::s('APP_PAGE_SIZE','Application'),
					),
					'criteria'=>$criteria,
				));
				$this->render('list-app',array(
					'cat'=>$cat,
					'list_app'=>$list_app
				));
		}	
	}	
	public function actionView($cat_alias,$app_alias)
	{
		$criteria = new CDbCriteria ();
		$criteria->compare ( 'alias', $cat_alias );
		$criteria->compare('type',Category::TYPE_APP);
		$cat = Category::model ()->find( $criteria );
		if(isset($cat)){
		$criteria = new CDbCriteria ();
		$criteria->compare ( 'catid', $cat->id );
		$criteria->compare ( 'alias', $app_alias );
		$app = App::model ()->find ( $criteria );
		if (isset ( $app )) {
			$app->visits=$app->visits+1;
			$app->save();
			$this->render ( 'app', array ('cat' => $cat, 'app' => $app ) );
		}
		}
	}	
}
