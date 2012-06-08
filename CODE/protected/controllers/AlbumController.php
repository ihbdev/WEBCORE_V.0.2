<?php

class AlbumController extends Controller
{
	/**
	 * Displays all album
	 */
	public function actionIndex()
	{	
				$criteria=new CDbCriteria;
				$criteria->compare('status',Album::STATUS_ACTIVE);
				$criteria->order='id desc';
				$list_album=new CActiveDataProvider('Album', array(
					'pagination'=>array(
						'pageSize'=>Setting::s('ALBUM_PAGE_SIZE','Album'),
					),
					'criteria'=>$criteria,
				));
				$this->render('list-album',array(
					'list_album'=>$list_album
				));
	}	
	/**
	 * Displays album
	 */
	public function actionList($cat_alias)
	{	
		$criteria = new CDbCriteria ();
		$criteria->compare ( 'alias', $cat_alias );
		$criteria->compare('type',Category::TYPE_ALBUM);
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
				$criteria->compare('status',Album::STATUS_ACTIVE);
				$criteria->order='id desc';
				$list_album=new CActiveDataProvider('Album', array(
					'pagination'=>array(
						'pageSize'=>Setting::s('ALBUM_PAGE_SIZE','Album'),
					),
					'criteria'=>$criteria,
				));
				$this->render('list-album',array(
					'cat'=>$cat,
					'list_album'=>$list_album
				));
		}	
	}	
	public function actionView($cat_alias,$album_alias)
	{
		$criteria = new CDbCriteria ();
		$criteria->compare ( 'alias', $cat_alias );
		$criteria->compare('type',Category::TYPE_ALBUM);
		$cat = Category::model ()->find( $criteria );
		if(isset($cat)) {
		$criteria = new CDbCriteria ();
		if (isset ( $cat ))
			$criteria->compare ( 'catid', $cat->id );
		$criteria->compare ( 'alias', $album_alias );
		$album = Album::model ()->find ( $criteria );
		if (isset ( $album )) {
			$album->visits=$album->visits+1;
			$album->save();
			$this->render ( 'album', array ('cat' => $cat, 'album' => $album ) );
		}
		}
	}			
}

