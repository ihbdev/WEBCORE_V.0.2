<?php 
$this->type_menu_left = Category::TYPE_APP;
$this->pageTitle = 'Bài viết '.$app->title;
Yii::app()->clientScript->registerMetaTag($app->metadesc, 'description');
Yii::app()->clientScript->registerMetaTag(Keyword::viewListKeyword($app->keyword), 'keywords');
if(isset($cat))
	$this->current_catid=$cat->id;
?>
 <div class="box">
                <div class="box-title"><label><?php echo $cat->name;?></label></div>
                <div class="box-content">
                    <div class="news-detail">
                        <div class="news-title"><?php echo $app->title?></div>
                        <div class="news-maindetail">
                        	<div class="thumbnail"><?php echo $app->getThumb_url('introimage','')?></div>
                            <span class="news-time"><?php echo date("(d/m/Y | h'i')",$app->created_date);?></span>
                            <?php
								$fulltext=$app->fulltext;
								$list_keyword=Keyword::listKeyword($app->keyword);
								foreach ($list_keyword as $keyword){
									$fulltext=Keyword::autoCreate($app->id,$keyword, $fulltext);
								}
								echo $fulltext;
                        	?>
                        </div><!--news-maindetail-->	
                    </div><!--news-detail-->
                    <div class="other-list">
                        <h2><?php echo Language::t('Các tin khác');?>:</h2>
                        <?php 
            				$list_similar=$app->list_similar;
            			?>
                        <ul>
                        	<?php foreach ($list_similar as $similar_app):?>
                            	<li><a href="<?php echo $similar_app->url?>"><?php echo $similar_app->title?></a><span>(<?php echo date("d/m/Y",$similar_app->created_date); ?>)</span></li>
                       		<?php endforeach;?>                            
                        </ul>
                    </div><!--other-list-->
                </div><!--box-content-->
            </div><!--box-->             