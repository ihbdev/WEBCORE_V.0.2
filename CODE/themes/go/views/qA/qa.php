<?php 
$this->type_menu_left = Category::TYPE_QA;
$this->pageTitle = 'Trả lời câu hỏi '.$qa->question;
if(isset($cat))
	$this->current_catid=$cat->id;
Yii::app()->clientScript->registerMetaTag($qa->metadesc, 'description');
Yii::app()->clientScript->registerMetaTag(Keyword::viewListKeyword($qa->keyword), 'keywords');
?>
 <div class="box">
                <div class="box-title">
                	<label><?php echo Language::t($cat->name);?></label>
                </div>
                <div class="box-content">
                    <div class="news-detail">
                        <div class="news-title"><?php echo $qa->title?></div>
                        <div class="news-maindetail">
                            <span class="news-time"><?php echo Language::t('Câu hỏi'); ?>:</span>
                            <div class="faq-short">
                            	<?php echo $qa->question?>
                            </div>
                            <span class="news-time"><?php echo Language::t('Câu trả lời'); ?>:</span>
                            <?php echo $qa->answer;?>
                        </div><!--news-maindetail-->	
                    </div><!--news-detail-->
                    <div class="other-list">
                        <h2><?php echo Language::t('Câu hỏi khác'); ?>:</h2>
                         <?php 
            				$list_similar=$qa->list_similar;
            			?>
                        <ul>
                        	<?php foreach ($list_similar as $similar_news):?>
                            	<li><a href="<?php echo $similar_news->url?>"><?php echo $similar_news->title?></a><span>(<?php echo date("d/m/Y",$similar_news->created_date); ?>)</span></li>
                       		<?php endforeach;?>                            
                        </ul>
                    </div><!--other-list-->
                </div><!--box-content-->
            </div><!--box-->  