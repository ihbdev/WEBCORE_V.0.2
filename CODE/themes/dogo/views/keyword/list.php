<?php 
$this->pageTitle = 'Lọc theo từ khóa '.$keyword;
Yii::app()->clientScript->registerMetaTag(Setting::s('META_DESCRIPTION','System'), 'description');
Yii::app()->clientScript->registerMetaTag(Setting::s('META_KEYWORD','System'), 'keywords');
$this->bread_crumbs=array(
	array('url'=>Yii::app()->createUrl('site/home'),'title'=>Language::t('Trang chủ','layout')),
	array('url'=>'','title'=>Language::t('Từ khóa '.$keyword,'layout')),
)
?>
<?php $this->widget('wSearch');?> 
 <div class="big-title"><label><?php echo Language::t('Sản phẩm','layout')?></label></div>
            	<?php $this->widget('iPhoenixListView', array(
					'dataProvider'=>$list_product,
					'itemView'=>'_product',
					'template'=>"{items}\n{pager}",
            		'pager'=>array('class'=>'iPhoenixLinkPager'),
            		'itemsCssClass'=>'product-list',
            		'pagerCssClass'=>'pages-inner',
				)); ?>
 <div class="big-title"><label><?php echo Language::t('Bài viết','layout')?></label></div>
            	<?php $this->widget('iPhoenixListView', array(
					'dataProvider'=>$list_news,
					'itemView'=>'_news',
					'template'=>"{items}\n{pager}",
            		'pager'=>array('class'=>'iPhoenixLinkPager'),
            		'itemsCssClass'=>'product-list',
            		'pagerCssClass'=>'pages-inner',
				)); ?> 
 <div class="big-title"><label><?php echo Language::t('Album','layout')?></label></div>
            	<?php $this->widget('iPhoenixListView', array(
					'dataProvider'=>$list_album,
					'itemView'=>'_album',
					'template'=>"{items}\n{pager}",
            		'pager'=>array('class'=>'iPhoenixLinkPager'),
            		'itemsCssClass'=>'product-list',
            		'pagerCssClass'=>'pages-inner',
				)); ?> 
 <div class="big-title"><label><?php echo Language::t('Video','layout')?></label></div>
            	<?php $this->widget('iPhoenixListView', array(
					'dataProvider'=>$list_video,
					'itemView'=>'_video',
					'template'=>"{items}\n{pager}",
            		'pager'=>array('class'=>'iPhoenixLinkPager'),
            		'itemsCssClass'=>'product-list',
            		'pagerCssClass'=>'pages-inner',
            	));
            	?>
