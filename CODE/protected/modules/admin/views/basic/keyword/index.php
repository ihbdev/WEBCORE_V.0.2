	<!--begin inside content-->
	<div class="folder top">
		<!--begin title-->
		<div class="folder-header">
			<h1>quản trị từ khóa</h1>
			<div class="header-menu">
				<ul>
					<li class="ex-show"><a class="activities-icon" href=""><span>Danh sách từ khóa</span></a></li>
				</ul>
			</div>
		</div>
		<!--end title-->
		<div class="folder-content">
		<div>
            	<input type="button" class="button" value="Thêm mới" style="width:180px;" onClick="parent.location='<?php echo Yii::app()->createUrl('admin/keyword/create')?>'"/>
                <div class="line top bottom"></div>	
            </div>
             <!--begin box search-->
         <?php 
			Yii::app()->clientScript->registerScript('search', "
				$('#keyword-search').submit(function(){
				$.fn.yiiGridView.update('keyword-list', {
					data: $(this).serialize()});
					return false;
				});");
		?>
            <div class="box-search">            
                <h2>Tìm kiếm</h2>
                <?php $form=$this->beginWidget('CActiveForm', array('method'=>'get','id'=>'keyword-search')); ?>
                <!--begin left content-->
                <div class="fl" style="width:480px;">
                    <ul>
                        <li>
                         	<label>Từ khóa</label>
                         	<?php $this->widget('CAutoComplete', array(
                         	'model'=>$model,
                         	'attribute'=>'value',
							'url'=>array('keyword/suggestName'),
							'htmlOptions'=>array(
								'style'=>'width:230px;',
								),
						)); ?>								
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
							<label>Nhóm</label>
							<?php echo $form->dropDownList($model,'catid',array(''=>'Tất cả')+$list,array('style'=>'width:200px')); ?>
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
  				'id'=>'keyword-list',
  				'dataProvider'=>$model->search(),		
  				'columns'=>array(
					array(
      					'class'=>'CCheckBoxColumn',
						'selectableRows'=>2,
						'headerHtmlOptions'=>array('width'=>'2%','class'=>'table-title'),
						'checked'=>'in_array($data->id,Yii::app()->session["checked-keyword-list"])'
    				),
    				array(
						'name'=>'catid',
						'value'=>'$data->category->name',
						'headerHtmlOptions'=>array('width'=>'10%','class'=>'table-title'),		
					), 			
					array(
						'name'=>'value',
						'headerHtmlOptions'=>array('width'=>'20%','class'=>'table-title'),		
					), 			
					array(
						'name'=>'amount',
						'value'=>'$data->amount',
						'headerHtmlOptions'=>array('width'=>'10%','class'=>'table-title'),		
					), 															   	   
					array(
						'header'=>'Công cụ',
						'class'=>'CButtonColumn',
    					'template'=>'{update}{delete}',
						'deleteConfirmation'=>'Bạn muốn xóa từ khóa này?',
						'afterDelete'=>'function(link,success,data){ if(success) jAlert("Bạn đã xóa thành công"); }',
    					'buttons'=>array
    					(
    						'update' => array(
    							'label'=>'Chỉnh sửa từ khóa',
    						),
        					'delete' => array(
    							'label'=>'Xóa từ khóa',
    						),
        				),
						'headerHtmlOptions'=>array('width'=>'10%','class'=>'table-title'),
					),    				
 	 			),
 	 			'template'=>'{displaybox}{checkbox}{summary}{items}{pager}',
  				'summaryText'=>'Có tổng cộng {count} tin',
 	 			'pager'=>array('class'=>'CLinkPager','header'=>'','prevPageLabel'=>'< Trước','nextPageLabel'=>'Sau >','htmlOptions'=>array('class'=>'pages fr')),
				'actions'=>array(
 	 				'delete'=>array(
						'action'=>'delete',
						'label'=>'Xóa',
						'imageUrl' => '/images/admin/delete.png',
						'url'=>'admin/keyword/checkbox'
					),			
				),
 	 			)); ?>
		</div>
	</div>
	<!--end inside content-->