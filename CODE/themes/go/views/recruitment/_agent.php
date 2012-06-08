<div class="winget">
                <div class="winget-title"><label>Gửi hồ sơ</label></div>
                <div class="winget-content">
                    <img class="ad-img2" src="<?php echo Yii::app()->theme->baseUrl?>/images/banner2.png" />
                    <div class="employer-form">
                         <?php $form=$this->beginWidget('CActiveForm', array('method'=>'post','enableAjaxValidation'=>false,'htmlOptions'=>array('class'=>'contact-form form','enctype' => 'multipart/form-data'))); ?>
                            <input type="hidden" value="<?php echo $catid?>" name="Register[recruitment_id]">
                           <?php
    						foreach(Yii::app()->user->getFlashes() as $key => $message) {
        						echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    						}
					 		?>
					 		<div class="row fix-inline">
                                <label>Tên công ty/ cá nhân:</label>
                                <input type="text" value="" name="Register[company]" style="width:300px;" class="text">
                        		<?php echo $form->error($model, 'company'); ?>
                            </div>
                            <div class="row fix-inline">
                           		<label>Họ & tên:</label>
                           		<input type="text" value="" name="Register[fullname]" style="width:300px;" class="text">
                        		<?php echo $form->error($model, 'fullname'); ?>	 		  
                            </div>
                            <div class="row fix-inline">
                                <label>Địa chỉ:</label>
                        		<input type="text" value="" name="Register[address]" style="width:300px;" class="text">
                        		<?php echo $form->error($model, 'address'); ?>	  
                            </div>
                            <div class="row fix-inline">
                			 	<label>Email:</label>
                        		<input type="text" value="" name="Register[email]" style="width:300px;" class="text">
                        		<?php echo $form->error($model, 'email'); ?>	 
                            </div>
                            <div class="row fix-inline">
                             	<label>Điện thoại:</label>    
                        		<input type="text" value="" name="Register[phone]" style="width:300px;" class="text">
                        		<?php echo $form->error($model, 'phone'); ?>
                            </div>
                             <div class="row fix-inline">
                             	<label>Fax:</label>    
                        		<input type="text" value="" name="Register[fax]" style="width:300px;" class="text">
                        		<?php echo $form->error($model, 'fax'); ?>
                            </div>
                             <div class="row fix-inline">
                             	<label>Website:</label>    
                        		<input type="text" value="" name="Register[website]" style="width:300px;" class="text">
                        		<?php echo $form->error($model, 'website'); ?>
                            </div>
                            <div class="row fix-inline">
                               	<label>Hồ sơ đính kèm:</label>
                        		<input type="file" value="" name="Register[attach]" style="width:300px;" class="text">
                        		<?php echo $form->error($model, 'attach'); ?>
                            </div>                           
                            <div class="row fix-inline">
                            	<label>&nbsp;</label>
                                <input type="submit" value="Gửi đi" class="btn-submit button" name="btn-submit" />
                                <input type="reset" value="Nhập lại" class="btn-reset button" name="btn-submit" />
                            </div>
                      <?php $this->endWidget(); ?>	
                    </div><!--employer-form-->
                </div><!--winget-content-->
            </div><!--winget-->
