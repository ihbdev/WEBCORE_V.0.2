<?php if($this->beginCache('video',array('dependency'=>array(
			'class'=>'system.caching.dependencies.CDbCacheDependency',
			'sql'=>'SELECT MAX(id) FROM tbl_article')))){
?>
<div class="box">
<iframe width="350" height="250" src="http://www.youtube.com/embed/<?php echo $video_id?>" frameborder="0" allowfullscreen></iframe>
</div><!--box-->
<?php $this->endCache();}?>