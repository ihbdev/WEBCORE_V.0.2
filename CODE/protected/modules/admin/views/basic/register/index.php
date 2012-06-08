	<!--begin inside content-->
	<div class="folder top">
		<!--begin title-->
		<div class="folder-header">
			<h1>quản trị đơn đăng kí</h1>
			<div class="header-menu">
				<ul>
					<li class="ex-show"><a class="activities-icon" href=""><span>Danh sách</span></a></li>
				</ul>
			</div>
		</div>
		<!--end title-->
		<div class="folder-content">
             <!--begin box search-->
         <?php 
			Yii::app()->clientScript->registerScript('search', "
				$('#register-search').submit(function(){
				$.fn.yiiGridView.update('register-list', {
					data: $(this).serialize()});
					return false;
				});");
		?>
            <div class="box-search">            
                <h2>Tìm kiếm</h2>
                <?php $form=$this->beginWidget('CActiveForm', array('method'=>'get','id'=>'register-search')); ?>
                <!--begin left content-->
                <div class="fl" style="width:480px;">
                    <ul>
                      <?php 
					$list=array(''=>'Tất cả các thư mục');
					$list_category=Recruitment::listAll();
					foreach ($list_category as $id=>$content){
						$view = "";
						for($i=1;$i<$content['level'];$i++){
							$view .="---";
						}
						$list[$id]=$view." ".$content['name']." ".$view;
					}
					?>
					<li>
						<?php echo $form->labelEx($model,'catid'); ?>
						<?php echo $form->dropDownList($model,'catid',$list,array('style'=>'width:200px')); ?>
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
                         	<?php echo $form->labelEx($model,'fullname'); ?>
                         	<?php $this->widget('CAutoComplete', array(
                         	'model'=>$model,
                         	'attribute'=>'fullname',
							'url'=>array('register/suggestName'),
							'htmlOptions'=>array(
								'style'=>'width:230px;',
								),
						)); ?>								
                        </li>                   
                    <li>
                         	<?php echo $form->labelEx($model,'email'); ?>
                         	<?php $this->widget('CAutoComplete', array(
                         	'model'=>$model,
                         	'attribute'=>'email',
							'url'=>array('register/suggestEmail'),
							'htmlOptions'=>array(
								'style'=>'width:230px;',
								),
						)); ?>								
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
  				'id'=>'register-list',
  				'dataProvider'=>$model->search(),
  				'columns'=>array(
					array(
      					'class'=>'CCheckBoxColumn',
						'selectableRows'=>2,
						'headerHtmlOptions'=>array('width'=>'2%','class'=>'table-title'),
						'checked'=>'in_array($data->id,Yii::app()->session["checked-register-list"])'
    				),	
    				array(
						'name'=>'catid',
    					'value'=>'$data->category->title',
						'headerHtmlOptions'=>array('width'=>'30%','class'=>'table-title'),		
					), 
    				array(
						'name'=>'fullname',
						'headerHtmlOptions'=>array('width'=>'20%','class'=>'table-title'),		
					), 
					array(
						'name'=>'email',
						'headerHtmlOptions'=>array('width'=>'20%','class'=>'table-title'),		
					),		
					array(
						'name'=>'created_date',
						'value'=>'date("H:i d/m/Y",$data->created_date)',
						'headerHtmlOptions'=>array('width'=>'15%','class'=>'table-title'),		
					), 		  											   	   
					array(
						'header'=>'Công cụ',
						'class'=>'CButtonColumn',
    					'template'=>'{view}{delete}',
						'deleteConfirmation'=>'Bạn muốn xóa câu hỏi này?',
						'afterDelete'=>'function(link,success,data){ if(success) jAlert("Bạn đã xóa thành công"); }',
    					'buttons'=>array
    					(
    						'view' => array(
    							'label'=>'Xem chi tiết',
    						),
        					'delete' => array(
    							'label'=>'Xóa bài viết',
    						),
        				),
						'headerHtmlOptions'=>array('width'=>'20%','class'=>'table-title'),
					),    				
 	 			),
 	 			'template'=>'{displaybox}{checkbox}{summary}{items}{pager}',
  				'summaryText'=>'Có tổng cộng {count} câu hỏi',
 	 			'pager'=>array('class'=>'CLinkPager','header'=>'','prevPageLabel'=>'< Trước','nextPageLabel'=>'Sau >','htmlOptions'=>array('class'=>'pages fr')),
 	 			'actions'=>array(
					'delete'=>array(
						'action'=>'delete',
						'label'=>'Delete all',
						'imageUrl' => '/images/admin/delete.png',
						'url'=>'admin/register/checkbox'
					),
				),
				)); ?>
		</div>
	</div>
	<!--end inside content-->