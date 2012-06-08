<?php 
$this->type_menu_left = Category::TYPE_PRODUCT;
$this->pageTitle = 'Kết quả tìm kiếm';
Yii::app()->clientScript->registerMetaTag(Setting::s('META_DESCRIPTION','System'), 'description');
Yii::app()->clientScript->registerMetaTag(Setting::s('META_KEYWORD','System'), 'keywords');
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
						'dataProvider'=>$result,
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