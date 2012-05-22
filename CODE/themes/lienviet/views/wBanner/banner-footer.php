<marquee scrollamount="3" onmouseover="this.stop();" onmouseout="this.start();">
	<?php foreach ($list_images as $image_id):?>
	<?php $image = Image::model ()->findByPk ( $image_id );?>
		<a href="<?php echo $image->url?>">
		<img src="<?php echo $image->getThumb('Banner','footer')?>" />
		</a>
	<?php endforeach;?>
</marquee>