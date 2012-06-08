 <div class="box-search">
 <?php $form=$this->beginWidget('CActiveForm', array('method'=>'get','enableAjaxValidation'=>false,'action'=>Yii::app()->createUrl('search/product'))); ?>
            <?php echo $form->textField($search,'name',array('class'=>'text','onfocus'=>'javascript:if(this.value==\'Tìm kiếm...\'){this.value=\'\';};','onblur'=>'javascript:if(this.value==\'\'){this.value=\'Tìm kiếm...\';};')); ?>
             <?php 
						$list=array(''=>Language::t('Tất cả','layout'));
						foreach ($list_category as $id=>$level){
							$cat=Category::model()->findByPk($id);
							$view = "";
							for($i=1;$i<$level;$i++){
								$view .='---';
							}
							$list[$id]=$view.' '.$cat->name.' '.$view;
						}
						?>
 			<?php echo $form->dropDownList($search,'catid',$list,array('class'=>'sl-search')); ?>
            <div class="search-blur"></div>
            <input name="" type="submit" class="btn-search" value="<?php echo Language::t('Tìm kiếm','layout');?>" />
 <?php $this->endWidget(); ?>
 </div><!--box-search-->
