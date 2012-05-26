<?php 
if(isset($cat)){
	$this->pageTitle = 'Các bài viết trong nhóm '.$cat->name;
	Yii::app()->clientScript->registerMetaTag($cat->metadesc, 'description');	
	Yii::app()->clientScript->registerMetaTag(Keyword::viewListKeyword($cat->keyword), 'keywords');
}
else {
	$this->pageTitle = 'Tất cả bài viết';
	Yii::app()->clientScript->registerMetaTag(Setting::s('META_DESCRIPTION','System'), 'description');
	Yii::app()->clientScript->registerMetaTag(Setting::s('META_KEYWORD','System'), 'keywords');
}
$this->bread_crumbs=array(
	array('url'=>Yii::app()->createUrl('site/home'),'title'=>Language::t('Trang chủ','layout')),
	array('url'=>Yii::app()->createUrl('news/index'),'title'=>Language::t('Tin tức','layout')),
	array('url'=>'','title'=>isset($cat)?Language::t($cat->name,'layout'):Language::t('Tất cả','layout')),
)
?>
<div class="news-outer">
            	<div class="news-left">
                <?php $this->widget('iPhoenixListView', array(
					'dataProvider'=>$list_news,
					'itemView'=>'_news',
					'template'=>"{items}\n{pager}",
            		'pager'=>array('class'=>'iPhoenixLinkPager'),
            		'itemsCssClass'=>'news-list',
            		'pagerCssClass'=>'pages-inner',
				)); 
				?> 
                </div><!--news-left-->
              	<div class="news-right">
                	<div class="winget">
                		<?php $this->widget('wProduct',array('view'=>'best-seller','special'=>Product::SPECIAL_BESTSELLER,'limit'=>Setting::s('SIZE_BESTSELLER_PRODUCT','Product')));?>                    	
                  </div><!--winget-->
                  <div class="ad-right">
                  		<?php $this->widget('wBanner',array('code'=>Banner::CODE_RIGHT,'view'=>'banner-right'))?>
                  </div><!--ad-right-->
                </div><!--news-right-->
            </div><!--news-outer-->