<?php 
$this->bread_crumbs=array(
	array('url'=>Yii::app()->createUrl('site/home'),'title'=>Language::t('Trang chủ')),
	array('url'=>'','title'=>Language::t('Liên hệ')),
)
?>
<?php  
  $cs = Yii::app()->getClientScript();
  $cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/contact.js', CClientScript::POS_END);
?>
			<div class="box">
			 	<div class="box-title"><label>Liên hệ</label></div>
                <div class="box-content">
                	<?php $form=$this->beginWidget('CActiveForm', array('method'=>'post','enableAjaxValidation'=>false,'htmlOptions'=>array('class'=>'contact-form form','style'=>'display:block'))); ?>
	                    <?php
	    					foreach(Yii::app()->user->getFlashes() as $key => $message) {
	        					echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
	    					}
						?>
                        <div class="row fix-inline">
                            <h3>(*) Phần thông tin bắt buộc:</h3>
                        </div>
                        <div class="row fix-inline">
                            <?php echo $form->labelEx($model,'fullname'); ?>
	                        <?php echo $form->textField($model,'fullname',array('style'=>'width:288px;')); ?>	
							<?php echo $form->error($model, 'fullname'); ?>
                        </div>
                        <div class="row fix-inline">
                            <?php echo $form->labelEx($model,'email'); ?>
	                        <?php echo $form->textField($model,'email',array('style'=>'width:288px;')); ?>	
							<?php echo $form->error($model, 'email'); ?>
                        </div>
                        <div class="row fix-inline">
							<?php echo $form->labelEx($model,'phone'); ?>
							<?php echo $form->textField($model,'phone',array('style'=>'width:288px;')); ?>	
							<?php echo $form->error($model, 'phone'); ?>
                        </div>
                        <div class="row fix-inline">
                            <?php echo $form->labelEx($model,'address'); ?>
	                        <?php echo $form->textField($model,'address',array('style'=>'width:288px;')); ?>	
							<?php echo $form->error($model, 'address'); ?>
                        </div>
                        <div class="row fix-inline">
							<?php echo $form->labelEx($model,'content'); ?>
		                    <?php echo $form->textField($model,'content',array('style'=>'width:400px; min-height:150px;')); ?>	
							<?php echo $form->error($model, 'content'); ?>
                        </div>
                        <div class="row">
                            <input type="submit" value="Gửi đi" class="button" name="btn-submit" />
                        </div>
                    <?php $this->endWidget(); ?>	
                </div><!--box-content-->
            </div><!--box-->
            <div class="box">
                <div class="box-title"><label>Địa chỉ liên hệ</label></div>
                <div class="box-content">
                	<div class="box-address">
                    	<div class="item-address">
                        	<h3>Hà nội : 03 cơ sở</h3>
                            <p><b>623 Đường Nguyễn Trãi - Thanh Xuân - Hà nội</b><a title="623 Đường Nguyễn Trãi - Thanh Xuân - Hà nội" class="map-link" href="<?php echo Yii::app()->theme->baseUrl?>/images/data/map.jpg">(Bản đồ)</a></p>
                            <p>ĐT : 04.3552.1980 - 04.3552.0266</p>
                            <br />
                            <p><b>371A Trần Khát Chân - Hai Bà Trưng - Hà nội</b><a title="371A Trần Khát Chân - Hai Bà Trưng - Hà nội" class="map-link" href="<?php echo Yii::app()->theme->baseUrl?>/images/data/map.jpg">(Bản đồ)</a></p>
                            <p>ĐT : 04.39 72 73 99 - 04.399 47 668</p>
                            <br />
                            <p><b>76 Nguyễn Phong Sắc - Cầu Giấy - Hà nội</b><a title="76 Nguyễn Phong Sắc - Cầu Giấy - Hà nội" class="map-link" href="<?php echo Yii::app()->theme->baseUrl?>/images/data/map.jpg">(Bản đồ)</a></p>
                            <p>ĐT : 04.37 93 21 90 - 04.399 14 586</p>
                        </div><!--item-address-->
                    </div><!--box-address-->
                </div><!--box-content-->
            </div><!--box-->