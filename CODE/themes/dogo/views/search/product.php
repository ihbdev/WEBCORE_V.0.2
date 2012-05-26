<?php 
$this->pageTitle = 'Kết quả tìm kiếm';
Yii::app()->clientScript->registerMetaTag(Setting::s('META_DESCRIPTION','System'), 'description');
Yii::app()->clientScript->registerMetaTag(Setting::s('META_KEYWORD','System'), 'keywords');
$this->bread_crumbs=array(
	array('url'=>Yii::app()->createUrl('site/home'),'title'=>Language::t('Trang chủ','layout')),
	array('url'=>'','title'=>Language::t('Kết quả tìm kiếm','layout')),
)
?>
<?php $this->widget('wSearch');?> 
 <div class="big-title"><label><?php echo Language::t('Kết quả tìm kiếm','layout')?></label></div>
            	<?php $this->widget('iPhoenixListView', array(
					'dataProvider'=>$result,
					'itemView'=>'_product',
					'template'=>"{items}\n{pager}",
            		'pager'=>array('class'=>'iPhoenixLinkPager'),
            		'itemsCssClass'=>'product-list',
            		'pagerCssClass'=>'pages-inner',
				)); ?>          	               