<?php 
$this->bread_crumbs=array(
	array('url'=>Yii::app()->createUrl('site/home'),'title'=>Language::t('Trang chủ')),
	array('url'=>Yii::app()->createUrl('site/product'),'title'=>Language::t('Sản phẩm')),
	array('url'=>'','title'=>isset($cat)?Language::t($cat->name):Language::t('Tất cả sản phẩm')),
)
?>
			<div class="box">
				<div class="box-title"><label><?php if(isset($cat))echo Language::t($cat->name); else echo Language::t('Toàn bộ sản phẩm');?></label></div>
				<div class="box-content">
					<div class="product-list">
	            	<?php $this->widget('iPhoenixListView', array(
	            		'id'=>'list-product',
						'dataProvider'=>$list_product,
						'itemView'=>'_product',
						'template'=>"{items}\n{pager}",
	            		'pager'=>array('class'=>'iPhoenixLinkPager'),
	            		'itemsCssClass'=>'product-list',
	            		'pagerCssClass'=>'pages-inner',
					)); ?>
					</div>
                </div><!--box-content-->
            </div><!--box-->