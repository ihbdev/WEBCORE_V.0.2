<?php 
$this->pageTitle = 'Trang tuyển dụng của website '.Setting::s('FRONT_SITE_TITLE','System');
Yii::app()->clientScript->registerMetaTag(Setting::s('META_DESCRIPTION','System'), 'description');
?>
<div class="bg-left">
        	<div class="winget">
                <div class="winget-title"><label><?php echo $recruitment->title?></label></div>
                <div class="winget-content">
                	<div class="main-content">  
                    	<?php 
                    	echo $recruitment->fulltext;
                    	?>
                    </div><!--main-content-->
                     <div class="employee-download">
                    	<?php echo Language::t('Download hồ sơ ứng tuyển'); ?> <?php echo CHtml::link(Language::t('tại đây'),array('/site/download','path'=>$recruitment->attach),array('target'=>'_blank'));	?>
                    </div><!--employee-download-->
                    <?php if($recruitment->catid==Recruitment::EMPLOYEE_GROUP):?>
                    <img class="ad-img1" src="<?php echo Yii::app()->theme->baseUrl?>/images/banner1.png" />
                    <?php else:?>
                    <img class="ad-img2" src="<?php echo Yii::app()->theme->baseUrl?>/images/banner2.png" />
                    <?php endif;?>
                </div><!--winget-content-->
            </div><!--winget-->
        </div><!--bg-left-->
        <div class="bg-right">
        	<?php
        	if($recruitment->catid==Recruitment::EMPLOYEE_GROUP)		
				echo $this->renderPartial('_employee', array('model'=>$model,'catid'=>$recruitment->id)); 			
			else 
				echo $this->renderPartial('_agent', array('model'=>$model,'catid'=>$recruitment->id));
			?>       		        	
        </div><!--bg-right-->
