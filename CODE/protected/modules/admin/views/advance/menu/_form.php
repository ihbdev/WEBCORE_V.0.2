<?php $form=$this->beginWidget('CActiveForm', array('id'=>'menu-form','enableAjaxValidation'=>true,'clientOptions'=>array('validationUrl'=>$this->createUrl('menu/validate')))); ?>	
<input type="hidden" name="id" id="current_id" value="<?php echo isset($model->id)?$model->id:'0';?>" /> 
			<div class="fl" style="width:580px;">
				<ul>
					<div class="row">
						<li>
                       		<?php echo $form->labelEx($model,'name',array('style'=>'width:200px;')); ?>
                        	<?php echo $form->textField($model,'name',array('style'=>'width:300px;','maxlength'=>'256')); ?>
                   			<?php echo $form->error($model, 'name'); ?>
                    	</li>
                    </div>                           
                    <div class="row">
                    <li>
                        <?php echo $form->labelEx($model,'parent_id',array('style'=>'width:200px;')); ?>
                        <?php
                        	$view_parent_nodes=array('0'=>'Gốc');
                        	 foreach ($model->parent_nodes as $id=>$level){
                        	 	$node=Menu::model()->findByPk($id);
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
                     <?php if(!$model->isNewRecord):?>
                    <div class="row">
                    <li>
                        <?php echo $form->labelEx($model,'order_view',array('style'=>'width:200px;')); ?>
                        <?php 
                           	$list_order=array(); 
                           	$max_order=$model->list_order_view;  
                        	for($i=1;$i<=sizeof($max_order);$i++){
                        		$list_order[$i]=$i;
                        	}                
                        	echo $form->dropDownList($model,'order_view',$list_order,array('style'=>'width:50px')); 
                        ?>
                  		<?php echo $form->error($model, 'order_view'); ?>
					</li>  
					</div>
					<?php endif;?>  
                    <div class="row">
                    <li>
                        <?php echo $form->labelEx($model,'controller',array('style'=>'width:200px;')); ?>
                        <?php 
                        	if($model->controller =="") $model->controller=Menu::CONTROLLER_DEFAULT;
                           	$list_controller=$model->codeUrl('controller');             
                        	echo $form->dropDownList($model,'controller',$list_controller,array('style'=>'width:200px')); 
                        ?>
                  		<?php echo $form->error($model, 'controller'); ?>
					</li>  
					</div>
					<div class="row">
                    <li>
                        <?php echo $form->labelEx($model,'action',array('style'=>'width:200px;')); ?>
                        <?php 
                        	if($model->action =="") $model->action=Menu::ACTION_DEFAULT;
                           	$list_action=$model->codeUrl('action',array('controller'=> $model->controller));            
                        	echo $form->dropDownList($model,'action',$list_action,array('style'=>'width:200px')); 
                        ?>
                  		<?php echo $form->error($model, 'action'); ?>
					</li>  
					</div>
					<?php if(sizeof($model->getListParams($model->controller,$model->action))>0):?>
                   <div class="row">
                   <?php else :?>
                   <div class="row" style="display:none">
                   <?php endif;?>
						<li>
                       	<?php echo $form->labelEx($model,'params',array('style'=>'width:200px;')); ?>
                        <?php 
                           	$list_params=$model->getListParams($model->controller,$model->action);         
                        	echo $form->dropDownList($model,'params',$list_params,array('style'=>'width:200px')); 
                        ?>
                  		<?php echo $form->error($model, 'params'); ?>
                    	</li>
                    </div>
                    <div class="row">
						<li>
                       		<?php echo $form->labelEx($model,'description',array('style'=>'width:200px;')); ?>
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
                    	
						echo '<input type="submit" value="'.$label_button.'" style="margin-left:153px; width:125px;" id="write-menu" class="button">';  
    					if($action=="update") 
                    	{   
    						echo '<input type="submit" value="Tạo danh mục mới" style="margin-left:10px; width:125px;" id="create-menu" class="button">'; 
                    	}
    					?>  
                    </li>
				</ul>
			</div>
			<?php $this->endWidget(); ?>
<?php 
$cs = Yii::app()->getClientScript(); 
// Script load form update 
$cs->registerScript(
  'js-update-list-order-view',
  "jQuery(
  	function($)
	{ 
		$('body').on(
  			'change',
  			'#Menu_parent_id',	
  			function(){
  				jQuery.ajax({
  					'data':{parent_id : $(this).val()},
  					'success':function(data){  		
  						if($(\"#Menu_order_view\")){				
							$(\"#Menu_order_view\").html(\"\");
							for(var i=1;i<=data;i++){
								if(i==data){
									var option='<option value=\"'+i+'\" selected=\"selected\">'+i+'</option>';
								}
								else {
									var option='<option value=\"'+i+'\">'+i+'</option>';
								}
								$(\"#Menu_order_view\").append(option);
							}
						}
					},
					'type':'GET',
					'url':'".$this->createUrl('menu/updateListOrderView')."',
					'cache':false
				});
				return false;
			}
		);
	}
	);",
  CClientScript::POS_END
);
$cs->registerScript(
  'js-change-controller',
  "jQuery(
  	function($)
	{ 
		$('body').on(
  			'change',
  			'#Menu_controller',	
  			function(){
  				jQuery.ajax({
  					'data':{id:$(\"#current_id\").val(),controller : $(this).val(),action: \"\"},
  					'success':function(data){ 
  						$(\"#Menu_action\").html(\"\"); 
  					  	$.each(data.list_action, function(index, val) {
								if(index==data.selected_action)
									$(\"#Menu_action\").append('<option value=\''+index+'\' selected=\"selected\">'+val+'</option>');
								else 
    								$(\"#Menu_action\").append('<option value=\''+index+'\'>'+val+'</option>');
  							});		
  						if($(\"#Menu_params\")){			
							$(\"#Menu_params\").html(\"\");
							$.each(data.list_params, function(index, val) {
								if(index==data.selected_params)
									$(\"#Menu_params\").append('<option value=\''+index+'\' selected=\"selected\">'+val+'</option>');
								else 
    								$(\"#Menu_params\").append('<option value=\''+index+'\'>'+val+'</option>');
  							});
  							if(data.count>0){
  								$(\"#Menu_params\").parent().parent().show();
  							}
  							else {
  								$(\"#Menu_params\").parent().parent().hide();
  							}	
						}
					},
					'type':'GET',
					'dataType': 'json',
					'url':'".$this->createUrl('menu/configUrl')."',
					'cache':false
				});
				return false;
			}
		);
	}
	);",
  CClientScript::POS_END
);
$cs->registerScript(
  'js-change-action',
  "jQuery(
  	function($)
	{ 
		$('body').on(
  			'change',
  			'#Menu_action',	
  			function(){
  				jQuery.ajax({
  					'data':{id:$(\"#current_id\").val(), action : $(this).val(),controller : $(\"#Menu_controller\").val()},
  					'success':function(data){  		
  						if($(\"#Menu_params\")){				
							$(\"#Menu_params\").html(\"\");
							$.each(data.list_params, function(index, val) {
    							if(index==data.selected)
									$(\"#Menu_params\").append('<option value=\''+index+'\' selected=\"selected\">'+val+'</option>');
								else 
    								$(\"#Menu_params\").append('<option value=\''+index+'\'>'+val+'</option>');
  							});
  							if(data.count>0){
  								$(\"#Menu_params\").parent().parent().show();
  							}
  							else {
  								$(\"#Menu_params\").parent().parent().hide();
  							}	
						}
					},
					'type':'GET',
					'dataType': 'json',
					'url':'".$this->createUrl('menu/configUrl')."',
					'cache':false
				});
				return false;
			}
		);
	}
	);",
  CClientScript::POS_END
);
?>