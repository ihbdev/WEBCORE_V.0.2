<?php

class GalleryVideoController extends Controller
{
	/**
	 * Displays all video
	 */
	public function actionIndex()
	{	
				$criteria=new CDbCriteria;
				$criteria->compare('status',GalleryVideo::STATUS_ACTIVE);
				$criteria->order='id desc';
				$list_video=new CActiveDataProvider('GalleryVideo', array(
					'pagination'=>array(
						'pageSize'=>Setting::s('GALLERYVIDEO_PAGE_SIZE','GalleryVideo'),
					),
					'criteria'=>$criteria,
				));
				$this->render('list-video',array(
					'cat'=>$cat,
					'list_video'=>$list_video
				));
	}	
	/**
	 * Displays video
	 */
	public function actionList($cat_alias)
	{	
		$criteria=new CDbCriteria;
		$criteria->compare('alias',$cat_alias);
		$list_cat=Category::model()->findAll($criteria);
		foreach ($list_cat as $category) {
			if($category->findGroup() == Category::GROUP_GALLERYVIDEO) $cat=$category;
		}
		if(isset($cat)) {
				$child_categories=$cat->child_categories;
 				$list_child_id=array();
 				//Set itself
 				$list_child_id[]=$cat->id;
 				foreach ($child_categories as $id=>$child_cat){
 					$list_child_id[]=$id;
 				}
				$criteria=new CDbCriteria;
				$criteria->addInCondition('catid',$list_child_id);
				$criteria->compare('status',GalleryVideo::STATUS_ACTIVE);
				$criteria->order='id desc';
				$list_video=new CActiveDataProvider('GalleryVideo', array(
					'pagination'=>array(
						'pageSize'=>Setting::s('GALLERYVIDEO_PAGE_SIZE','GalleryVideo'),
					),
					'criteria'=>$criteria,
				));
				$this->render('list-video',array(
					'cat'=>$cat,
					'list_video'=>$list_video
				));
		}	
	}	
	public function actionView($cat_alias,$video_alias)
	{	
		$criteria = new CDbCriteria ();
		$criteria->compare ( 'alias', $cat_alias );
		$list_cat = Category::model ()->findAll ( $criteria );
		foreach ( $list_cat as $category ) {
			if ($category->findGroup () == Category::GROUP_GALLERYVIDEO)
				$cat = $category;
		}
		$criteria = new CDbCriteria ();
		if (isset ( $cat ))
			$criteria->compare ( 'catid', $cat->id );
		$criteria->compare ( 'alias', $video_alias );
		$video = GalleryVideo::model ()->find ( $criteria );
		if (isset ( $video )) {
			$video->visits=$video->visits+1;
			$video->save();
			$this->render ( 'video', array ('cat' => $cat, 'video' => $video ) );
		}
	}			
}


