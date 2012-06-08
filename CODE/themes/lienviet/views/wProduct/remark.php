
                <?php foreach ($list_product as $product):?>
				<div class="item">
                   	<div class="item-top"></div>
                       	<h3><?php echo $product->name;?></h3>
                        <a class="item-img" href="<?php echo $product->url;?>"><?php echo $product->getThumb_url('introimage','img');?></a>
                        <div class="item-view">
                       	<h4><?php echo $product->num_price.' '.$product->unit_price;?></h4>
                        <a class="view-more" href="<?php echo $product->url;?>">Chi tiết</a>
					</div>
				</div><!--item-->
				<?php endforeach;?>
