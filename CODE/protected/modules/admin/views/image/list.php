	<!--begin inside content-->
	<div class="folder top">
		<!--begin title-->
		<div class="folder-header">
			<h1>quản trị ảnh</h1>
			<div class="header-menu">
				<ul>
					<li class="ex-show"><a class="activities-icon" href=""><span>Danh sách ảnh</span></a></li>
				</ul>
			</div>
		</div>
		<!--end title-->
		<div class="folder-content">
            <div>
            	<input type="button" class="button" value="Xóa ảnh rác" style="width:180px;" id="clear_image"/>
                <div class="line top bottom"></div>	
            </div>           
             <!--begin box search-->
         <?php 
			Yii::app()->clientScript->registerScript('search', "
				$('#image-search').submit(function(){
				$.fn.yiiGridView.update('image-list', {
					data: $(this).serialize()});
					return false;
				});");
		?>
            <div class="box-search">            
                <h2>Tìm kiếm</h2>
                <?php $form=$this->beginWidget('CActiveForm', array('method'=>'get','id'=>'image-search')); ?>
                <!--begin left content-->
                <div class="fl" style="width:480px;">
                    <ul>
                        <?php 
							$list=array(''=>'Không lọc','0'=>'Ảnh rác','1'=>'Ảnh đã được gán đối tượng');
						?>	
						<li>
							<?php echo $form->labelEx($model,'group_parent'); ?>
							<?php echo $form->dropDownList($model,'group_parent',$list,array('style'=>'width:200px')); ?>
						</li>                   
                        <li>
                        <?php 
							echo CHtml::submitButton('Lọc kết quả',
    						array(
    							'class'=>'button',
    							'style'=>'margin-left:153px; width:95px;',
    							''
    						)); 						
    					?>
                        </li>
                    </ul>
                </div>
                <!--end left content--> 
                 <!--begin right content-->
                <div class="fl" style="width:480px;">
                    <ul>
					<li>
						<?php echo $form->labelEx($model,'category'); ?>
						<?php echo $form->dropDownList($model,'category',array(''=>'Tất cả')+$model->list_categories,array('style'=>'width:200px')); ?>
					</li>
                    </ul>
                </div>
                <!--end right content-->              
                <?php $this->endWidget(); ?>
                <div class="clear"></div>
                <div class="line top bottom"></div>
            </div>
            <!--end box search-->		
           <?php 
			$this->widget('iPhoenixGridView', array(
  				'id'=>'image-list',
  				'dataProvider'=>$model->search(),		
  				'columns'=>array(			
    				array(
						'name'=>'thumb',
						'value'=>'$data->getAutoThumb()',
						'type'=>'html',
						'headerHtmlOptions'=>array('width'=>'12%','class'=>'table-title'),		
					), 	
					array(
						'name'=>'size',
						'value'=>'$data->size',
						'headerHtmlOptions'=>array('width'=>'7%','class'=>'table-title'),		
					), 
					array(
						'name'=>'category',
						'headerHtmlOptions'=>array('width'=>'10%','class'=>'table-title'),		
					), 	
					array(
						'name'=>'parent',
						'value'=>'$data->getParent_url()',
						'type'=>'html',
						'headerHtmlOptions'=>array('width'=>'40%','class'=>'table-title'),		
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
 	 			'summaryText'=>'Có {count} ảnh',
 	 			'pager'=>array('class'=>'CLinkPager','header'=>'','prevPageLabel'=>'< Trước','nextPageLabel'=>'Sau >','htmlOptions'=>array('class'=>'pages fr')),
 	 			)); ?>
		</div>
	</div>
	<!--end inside content-->
	 <?php 
			Yii::app()->clientScript->registerScript('clear', "
				$('#clear_image').click(function(){
				jQuery.ajax({
  					'success':function(data){
  						if(data.success==true) 
	  						jAlert('Hoàn thành việc dọn dẹp dữ liệu');
        			},
        			'type':'POST',
        			'dataType':'json',
        			'url':'".Yii::app()->createUrl('/admin/image/clear')."',
        			'cache':false,
        		});
        		return false;
				});"
			);
		?>