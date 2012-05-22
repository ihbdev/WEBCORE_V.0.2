<?php if($this->beginCache('video',array('dependency'=>array(
			'class'=>'system.caching.dependencies.CDbCacheDependency',
			'sql'=>'SELECT MAX(id) FROM tbl_article')))){
?>
<div class="box-title"><label><?php
echo Language::t ( 'Video','layout' );
?>:</label></div>
<div class="box-content">
<div class="box-video">
<iframe width="190" height="160" src="http://www.youtube.com/embed/<?php echo $video_id?>" frameborder="0" allowfullscreen></iframe>
</div>
<!--box-video--></div>
<!--box-content-->
<?php $this->endCache();}?>