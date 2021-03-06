	<!--begin inside content-->
	<div class="folder top">
		<!--begin title-->
		<div class="folder-header">
			<h1>quản trị ngôn ngữ</h1>
			<div class="header-menu">
				<ul>
					<li><a class="header-menu-active new-icon" href=""><span>Thêm ngôn ngữ</span></a></li>					
				</ul>
			</div>
		</div>
		<!--end title-->	
		<div class="folder-content form">
			<input type="button" class="button" value="Chỉnh sửa" style="width:180px;" onClick="parent.location='<?php echo Yii::app()->createUrl('admin/language/edit')?>'"/>
			<input type="button" class="button" value="Xóa" style="width:180px;" onClick="parent.location='<?php echo Yii::app()->createUrl('admin/language/delete')?>'"/>
			<input type="button" class="button" value="Export" style="width:180px;" onClick="parent.location='<?php echo Yii::app()->createUrl('admin/language/export')?>'"/>
			<input type="button" class="button" value="Import" style="width:180px;" onClick="parent.location='<?php echo Yii::app()->createUrl('admin/language/import')?>'"/>
			<?php
    			foreach(Yii::app()->user->getFlashes() as $key => $message) {
        			echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    			}
			?>
			<?php $form=$this->beginWidget('CActiveForm', array('method'=>'post','enableAjaxValidation'=>false)); ?>	
			<!--begin left content-->
			<div class="fl" style="width:480px;">
				<ul>
				    <div class="row">
                    <li>
                        <?php echo $form->labelEx($model,'lang'); ?>
                        <?php echo $form->dropDownList($model,'lang',LanguageForm::getList_languages_not_exist(),array('style'=>'width:150px')); ?>
                  		<?php echo $form->error($model, 'lang'); ?>
                    </li>
                    </div>
					<div class="row">
                    <li>
                        <?php echo $form->labelEx($model,'origin_lang'); ?>
                        <?php echo $form->dropDownList($model,'origin_lang',LanguageForm::getList_languages_exist(),array('style'=>'width:150px')); ?>
                  		<?php echo $form->error($model, 'origin_lang'); ?>
                    </li>
                    </div>
                   		<li>
                   		<input type="reset" class="button" value="Hủy thao tác" style="margin-left:153px; width:125px;" />
                    	<input type="submit" class="button" value="Tạo" style="margin-left:20px; width:125px;" />					 
                    	</li>
				</ul>
			</div>
			<!--end left content-->			
			<?php $this->endWidget(); ?>
			<div class="clear"></div>
		</div>
	</div>
	<!--end inside content-->