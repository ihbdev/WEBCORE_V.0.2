<?php 
$this->bread_crumbs=array(
	array('url'=>Yii::app()->createUrl('site/home'),'title'=>Language::t('Trang chủ')),
	array('url'=>'','title'=>Language::t('Kết quả tìm kiếm')),
)
?>
            <div class="box">
 				<div class="box-title"><label><?php echo Language::t('Tìm kiếm')?></label></div>
				<div class="box-content">
					<div class="row">
						<?php $this->widget('wSearch')?>
					</div>
					<h3>Kết quả tìm kiếm</h3>
	            	<?php $this->widget('iPhoenixListView', array(
						'dataProvider'=>$result,
						'itemView'=>'../product/_product',
						'template'=>"{items}\n{pager}",
	            		'pager'=>array('class'=>'iPhoenixLinkPager'),
	            		'itemsCssClass'=>'product-list',
	            		'pagerCssClass'=>'pages-inner',
					)); ?>
				</div>
			</div>