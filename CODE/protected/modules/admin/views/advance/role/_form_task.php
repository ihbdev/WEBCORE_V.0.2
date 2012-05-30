<?php $form=$this->beginWidget('CActiveForm', array('id'=>'role-form','enableAjaxValidation'=>true,'clientOptions'=>array('validationUrl'=>$this->createUrl('role/validate',array('type'=>$type))))); ?>	
<input type="hidden" name="id" id="current_id" value="<?php echo isset($model->id)?$model->id:'0';?>" /> 
<input type="hidden" name="group" id="group" value="<?php echo $group?>" /> 
			<div class="fl" style="width:580px;">
				<ul>
				 	<?php if($model->id > 0):?>
                    <div class="row">
						<li>
                       		<label>Mã danh mục</label>
                       		<?php echo $model->id;?>
                    	</li>
                    </div>
                    <?php endif;?>
					<div class="row">
						<li>
                       		<?php echo $form->labelEx($model,'name'); ?>
                        	<?php echo $form->textField($model,'name',array('style'=>'width:300px;','maxlength'=>'256')); ?>
                   			<?php echo $form->error($model, 'name'); ?>
                    	</li>
                    </div> 
                    <div class="row">
                    <li>
                        <?php echo $form->labelEx($model,'parent_id'); ?>
                        <?php
                        	$view_parent_nodes=array(0=>'Gốc');
                        	 foreach ($model->parent_nodes as $id=>$level){
                        	 	$node=Role::model()->findByPk($id);
								$view = "";
								for($i=1;$i<$level;$i++){
									$view .="--";
								}
								$view_parent_nodes[$id]=$view." ".$node->name." ".$view;
							}
                        	echo $form->dropDownList($model,'parent_id',$view_parent_nodes,array('style'=>'width:200px'));
                        ?>
                  		<?php echo $form->error($model, 'parent_id'); ?>
					</li>
                    </div>
                    <?php 
                    $role_model=new Role();
                   	$role_model->type=Role::TYPE_OPERATION;
                   	$list_operations=array();
                    $list=$role_model->list_nodes;
                    foreach ($list as $id=>$level){
                    		$operation=Role::model()->findByPk($id);
							$view = "";
							for($i=1;$i<$level;$i++){
								$view .="---";
							}
							$list_operations[$id]=$view." ".$operation->name." ".$view;
						}
                    ?>                  
                    <div class="row">
                    <li>
                        <?php echo $form->labelEx($model,'value'); ?>
                        <?php 
                        	echo $form->dropDownList($model,'value',$list_operations,array('style'=>'width:150px','size'=>'20','multiple' => 'multiple')); 
                        ?>
                  		<?php echo $form->error($model, 'value'); ?>
					</li>
                    </div> 
                    <div class="row">
						<li>
                       		<?php echo $form->labelEx($model,'description'); ?>
                        	<?php echo $form->textArea($model,'description',array('style'=>'width:300px;max-width:300px;','rows'=>6)); ?>
                   			<?php echo $form->error($model, 'description'); ?>
                    	</li>
                    </div>                                                   
                   	<li>
                    	<?php 
                    	if($action=="update") 
                    	{ 
                    		$label_button="Cập nhật danh mục";     
                    	}
                    	else $label_button="Thêm danh mục";
                    	
						echo '<input type="submit" value="'.$label_button.'" style="margin-left:153px; width:125px;" id="write-role" class="button">';  
    					if($action=="update") 
                    	{   
    						echo '<input type="submit" value="Tạo danh mục mới" style="margin-left:10px; width:125px;" id="create-role" class="button">'; 
                    	}
    					?>  
                    </li>
				</ul>
			</div>
			<?php $this->endWidget(); ?>


