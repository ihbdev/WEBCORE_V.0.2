<?php 
$this->bread_crumbs=array(
	array('url'=>Yii::app()->createUrl('site/home'),'title'=>Language::t('Trang chủ')),
	array('url'=>Yii::app()->createUrl('staticPage/index',array('cat_alias'=>$cat->alias)),'title'=>Language::t($cat->name)),
	array('url'=>'','title'=>Language::t($page->title)),
)
?>		
			<div class="box">
                <div class="box-title"><label><?php echo $cat->name?></label></div>
                <div class="box-content">
                	<div class="news-detail">
                        <div class="news-title"><?php echo $page->title?></div>
                        <div class="news-maindetail">
                        	<span class="thumbnail"><?php echo $page->getThumb_url('introimage')?></span>
                            <span class="news-time"><?php echo date("(d/m/Y | h'm')",$page->created_date);?></span>
                            <?php echo $page->fulltext?>
                        </div><!--news-maindetail-->
                    </div><!--news-detail-->
					<?php 
            			$list_similar=$page->list_similar;
            		?>
                    <div class="other-list">
                        <h2><?php echo Language::t('Các tin khác');?>:</h2>
                        <ul>
                        <?php 
                        	foreach ($list_similar as $similar_news){
                        		if(isset($similar_news)){
                            		echo '<li><a href="'.$similar_news->url.'">'.$similar_news->title.'</a><span>('.date("d/m/Y",$similar_news->created_date).')</span></li>';
                       			}
                        	}
                       	?> 
                       </ul>
                    </div><!--other-list-->
                    <br />
                </div><!--box-content-->
            </div><!--box-->
