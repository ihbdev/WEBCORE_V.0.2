
						<div class="grid">
                        	<div class="g-row"><a class="g-title" href="<?php echo $data->url?>"><?php echo $data->title;?></a></div>
                        	<a href="<?php echo $data->url?>"><?php echo $data->getThumb_url('introimage');?></a>
                            <div class="g-content">
                            	<div class="g-row">
                                	<?php echo iPhoenixString::createIntrotext($data->introtext,Setting::s('LIST_INTRO_LENGTH','News'));?> 
                                </div>
                                <div class="g-row">
                                	<span><?php echo date("(d/m/Y | h'm')",$data->created_date); ?></span>
                                    <a class="view-more" href="<?php echo $data->url?>">Chi tiết</a>
                                </div>
                            </div>
                        </div><!--grid-->
