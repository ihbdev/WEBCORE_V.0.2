<!--begin inside content-->
	<div class="folder top">
		<!--begin title-->
		<div class="folder-header">
			<h1>Quản trị bài viết về ứng dụng của sản phẩm</h1>
			<div class="header-menu">
				<ul>
					<li><a class="header-menu-active new-icon" href=""><span>Thêm bài viết mới</span></a></li>					
				</ul>
			</div>
		</div>
		<!--end title-->
		<div class="folder-content form">
		<div>
                <input type="button" class="button" value="Danh sách bài viết" style="width:180px;" onClick="parent.location='<?php echo Yii::app()->createUrl('admin/app')?>'"/>
                <div class="line top bottom"></div>	
            </div>
		<?php $form=$this->beginWidget('CActiveForm', array('method'=>'post','enableAjaxValidation'=>true)); ?>	
			<!--begin left content-->
			<div class="fl">
				<ul>
					<div id="above_row">
					<div id="left_row">
						<div class="row">
							<li>
								<?php echo $form->labelEx($model,'title'); ?>
								<?php echo $form->textField($model,'title',array('style'=>'width:280px;','maxlength'=>'256')); ?>	
								<?php echo $form->error($model, 'title'); ?>				
							</li>
						</div>
						<div class="row">
						<li>
                        	<?php echo $form->labelEx($model,'list_special'); ?>
                        	<?php echo $form->dropDownList($model,'list_special',News::getList_label_specials(),array('style'=>'width:250px','multiple' => 'multiple')); ?>
                  			<?php echo $form->error($model, 'list_special'); ?>
                    	</li>
                    	</div>
						<div class="row">
							<li>
								<?php echo $form->labelEx($model,'lang'); ?>
								<?php echo $form->dropDownList(
										$model,
										'lang',
										LanguageForm::getList_languages_exist(),
										array(				
											'style'=>'width:200px'
										)
									); ?>
								<?php echo $form->error($model, 'lang'); ?>
							</li>
						</div>
					   <div class="row">
							<li>
								<?php echo $form->labelEx($model,'introimage'); ?>
								<?php echo $this->renderPartial('/image/_signupload', array('model'=>$model,'attribute'=>'introimage','type_image'=>'introimage')); ?>		
								<?php echo $form->error($model, 'introimage'); ?>
							</li>
						</div>
					</div>
					<div>
						<li>
							<?php echo $form->labelEx($model,'order_view'); ?>
							<?php
							echo $form->dropDownList(
									$model,
									'order_view',
									$model->list_order_view,
									array(		
										'style'=>'width:200px'
									)
								); ?>
							<?php echo $form->error($model, 'order_view'); ?>
						</li>
					</div>
					<div id="right_row">	
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
						<div class="row">
						<li>
							<?php echo $form->labelEx($model,'category'); ?>
							<?php echo $form->dropDownList($model,'catid',$list,array('style'=>'width:200px')); ?>
							<?php echo $form->error($model, 'catid'); ?>
						</li>
						</div>
                    	<div class="row">
							<li>
								<?php echo $form->labelEx($model,'list_suggest'); ?>
								<?php echo $form->textField($model,'list_suggest',array('readonly'=>'readonly','style'=>'width:200px')); ?>	
								<a title="Chọn tin" href="#" onclick="showPopUp();" id="btn-add-product" class="button" style="width: 60px;padding:1px;margin-top:-5px;text-decoration:none;">Chọn tin</a>			
							</li>
						</div>
						<div class="row">
							<li>
								<?php echo $form->labelEx($model,'metadesc'); ?>
								<?php echo $form->textArea($model,'metadesc',array('style'=>'width:280px;max-width:280px;','rows'=>6)); ?>			
							</li>
						</div>
						<?php 
						$list=array();
						foreach ($list_keyword_categories as $id=>$level){
							$cat=Category::model()->findByPk($id);
							$view = "";
							for($i=1;$i<$level;$i++){
								$view .="---";
							}
							$keywords=Keyword::viewListKeyword($id);
							if($keywords != "")
								$list[$id]=$view." ".$cat->name." (".$keywords.") ".$view;
							else 	
								$list[$id]=$view." ".$cat->name." ".$view;
						}
						?>
						<div class="row">
						<li>
							<?php echo $form->labelEx($model,'keyword'); ?>
							<?php echo $form->dropDownList($model,'keyword',$list,array('style'=>'width:200px')); ?>
							<?php echo $form->error($model, 'keyword'); ?>
						</li>
						</div>
					</div>
					</div>		
                    <div class="row">
                    <li>
                        <?php  
                        $this->widget('application.extensions.tinymce.ETinyMce',array('model'=>$model,'attribute'=>'fulltext','language'=>'vi','editorTemplate'=>'full','htmlOptions'=>array('style'=>'width:950px;height:500px'))); 
                        ?>
                        <?php echo $form->error($model,'fulltext'); ?>
                    </li>
                    </div>
                    <li>
						<input type="reset" class="button" value="Hủy thao tác" style="margin-left:15px; width:125px;" />	
						<input type="submit" class="button" value="Cập nhật" style="margin-left:20px; width:125px;" />	
					</li>
				</ul>
			</div>
			<!--end left content-->
			<?php $this->endWidget(); ?>
			<div class="clear"></div>          
		</div>
	</div>
	<!--end inside content-->

