<?php if($this->beginCache('head-line',array('dependency'=>array(
			'class'=>'system.caching.dependencies.CDbCacheDependency',
			'sql'=>'SELECT MAX(id) FROM tbl_article')))){
?>
		<div id="slider">	
			<?php $index=0;?>
  			<?php foreach ($list_images as $id):?>	
  				<?php 
  				$image = Image::model ()->findByPk ( $id );
  				?>	
  				<?php if(isset($image)):?>			
             	<img src="<?php echo $image->getThumb('Banner','headline')?>" class="<?php if($index==0) echo "first active"?>"/>           
           		<?php endif;?>
           		<?php $index++;?>
  			<?php endforeach;?>				
        </div>
        <div class="slider-shadow"></div>
        <div class="slider-blur"></div>
<?php $this->endCache();}?>