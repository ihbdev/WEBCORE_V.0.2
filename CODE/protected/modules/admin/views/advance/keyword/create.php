	<!--begin inside content-->
	<div class="folder top">
		<!--begin title-->
		<div class="folder-header">
			<h1>quản trị từ khóa</h1>
			<div class="header-menu">
				<ul>
					<li><a class="header-menu-active new-icon" href=""><span>Thêm từ khóa</span></a></li>					
				</ul>
			</div>
		</div>
		<!--end title-->	
		<div class="folder-content form">
			<div>
                <input type="button" class="button" value="Danh sách từ khóa" style="width:180px;" onClick="parent.location='<?php echo Yii::app()->createUrl('admin/keyword')?>'"/>
                <div class="line top bottom"></div>	
            </div>
			<?php $form=$this->beginWidget('CActiveForm', array('method'=>'post','enableAjaxValidation'=>true)); ?>	
			<!--begin left content-->
			<div class="fl" style="width:480px;">
				<ul>     
				 <?php 
					$list=array();
					foreach ($list_categories as $id=>$cat){
						$view = "";
						for($i=1;$i<$cat['level'];$i++){
							$view .="---";
						}
						$list[$id]=$view." ".$cat['name']." ".$view;
					}
					?>        
                    <div class="row">
                    <li>
                        <?php echo $form->labelEx($model,'catid'); ?>
                        <?php echo $form->dropDownList($model,'catid',$list,array('style'=>'width:150px')); ?>
                  		<?php echo $form->error($model, 'catid'); ?>
                    </li>
                    </div>
				    <div class="row">
                    <li>
                        <?php echo $form->labelEx($model,'value'); ?>
                        <?php echo $form->textField($model,'value',array('style'=>'width:150px')); ?>
                  		<?php echo $form->error($model, 'value'); ?>
                    </li>
                    </div>                       
                    <li>
                   		<input type="reset" class="button" value="Hủy thao tác" style="margin-left:153px; width:125px;" />
                    	<input type="submit" class="button" value="Thêm" style="margin-left:20px; width:125px;" />					 
                    	</li>
				</ul>
			</div>
			<!--end left content-->					
			<?php $this->endWidget(); ?>
			<div class="clear"></div>
		</div>
	</div>
	<!--end inside content-->