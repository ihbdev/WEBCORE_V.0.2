                        <div class="grid">
                       	 	<a class="img"><?php echo $data->getThumb_url('thumb_introimage','')?></a>                            
                            <div class="g-content">
                            	<div class="g-row"><a class="g-title" href="<?php echo $data->url?>"><?php echo $data->title?></a></div>
                                <div class="g-row"><span><?php echo date("(d/m/Y)",$data->created_date); ?></span></div>
                                <div class="g-row">
                                	<?php echo iPhoenixString::createIntrotext($data->introtext,Setting::s('LIST_INTRO_LENGTH','News'));?>
                                </div>
                            </div>
                        </div><!--grid-->                
