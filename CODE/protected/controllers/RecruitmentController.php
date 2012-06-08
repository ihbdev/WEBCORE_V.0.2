<?php
class RecruitmentController extends Controller
{	
	/**
	 * This is the action to handle view home page
	 */
	public function actionView($recruitment_alias)
	{
		$this->layout='right';
		//Get recruitment
		$criteria = new CDbCriteria ();
		$criteria->compare ( 'alias', $recruitment_alias );
		$recruitment = Recruitment::model ()->find ( $criteria );
		$model=new Register('create');
		if(isset($_POST['Register'])){
			$model->attributes=$_POST['Register'];
			$file = CUploadedFile::getInstanceByName('Register[attach]');
			if(isset($file)){
				$path=Image::createDir('upload/attach');
				if($file->saveAs($path.'/'.$file->name)) $model->attach=$path.'/'.$file->name;
			}
			if($model->save())
				Yii::app()->user->setFlash('success', Language::t('Hồ sơ đã được gửi thành công'));	
		}
		$this->render( 
			'view',
			array(
				'recruitment'=>$recruitment,
				'model'=>$model
			));
	}	
	/**
	 * This is the action to handle view home page
	 */
	public function actionList()
	{
		$this->layout='right';
		//Get left recruitment
		$criteria = new CDbCriteria ();
		$criteria->compare('catid',Recruitment::EMPLOYEE_GROUP);
		$criteria->compare('status',Recruitment::STATUS_ACTIVE);
		$list_left=Recruitment::model()->findAll($criteria);
		
		//Get right recruitment
		$criteria = new CDbCriteria ();
		$criteria->compare('catid',Recruitment::AGENT_GROUP);
		$criteria->compare('status',Recruitment::STATUS_ACTIVE);
		$right=Recruitment::model()->find($criteria);
		
		$this->render( 
			'list',
			array(
				'list_left'=>$list_left,
				'right'=>$right
			));
	}		
}