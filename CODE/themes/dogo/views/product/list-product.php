<?php 
if(isset($cat)){
	$this->pageTitle = 'Các sản phẩm trong nhóm '.$cat->name;
	Yii::app()->clientScript->registerMetaTag($cat->metadesc, 'description');	
	Yii::app()->clientScript->registerMetaTag(Keyword::viewListKeyword($cat->keyword), 'keywords');
}
else {
	$this->pageTitle = 'Tất cả sản phẩm';
	Yii::app()->clientScript->registerMetaTag(Setting::s('META_DESCRIPTION','System'), 'description');	
	Yii::app()->clientScript->registerMetaTag(Setting::s('META_KEYWORD','System'), 'keywords');
}
	
$this->bread_crumbs=array(
	array('url'=>Yii::app()->createUrl('site/home'),'title'=>Language::t('Trang chủ','layout')),
	array('url'=>Yii::app()->createUrl('product/index'),'title'=>Language::t('Sản phẩm','layout')),
	array('url'=>'','title'=>isset($cat)?Language::t($cat->name,'layout'):Language::t('Tất cả','layout')),
)
?>
<?php $this->widget('wSearch');?> 
 <div class="big-title"><label><?php if(isset($cat))echo Language::t($cat->name,'layout'); else echo Language::t('Toàn bộ sản phẩm');?></label></div>
            	<?php $this->widget('iPhoenixListView', array(
            		'id'=>'list-product',
					'dataProvider'=>$list_product,
					'itemView'=>'_product',
					'template'=>"{items}\n{pager}",
            		'pager'=>array('class'=>'iPhoenixLinkPager'),
            		'itemsCssClass'=>'product-list',
            		'pagerCssClass'=>'pages-inner',
				)); ?>    