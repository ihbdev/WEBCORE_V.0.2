<?php 
$this->pageTitle = 'Trang chủ website '.Setting::s('FRONT_SITE_TITLE','System');
Yii::app()->clientScript->registerMetaTag(Setting::s('META_DESCRIPTION','System'), 'description');
$this->bread_crumbs=array(
	array('url'=>'','title'=>Language::t('Trang chủ','layout')),
);
?>
<?php if($this->beginCache('home-lastest-product',array('dependency'=>array(
			'class'=>'system.caching.dependencies.CDbCacheDependency',
			'sql'=>'SELECT MAX(id) FROM tbl_product')))){
?>
<?php 
$template='<div class="box">
                <div class="box-title">
                	<label>'.Language::t('Sản phẩm').'</label>
                    <div class="page-button">
                    	<span>{summary}</span>
                       	{pager}
                    </div>
                </div>
                <div class="box-content">
                {items}
                </div><!--box-content-->
			</div><!--box-->'
?>          
                   <?php              
                  $this->widget('iPhoenixListView', 
                   	array(
            			'id'=>'list-product',
						'dataProvider'=>$list_product,
						'itemView'=>'_product',
						'template'=>$template,	
            			'itemsCssClass'=>'product-list',
                   		'pagerCssClass'=>'page-button',
                   		'pager'=>array(
                   			'class'=>'iPhoenixLinkPager',
   							'prevPageLabel'=>'',
   							'nextPageLabel'=>'',        
                   			'maxButtonCount'=>0
                   		),
                   		'summaryText'=>'Trang {page}/{pages}'

					)); ?>    
<?php $this->endCache();}?>    