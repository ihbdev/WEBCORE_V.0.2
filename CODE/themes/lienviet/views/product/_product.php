
                    	<div class="item">
                        	<div class="item-top"></div>
                        	<h3><?php echo $data->name?></h3>
                            <a class="item-img" href="<?php echo $data->url?>">
								<?php echo $data->getThumb_url('introimage');?>
							</a>
                            <div class="item-view">
                            	<h4><?php if($data->num_price!=0)echo Language::t('Giá').':'.number_format($data->num_price, 0, ',', '.').' '.$data->unit_price; else echo 'CALL';?></h4>
                                <a class="view-more" href="<?php echo $data->url?>">Chi tiết</a>
                            </div>
						</div><!--item-->