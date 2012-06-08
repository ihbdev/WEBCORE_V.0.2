
						<?php foreach ($list_news as $news):?>
                    	<div class="grid">
                        	<a href="<?php echo $news->url?>"><?php echo $news->getThumb_url('intro_left_home_image','img')?></a>
                            <div class="g-content">
                            	<div class="g-row"><a class="g-title" href="<?php echo $news->url;?>"><?php echo $news->title?></a></div>
                            </div>
                        </div><!--grid-->
                        <?php endforeach;?>