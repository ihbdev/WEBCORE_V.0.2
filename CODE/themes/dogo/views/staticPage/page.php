<?php 
$this->pageTitle = 'Trang '.$page->title;
Yii::app()->clientScript->registerMetaTag($page->metadesc, 'description');
Yii::app()->clientScript->registerMetaTag(Keyword::viewListKeyword($page->keyword), 'keywords');
if(isset($cat))
	$this->bread_crumbs=array(
		array('url'=>Yii::app()->createUrl('site/home'),'title'=>Language::t('Trang chủ','layout')),
		array('url'=>Yii::app()->createUrl('staticPage/list',array('cat_alias'=>$cat->alias)),'title'=>Language::t($cat->name,'layout')),
		array('url'=>'','title'=>Language::t($page->title,'layout')),
	);
else
	$this->bread_crumbs=array(
		array('url'=>Yii::app()->createUrl('site/home'),'title'=>Language::t('Trang chủ')),
		array('url'=>'','title'=>Language::t($page->title)),
	);
?>
<div class="news-outer">
            	<div class="news-left">
                	<div class="news-detail">
                    	<a class="news-link" href="<?php echo $page->url?>"><?php echo $page->title?></a>      
                        <div class="news-content">
                        	<?php echo $page->fulltext?>
                        </div><!--news-content-->
                    </div><!--news-detail-->
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
