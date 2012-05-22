
					<div class="box-content">
	                    <div class="news-list news-homepage">
                        	<?php 
                        	if($list_news!=NULL): $news = $list_news[0];?>
							<div class="grid">
	                        	<div class="g-row"><a class="g-title" href="<?php echo $news->url?>"><?php echo $news->title?></a></div>
	                        	<a href="<?php echo $news->url?>"><?php echo $news->getThumb_url('introhome_image')?></a>
	                            <div class="g-content">
	                            	<div class="g-row">
	                                	<?php echo iPhoenixString::createIntrotext($news->introtext,Setting::s('LIST_INTROHOME_LENGTH','News'));?> 
	                                </div>
	                                <div class="g-row">
	                                	<span><?php echo date("(d/m/Y | h'm')",$news->created_date);?></span>
	                                    <a class="view-more" href="<?php echo $news->url?>">Chi tiết</a>
	                                </div>
	                            </div>
	                        </div><!--grid-->
	                        <?php endif;?>
	                    </div><!--news-list-->
	                    <div class="other-list">
	                        <h2>Các tin khác:</h2>
	                        <ul>
	                            <?php foreach ($list_news as $news):?>
	                            <?php if($news !=$list_news[0]){
	                            echo '<li><a href="'.$news->url.'">'.$news->title.'</a><span>'.date("(d/m/Y)",$news->created_date).'</span></li>';
	                            }
	                            ?>
	                            <?php endforeach;?>
	                        </ul>
	                    </div><!--other-list-->
	                </div><!--box-content-->