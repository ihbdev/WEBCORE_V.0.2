<?php

class QAController extends Controller
{
		/**
	 * Displays qa
	 */
	public function actionIndex()
	{
			$criteria = new CDbCriteria ();
			$criteria->compare ( 'status', QA::STATUS_ACTIVE );
			$criteria->addInCondition ( 'special', QA::getCode_special ( QA::SPECIAL_ANSWER ) );
			$criteria->order = 'id desc';
			$list_qa = new CActiveDataProvider ( 'QA', array ('pagination' => array ('pageSize' => Setting::s ( 'QA_PAGE_SIZE','QA' ) ), 'criteria' => $criteria ) );
			$this->render ( 'list-qa', array ('list_qa' => $list_qa ) );
	}
	/**
	 * Displays qa
	 */
	public function actionList($cat_alias)
	{	
		$criteria = new CDbCriteria ();
		$criteria->compare ( 'alias', $cat_alias );
		$criteria->compare('type',Category::TYPE_QA);
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
				$criteria->compare ( 'status', QA::STATUS_ACTIVE );
				$criteria->addInCondition ( 'special', QA::getCode_special ( QA::SPECIAL_ANSWER ) );
				$criteria->order='id desc';
				$list_qa=new CActiveDataProvider('QA', array(
					'pagination'=>array(
						'pageSize'=>Setting::s('QA_PAGE_SIZE','QA'),
					),
					'criteria'=>$criteria,
				));
				$this->render('list-qa',array(
					'cat'=>$cat,
					'list_qa'=>$list_qa
				));
		}	
	}	
	/**
	 * Displays qa
	 */
	public function actionView($cat_alias,$qa_alias)
	{
		$criteria = new CDbCriteria ();
		$criteria->compare ( 'alias', $cat_alias );
		$criteria->compare('type',Category::TYPE_QA);
		$cat = Category::model ()->find( $criteria );
		if(isset($cat)) {
		$criteria = new CDbCriteria ();
		if (isset ( $cat ))
			$criteria->compare ( 'catid', $cat->id );
		$criteria->compare ( 'alias', $qa_alias );
		$criteria->compare ( 'status', QA::STATUS_ACTIVE );
		$criteria->addInCondition ( 'special', QA::getCode_special ( QA::SPECIAL_ANSWER ) );
		$qa = QA::model ()->find ( $criteria );
		if (isset ( $qa )) {
				$qa->visits=$qa->visits+1;
				$qa->save();
				$this->render ( 'qa', array ('cat' => $cat, 'qa' => $qa ) );
			}	
		}
	}
	/**
	 * Create question
	 */
	public function actionQuestion()
	{
		$model=new QA('question');
		if(isset($_POST['QA'])){
			$model->attributes=$_POST['QA'];
			$model->title=$model->question;
			if($model->save())
				Yii::app()->user->setFlash('success', Language::t('Câu hỏi đã được gửi thành công'));
		}
		$this->render( 'question' ,array('model'=>$model));
	}
}