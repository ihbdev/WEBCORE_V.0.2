<div class="search-product">
            	<label>Tùy chọn</label>
            	<?php $form=$this->beginWidget('CActiveForm', array('method'=>'get','enableAjaxValidation'=>false,'action'=>Yii::app()->createUrl('search/product'))); ?>	
                <?php echo $form->textField($search,'name'); ?>	
                <?php 
						$list=array(''=>Language::t('Tất cả','layout'));
						foreach ($list_category as $id=>$cat){
							$view = "";
							for($i=1;$i<$cat['level'];$i++){
								$view .='---';
							}
							$list[$id]=$view.' '.$cat['name'].' '.$view;
						}
						?>
              	<?php echo $form->dropDownList($search,'catid',$list,array('style'=>'width:140px')); ?>
              	<?php echo $form->dropDownList($search,'start_price',array(''=>'Giá từ')+$search->list_start_price,array('style'=>'width:140px')); ?>
              	<?php echo $form->dropDownList($search,'end_price',array(''=>'Đến giá')+$search->list_end_price,array('style'=>'width:140px')); ?>
                <input name="" type="submit" value="<?php echo Language::t('Tìm kiếm','layout');?>" class="btn-filter" />
               <?php $this->endWidget(); ?>
            </div><!--search-product-->
