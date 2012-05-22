<?php if($this->beginCache('banner-right',array('dependency'=>array(
			'class'=>'system.caching.dependencies.CDbCacheDependency',
			'sql'=>'SELECT MAX(id) FROM tbl_article')))){
?>
<?php foreach ($list_images as $image_id):?>
<?php $image = Image::model ()->findByPk ( $image_id );?>
<a href="<?php echo $image->url?>">
<img src="<?php echo $image->getThumb('Banner','right')?>" />
</a>
<?php endforeach;?>
<?php $this->endCache();}?>
