<?php
/**
 * 
 * ImageController class file 
 * @author ihbvietnam <hotro@ihbvietnam.com>
 * @link http://iphoenix.vn
 * @copyright Copyright &copy; 2012 IHB Vietnam
 * @license http://iphoenix.vn/license
 *
 */

/**
 * ImageController includes actions relevant to Image:
 *** upload image
 *** delete image
 *** update image
 *** list image
 *** clear image
 *** reverse model's status
 *** suggest model's title
 *** load model from id  
 */
class ImageController extends Controller
{
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  
				'actions'=>array('upload'),
				'roles'=>array('image_upload'),
			),
			array('allow',  
				'actions'=>array('list'),
				'roles'=>array('image_list'),
			),
			array('allow',  
				'actions'=>array('suggestTitle'),
				'roles'=>array('image_suggestTitle'),
			),
			array('allow', 
				'actions'=>array('update'),
				'roles'=>array('image_update'),
			),
			array('allow',  
				'actions'=>array('reverseStatus'),
				'roles'=>array('image_reverseStatus'),
			),
			array('allow',  
				'actions'=>array('delete'),
				'roles'=>array('image_delete'),
			),
				array('allow',  
				'actions'=>array('clear'),
				'roles'=>array('image_clear'),
			),
			array('deny', 
				'users'=>array('*'),
			),			
		);
	}

	/**
	 * 
	 * upload image into server
	 */
	public function actionUpload()
	{
		Yii::import("ext.EAjaxUpload.qqFileUploader");
		//Create folder year/month/day
		$folder=Image::createDir('upload');
        $allowedExtensions = array("jpg","gif","png");//array("jpg","jpeg","gif","exe","mov" and etc...
        $sizeLimit = 10 * 1024 * 1024;// maximum file size in bytes
        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $result = $uploader->handleUpload($folder);
        $result=htmlspecialchars(json_encode($result), ENT_NOQUOTES);
        echo $result;// it's array
	}
	
	/**
	 * 
	 * delete model
	 * @param integer $id the ID of model to be deleted
	 */
	public function actionDelete($id)
	{
			if($this->loadModel($id)->delete()) 
				echo '{"status":true,"id":'.$id.'}';
			else 
				echo '{"status":false}';
	}
	
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id) {
			$model = $this->loadModel ( $id );	
			$model->scenario = 'update';
			if (isset ( $_POST ['Image'] )) {
				$model->attributes = $_POST ['Image'];
				if ($model->save ())
					$this->redirect ( array ('update', 'id' => $model->id ) );
			}
			$zoom=(int)Image::MAX_WIDTH_THUMB_IMAGE_UPDATE/$model->width;
			$size['w']=$zoom*$model->width;
			$size['h']=$zoom*$model->height;
			$thumb_url=Yii::app()->request->getBaseUrl(true).'/'.$model->src.'/origin/'.$model->filename.'.'.$model->extension;			
			$this->renderPartial('update', array ('model' => $model,'thumb_url'=> $thumb_url, 'size'=>$size ) );
	}
	
	/**
	 * 
	 * List all images belong to a object (banner or album)
	 * @param $catid
	 * @param $parent_id
	 */
	public function actionList() {
		$model=new Image('search');		
		$model->unsetAttributes();  // clear any default values
		$model->attributes=$_GET['Image'];
		$this->render('list',array(
			'model'=>$model,
		));
	}
	
	/**
	 * 
	 * Clear all image in the list of object (album or banner)
	 */
	public function actionClear()
	{
		$list_images=Image::model()->findAll('parent_id = 0');
		foreach($list_images as $image){
			if(!$image->delete()) {
				echo json_encode(array('success'=>false));
				Yii::app()->end();
			}
		}
		echo json_encode(array('success'=>true));
	}	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 * @return Image $model, the model has ID
	 */
	public function loadModel($id)
	{
		$model=Image::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

}
