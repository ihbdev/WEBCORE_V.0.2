	                    	<ul>
	                    		<li>
									<a class="service-img" href="<?php echo Setting::s('PRODUCT_SERVICE_2','Product');?>">
			                    		<?php foreach ($list_images as $image_id):?>
										<?php $image = Image::model ()->findByPk ( $image_id );?>
											<?php if($image_id==$list_images[0])$class='first active'; else $class='';?>
												<img src="<?php echo $image->getThumb('Banner','doxe')?>" class="<?php echo $class;?>"/>
										<?php endforeach;?>
	                                </a>
	                           	 <a class="service-link" href="<?php echo Setting::s('PRODUCT_SERVICE_2','Product');?>">Dịch vụ độ xe</a>
	                            </li>
	                        </ul>