<?php 
$this->bread_crumbs=array(
	array('url'=>Yii::app()->createUrl('site/home'),'title'=>Language::t('Trang chủ')),
)
?>
	            <div class="box">
	                <div class="box-title"><label><?php echo Language::t('Tin nổi bật')?></label></div>
	                <?php $this->widget('wNews',array('view'=>'news-homepage','special'=>News::SPECIAL_REMARK,'limit'=>4))?>
	            </div><!--box-->
	            <div class="box">
	                <div class="box-title"><label><?php echo Language::t('Sản phẩm mới');?></label></div>
	                <div class="box-content">
	                    <div class="product-list">
	                    	<?php $this->widget('wProduct',array('view'=>'remark','limit'=>Setting::s('SIZE_REMARK_PRODUCT','Product')));?>
	                    </div><!--product-list-->
	                </div><!--box-content-->
	            </div><!--box-->
	            <div class="box">
	                <div class="box-title"><label><?php echo Language::t('Sản phẩm nổi bật');?></label></div>
	                <div class="box-content">
	                    <div class="product-list">
	                    	<?php $this->widget('wProduct',array('view'=>'remark','special'=>Product::SPECIAL_REMARK,'limit'=>Setting::s('SIZE_REMARK_PRODUCT','Product')));?>
	                    </div><!--product-list-->
	                </div><!--box-content-->
	            </div><!--box-->