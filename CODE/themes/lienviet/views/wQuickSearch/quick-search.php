 <div class="box-search">
 	<?php $form=$this->beginWidget('CActiveForm', array('method'=>'post','enableAjaxValidation'=>false,'action'=>Yii::app()->createUrl('site/search'))); ?>	
 		<?php echo $form->textField($search,'name',array('class'=>'text','onfocus'=>'javascript:if(this.value==\'Sản phẩm...\'){this.value=\'\';};','onblur'=>'javascript:if(this.value==\'\'){this.value=\'Sản phẩm...\';};')); ?>	
 	   <input name="" type="submit" class="btn-search" />
    <?php $this->endWidget(); ?>
 </div>
