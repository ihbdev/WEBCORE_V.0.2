	<!--begin inside content-->
	<div class="folder top">
		<!--begin title-->
		<div class="folder-header">
			<h1>quản trị các tư vấn viên</h1>
			<div class="header-menu">
				<ul>
					<li><a class="header-menu-active new-icon" href=""><span>Chỉnh sửa thông tin tư vấn viên </span></a></li>					
				</ul>
			</div>
		</div>
		<!--end title-->	
		<div class="folder-content form">
			<div>
                <input type="button" class="button" value="Thêm tư vấn viên" style="width:180px;" onClick="parent.location='<?php echo Yii::app()->createUrl('admin/support/create')?>'"/>
                <input type="button" class="button" value="Danh sách tư vấn viên" style="width:180px;" onClick="parent.location='<?php echo Yii::app()->createUrl('admin/support/index')?>'"/>
                <div class="line top bottom"></div>	
            </div>
			<?php $form=$this->beginWidget('CActiveForm', array('method'=>'post','enableAjaxValidation'=>true)); ?>	
			<!--begin left content-->
			<div class="fl" style="width:480px;">
				<ul>             
                    <div class="row">
                     <?php 
						$list=array();
						foreach ($list_category as $id=>$level){
							$cat=Category::model()->findByPk($id);
							$view = "";
							for($i=1;$i<$level;$i++){
								$view .="---";
							}
							$list[$id]=$view." ".$cat->name." ".$view;
						}
						?>
                    <li>
                        <?php echo $form->labelEx($model,'catid'); ?>
                        <?php echo $form->dropDownList($model,'catid',$list,array('style'=>'width:150px')); ?>
                  		<?php echo $form->error($model, 'catid'); ?>
                    </li>
                    </div>
				    <div class="row">
                    <li>
                        <?php echo $form->labelEx($model,'yahoo'); ?>
                        <?php echo $form->textField($model,'yahoo',array('style'=>'width:150px')); ?>
                  		<?php echo $form->error($model, 'yahoo'); ?>
                    </li>
                    </div>
                     <div class="row">
                    <li>
                        <?php echo $form->labelEx($model,'skype'); ?>
                        <?php echo $form->textField($model,'skype',array('style'=>'width:150px')); ?>
                  		<?php echo $form->error($model, 'skype'); ?>
                    </li>
                    </div>
                     <div class="row">
                    <li>
                        <?php echo $form->labelEx($model,'name'); ?>
                        <?php echo $form->textField($model,'name',array('style'=>'width:150px')); ?>
                  		<?php echo $form->error($model, 'name'); ?>
                    </li>
                    </div>
                    <li>
                   		<input type="reset" class="button" value="Hủy thao tác" style="margin-left:153px; width:125px;" />
                    	<input type="submit" class="button" value="Cập nhật" style="margin-left:20px; width:125px;" />					 
                    	</li>
				</ul>
			</div>
			<!--end left content-->	
			<!--begin right content-->
			<div class="fl menu-tree" style="width:470px;">
			<ul>
				 <div class="row">
						<li>
                       		<?php echo $form->labelEx($model,'description',array('style'=>'width:200px;')); ?>
                        	<?php echo $form->textArea($model,'description',array('style'=>'width:300px;max-width:300px;','rows'=>6)); ?>
                   			<?php echo $form->error($model, 'description'); ?>
                    	</li>
                    </div>
			</ul>
			</div>		
			<?php $this->endWidget(); ?>
			<div class="clear"></div>
		</div>
	</div>
	<!--end inside content-->