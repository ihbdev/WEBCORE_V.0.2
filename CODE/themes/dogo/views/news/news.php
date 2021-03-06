<?php 
$this->pageTitle = 'Bài viết '.$news->title;
Yii::app()->clientScript->registerMetaTag($news->metadesc, 'description');
Yii::app()->clientScript->registerMetaTag(Keyword::viewListKeyword($news->keyword), 'keywords');
if(isset($cat))
	$this->bread_crumbs=array(
		array('url'=>Yii::app()->createUrl('site/home'),'title'=>Language::t('Trang chủ','layout')),
		array('url'=>Yii::app()->createUrl('news/list',array('cat_alias'=>$cat->alias)),'title'=>Language::t($cat->name,'layout')),
		array('url'=>'','title'=>$news->title),
	);
else
	$this->bread_crumbs=array(
		array('url'=>Yii::app()->createUrl('site/home'),'title'=>Language::t('Trang chủ','layout')),
		array('url'=>'','title'=>Language::t($news->title)),
	);
?>
<div class="news-outer">
            	<div class="news-left">
                	<div class="news-detail">
                    	<a class="news-link" href="<?php echo $news->url?>"><?php echo $news->title?></a>
                        <h6><?php echo date("(d/m/Y)",$news->created_date);?></h6>        
                        <div class="news-content">
                        	<?php
								$fulltext=$news->fulltext;
								$list_keyword=Keyword::listKeyword($news->keyword);
								foreach ($list_keyword as $keyword){
									$fulltext=Keyword::autoCreate($news->id,$keyword, $fulltext);
								}
								echo $fulltext;
                        	?>
                        </div><!--news-content-->
                    </div><!--news-detail-->
                    <?php 
            			$list_similar=$news->list_similar;
            		?>
                    <div class="other-list">
                        <h2><?php echo Language::t('Các tin khác');?>:</h2>
                        <ul>
                        <?php foreach ($list_similar as $similar_news):?>
                            <li><a href="<?php echo $similar_news->url?>"><?php echo $similar_news->title?></a><span>(<?php echo date("d/m/Y",$similar_news->created_date); ?>)</span></li>
                       <?php endforeach;?> 
                       </ul>
                    </div><!--other-list-->
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
