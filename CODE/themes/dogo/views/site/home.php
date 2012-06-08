<?php 
$this->pageTitle = 'Trang chủ website '.Setting::s('FRONT_SITE_TITLE','System');
Yii::app()->clientScript->registerMetaTag(Setting::s('META_DESCRIPTION','System'), 'description');
$this->bread_crumbs=array(
	array('url'=>'','title'=>Language::t('Trang chủ','layout')),
);
?>
<?php $this->widget('wSearch');?> 
<?php if($this->beginCache('home-lastest-product',array('dependency'=>array(
			'class'=>'system.caching.dependencies.CDbCacheDependency',
			'sql'=>'SELECT MAX(id) FROM tbl_product')))){
?>
            <div class="big-title"><label><?php echo Language::t('Sản phẩm mới')?></label></div>
            <div class="product-list">
            	<?php foreach ($list_product as $data):?>
          			<div class="box-item">
                	<div class="b-title"><?php echo $data->name?></div>
                	<a class="b-image" href="<?php echo $data->url?>">
                   		<?php echo $data->getThumb_url('introimage','img');?>
                    </a>
                    <div class="b-detail">
                      	<h5><?php echo Language::t('Giá')?>: <?php if($data->num_price!='') echo number_format($data->num_price, 0, ',', '.').' '.$data->unit_price?></h5>
                        <a class="b-viewmore" href="<?php echo $data->url?>">Chi tiết</a>
                  	</div>
                </div><!--box-item-->    
                <?php endforeach;?>   
            </div><!--product-list-->
<?php $this->endCache();}?>    
<?php if($this->beginCache('home-lastest-news',array('dependency'=>array(
			'class'=>'system.caching.dependencies.CDbCacheDependency',
			'sql'=>'SELECT MAX(id) FROM tbl_article')))){
?>
             <div class="big-title"><label><?php echo Language::t('Tin tức mới')?></label></div>
             <div class="product-new">
             <?php foreach ($list_news as $data):?>
             	<div class="grid">
                	<a href="<?php echo $data->url?>"><?php echo $data->getThumb_url('introimage','img');?></a>
                    <a class="viewmore" href="<?php echo $data->url?>"><?php echo Language::t('Chi tiết')?></a>
                	<div class="g-content">
                    	<div class="g-row"><a class="g-title" href="<?php echo $data->url?>"><?php echo $data->title?></a><span><?php echo date("(d/m/Y)"); ?></span></div>
                        <div class="g-row"><?php echo iPhoenixString::createIntrotext($data->introtext,Setting::s('HOME_INTRO_LENGTH','News'));?></div>
                    </div>
                </div><!--grid-->
                <?php endforeach;?>              
             </div><!--product-new-->
<?php $this->endCache();}?>    