<!-- Main popup -->
<div class="bg-overlay"></div>
<div class="main-popup"><a class="popup-close" onclick="hidenPopUp();return false;"></a>
<div class="content-popup">
<div class="folder-content">
<ul>
		<?php 
			Yii::app()->clientScript->registerScript('search-app-suggest', "
				$('#app-search').submit(function(){
				$.fn.yiiGridView.update('app-list', {
					data: $(this).serialize()});
					return false;
				});");
		?>
	 <?php $form=$this->beginWidget('CActiveForm', array('method'=>'get','id'=>'app-search')); ?>
	 <li>
     	<?php echo $form->labelEx($model,'title'); ?>
       	<?php $this->widget('CAutoComplete', array(
        	            	'model'=>$suggest,
                         	'attribute'=>'title',
							'url'=>array('app/suggestTitle'),
							'htmlOptions'=>array(
								'style'=>'width:230px;',
       							'name'=>'SuggestNews[title]'
								),
						)); ?>								
      </li>
	  <?php 
		$list=array(''=>'Tất cả các thư mục');
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
		<label>Thuộc thư mục:</label>
		<?php echo $form->dropDownList($suggest,'catid',$list,array('style'=>'width:200px','name'=>'SuggestNews[catid]')); ?>
	</li>            
	<li>
	<label>&nbsp;</label> 
	<input type="submit" class="button" value="Lọc bài viết">
	</li>
	<?php $this->endWidget(); ?>	
	<li>
	  <?php 
			$this->widget('iPhoenixGridView', array(
  				'id'=>'app-list',
  				'dataProvider'=>$suggest->search(),		
  				'columns'=>array(
					array(
      					'class'=>'CCheckBoxColumn',
						'selectableRows'=>2,
						'headerHtmlOptions'=>array('width'=>'2%','class'=>'table-title'),
						'checked'=>'in_array($data->id,Yii::app()->session["checked-suggest-list"])'
    				),			
    				array(
						'name'=>'title',
						'headerHtmlOptions'=>array('width'=>'20%','class'=>'table-title'),		
					),
					array(
						'name'=>'category',
						'value'=>'$data->label_category',
						'headerHtmlOptions'=>array('width'=>'10%','class'=>'table-title'),		
					), 
					array(
						'name'=>'author',
						'value'=>'$data->author->username',
						'headerHtmlOptions'=>array('width'=>'5%','class'=>'table-title'),		
					), 						
					array(
						'name'=>'created_date',
						'value'=>'date("H:i d/m/Y",$data->created_date)',
						'headerHtmlOptions'=>array('width'=>'10%','class'=>'table-title'),		
					), 	
				),			
 	 			'template'=>'{displaybox}{summary}{items}{pager}',
  				'summaryText'=>'Có {count} tin',
 	 			'pager'=>array('class'=>'CLinkPager','header'=>'','prevPageLabel'=>'< Trước','nextPageLabel'=>'Sau >','htmlOptions'=>array('class'=>'pages fr')),
 	 			)); ?>
	</li>
	<li>
	<input  class="fr button" id="update_suggest" type="submit" value="Cập nhật" style="width:100px; margin-top:10px; margin-right:5px;" />
	<input type="reset" class="fr button p-close" value="Hủy" style="width:100px; margin-top:10px; margin-right:5px;" onclick="hidenPopUp();return false;"/>
</li>
</ul>
</div>
</div>
<!--content-popup--></div>
<!--main-popup-->
<script type="text/javascript">
$("#update_suggest").click(
  		function(){  	
  			name=$("thead :checkbox").attr("name");
			name=name.substring(0, name.length - 4) + "[]";	
  			list_checked=new Array();
			$('input[name="'+name+'"]:checked').each(function(i){
				list_checked[i] = $(this).val();
			});	
			list_unchecked = new Array();
            $('input[name="'+name+'"]').not(':checked').each(function(i){
            	list_unchecked[i]=$(this).val();
			});	
			jQuery.ajax({
				data: {'list-checked':list_checked.toString(), 'list-unchecked':list_unchecked.toString(),},
				success:function(data){
					$('#News_list_suggest').val(data);
					hidenPopUp();
				},
				type:'POST',
				url:'<?php echo $this->createUrl('app/updateSuggest');?>',
				'cache':'false'});
			return false;
		});
</script>