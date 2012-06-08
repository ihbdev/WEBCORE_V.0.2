<?php 
$this->pageTitle = 'Trang liên hệ của website '.Setting::s('FRONT_SITE_TITLE','System');
Yii::app()->clientScript->registerMetaTag(Setting::s('META_DESCRIPTION','System'), 'description');
?>
<?php  
  $cs = Yii::app()->getClientScript();
  $cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/contact.js', CClientScript::POS_END);
?>
	<div class="main-left">
        	<div class="winget">
                <div class="winget-title"><label>Liên hệ</label></div>
                <div class="winget-content">
                	 <?php $form=$this->beginWidget('CActiveForm', array('method'=>'post','enableAjaxValidation'=>false,'htmlOptions'=>array('class'=>'contact-form form'))); ?>
                     <?php
    					foreach(Yii::app()->user->getFlashes() as $key => $message) {
        					echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    					}
					 ?>
                        <div class="row fix-inline">
                         	<?php echo $form->labelEx($model,'fullname'); ?>
                        	<?php echo $form->textField($model,'fullname',array('style'=>'width:350px;')); ?>	
							<?php echo $form->error($model, 'fullname'); ?>	        
                        </div>
                        <div class="row fix-inline">
                         	<?php echo $form->labelEx($model,'address'); ?>
                        	<?php echo $form->textField($model,'address',array('style'=>'width:350px;')); ?>	
							<?php echo $form->error($model, 'address'); ?>
                        </div>
                        <div class="row fix-inline">
                        	<?php echo $form->labelEx($model,'phone'); ?>
                        	<?php echo $form->textField($model,'phone',array('style'=>'width:350px;')); ?>	
							<?php echo $form->error($model, 'phone'); ?>
                        </div>
                        <div class="row fix-inline">
                         	<?php echo $form->labelEx($model,'email'); ?>
                        	<?php echo $form->textField($model,'email',array('style'=>'width:350px;')); ?>	
							<?php echo $form->error($model, 'email'); ?>
                        </div>
                        <div class="row fix-inline">
                  			<?php echo $form->labelEx($model,'fax'); ?>
                        	<?php echo $form->textField($model,'fax',array('style'=>'width:350px;')); ?>	
							<?php echo $form->error($model, 'fax'); ?>
                        </div>
                        <div class="row fix-inline">
                            <label>Liên hệ tới:</label>
                            <input name="txt_form" type="text" class="text" style="width:350px;" />
                        </div>
                        <div class="row fix-inline">
                            <?php echo $form->labelEx($model,'content'); ?>
                     		<?php echo $form->textField($model,'content',array('style'=>'width:350px; min-height:150px;')); ?>	
						 	<?php echo $form->error($model, 'content'); ?>
                        </div>
                        <div class="row fix-inline">
                            <label>&nbsp;</label>
                            <input type="submit" value="Gửi đi" class="button" name="btn-submit" />
                        </div>
                    <?php $this->endWidget(); ?>
                </div><!--winget-content-->
            </div><!--winget-->
        </div><!--main-left-->
        <div class="sidebar-right">
       		<div class="winget">
                <div class="winget-title"><label>Địa chỉ</label></div>
                <div class="winget-content">
                    <div class="box-address">  
                    	<h3><?php echo Language::t('Nhà máy','layout');?></h3>
                        <p><b><?php echo Language::t('ĐC','layout');?>:</b> <?php echo Language::t(Setting::s('ADDRESS','System'),'layout');?></p>
                        <p><b><?php echo Language::t('ĐT','layout');?>:</b> <?php echo Language::t(Setting::s('MOBILE','System'),'layout');?> - <?php echo Language::t('Fax','layout');?>: <?php echo Language::t(Setting::s('FAX','System'),'layout');?> </p>
                        <p><b><?php echo Language::t('Mail','layout');?>:</b> <?php echo Language::t(Setting::s('EMAIL','System'),'layout');?></p>
                        <p><b><?php echo Language::t('Bản đồ','layout');?>:</b></p>
                        <div class="box-map">
                        	<div class="map-content">
                            	<img src="images/data/map.jpg" />
                            </div><!--map-content-->
                        </div>
                    </div><!--box-address-->
                </div><!--winget-content-->
            </div><!--winget-->
        </div><!--sidebar-right-->