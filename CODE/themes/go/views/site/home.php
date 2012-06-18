<?php 
$this->pageTitle = 'Trang chủ website '.Setting::s('FRONT_SITE_TITLE','System');
Yii::app()->clientScript->registerMetaTag(Setting::s('META_DESCRIPTION','System'), 'description');
$this->bread_crumbs=array(
	array('url'=>'','title'=>Language::t('Trang chủ','layout')),
);
?>
<div class="show-list">
			<?php foreach ($list_product as $product):?>
            <div class="item">
                <a class="item-img" href="<?php echo $product->url?>"><?php echo $product->getThumb_url('introimage','img');?></a>
                <div class="item-view"><?php echo $product->name?></div>
            </div><!--item-->
            <?php endforeach;?>            
        </div><!--show-list-->
    	<div class="clearfix"></div>
        <div class="home-left">
        	<div class="winget">
                <div class="winget-title"><label>Welcome to Promat</label></div>
                <div class="winget-content">
                	<div class="news-top">
                    	<div class="grid">
                            <div class="g-row">
                               <?php echo iPhoenixString::createIntrotext($static_page->introtext,Setting::s('STATICPAGE_INTRO_LENGTH','StaticPage'));?>
                            </div>
                            <div class="g-right"><a class="view-more" href="<?php echo $static_page->url?>">Xem chi tiết</a></div>
                        </div><!--grid-->
                    </div><!--news-top-->
                </div><!--winget-content-->
            </div><!--winget-->
            <div class="winget">
                <div class="winget-title"><label>Tin tức</label></div>
                <div class="winget-content">
                	<div class="news-home">
                	<?php foreach($list_news as $news):?>
                    	<div class="grid">
                            <a class="img" href="<?php echo $news->url?>"><?php echo $news->getThumb_url('thumb_homepage','')?></a>
                            <div class="g-content">
                            	<div class="g-row"><a class="g-title" href="<?php echo $news->url?>"><?php echo $news->title?></a></div>
                                <div class="g-row">
                                	<?php echo iPhoenixString::createIntrotext($news->introtext,Setting::s('LIST_INTRO_LENGTH','News'));?>
                                </div>
                            </div>
                            <div class="news-home-line"></div>
                        </div><!--grid-->
                       <?php endforeach;?>
                    </div><!--news-home-->
                    <div class="news-home-unline"></div>
                    <div class="news-home-right"><a class="view-more" href="<?php echo Yii::app()->createUrl('news')?>">Xem toàn bộ</a></div>
                </div><!--winget-content-->
            </div><!--winget-->
        </div><!--home-left-->
        <div class="bg-right">
        	<div class="winget">
                <?php $this->widget('wVideo',array('view'=>'video'));?> 
            </div><!--winget-->
            <div class="winget">
                <?php $this->widget('wSupport',array('view'=>'support','limit'=>Setting::s('SIZE_SUPPORT','Support')));?>
            </div><!--winget-->
        </div><!--bg-right-->
        <div class="clearfix"></div>
        <div class="home-add">
        	<a href="<?php echo Yii::app()->createUrl('recruitment/list')?>"><img class="home-add1" src="<?php echo Yii::app()->theme->baseUrl?>/images/banner1.png" /></a>
            <a href="<?php echo Yii::app()->createUrl('recruitment/list')?>"><img class="home-add2" src="<?php echo Yii::app()->theme->baseUrl?>/images/banner2.png" /></a>
        </div><!--home-add-->
