<?php if($this->beginCache('banner-left',array('dependency'=>array(
			'class'=>'system.caching.dependencies.CDbCacheDependency',
			'sql'=>'SELECT MAX(id) FROM tbl_article')))){
?>
<?php foreach ($list_images as $image_id):?>
<?php $image = Image::model ()->findByPk ( $image_id );?>
<?php if(isset($image)):?>
<a href="<?php echo $image->url?>">
<img src="<?php echo $image->getThumb('Banner','left')?>" />
</a>
<?php endif;?>
<?php endforeach;?>
<?php $this->endCache();}?>