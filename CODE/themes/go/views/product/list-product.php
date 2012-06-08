<?php 
$this->type_menu_left = Category::TYPE_PRODUCT;
if(isset($cat)){
	$this->current_catid=$cat->id;
	$this->pageTitle = 'Các sản phẩm trong nhóm '.$cat->name;
	Yii::app()->clientScript->registerMetaTag($cat->metadesc, 'description');	
	Yii::app()->clientScript->registerMetaTag(Keyword::viewListKeyword($cat->keyword), 'keywords');
}
else {
	$this->pageTitle = 'Tất cả sản phẩm';
	Yii::app()->clientScript->registerMetaTag(Setting::s('META_DESCRIPTION','System'), 'description');	
	Yii::app()->clientScript->registerMetaTag(Setting::s('META_KEYWORD','System'), 'keywords');
}
?>
<?php 
$template='<div class="box">
                <div class="box-title">
                	<label>'.$this->pageTitle.'</label>
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