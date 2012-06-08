<?php 
$this->type_menu_left = Category::TYPE_NEWS;
$this->pageTitle = 'Bài viết '.$news->title;
Yii::app()->clientScript->registerMetaTag($news->metadesc, 'description');
Yii::app()->clientScript->registerMetaTag(Keyword::viewListKeyword($news->keyword), 'keywords');
if(isset($cat))
	$this->current_catid=$cat->id;
?>
 <div class="box">
                <div class="box-title"><label><?php echo Language::t($cat->name);?></label></div>
                <div class="box-content">
                    <div class="news-detail">
                        <div class="news-title"><?php echo $news->title?></div>
                        <div class="news-maindetail">
                        	<div class="thumbnail"><?php echo $news->getThumb_url('introimage','')?></div>
                            <span class="news-time"><?php echo date("(d/m/Y | h'i')",$news->created_date);?></span>
                            <?php
								$fulltext=$news->fulltext;
								$list_keyword=Keyword::listKeyword($news->keyword);
								foreach ($list_keyword as $keyword){
									$fulltext=Keyword::autoCreate($news->id,$keyword, $fulltext);
								}
								echo $fulltext;
                        	?>
                        </div><!--news-maindetail-->	
                    </div><!--news-detail-->
                    <div class="other-list">
                        <h2><?php echo Language::t('Các tin khác');?>:</h2>
                        <?php 
            				$list_similar=$news->list_similar;
            			?>
                        <ul>
                        	<?php foreach ($list_similar as $similar_news):?>
                            	<li><a href="<?php echo $similar_news->url?>"><?php echo $similar_news->title?></a><span>(<?php echo date("d/m/Y",$similar_news->created_date); ?>)</span></li>
                       		<?php endforeach;?>                            
                        </ul>
                    </div><!--other-list-->
                </div><!--box-content-->
            </div><!--box-->             