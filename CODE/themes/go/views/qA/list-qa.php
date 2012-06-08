<?php 
$this->type_menu_left = Category::TYPE_QA;
if(isset($cat)){
	$this->current_catid=$cat->id;
	$this->pageTitle = 'Các câu hỏi trong nhóm '.$cat->name;
		Yii::app()->clientScript->registerMetaTag($cat->metadesc, 'description');	
		Yii::app()->clientScript->registerMetaTag(Keyword::viewListKeyword($qa->keyword), 'keywords');
}
else {
	$this->pageTitle = 'Tất cả các câu hỏi';
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
               	 	<div class="faq-list">
                    	<ul>
                		{items}
                		</ul>
                	</div>
                </div><!--box-content-->
			</div><!--box-->';   
?>            
 <?php              
                  $this->widget('iPhoenixListView', 
                   	array(
            			'id'=>'list-qa',
						'dataProvider'=>$list_qa,
						'itemView'=>'_qa',
						'template'=>$template,	
            			'itemsCssClass'=>'',
                   		'pagerCssClass'=>'page-button',
                   		'pager'=>array(
                   			'class'=>'iPhoenixLinkPager',
   							'prevPageLabel'=>'',
   							'nextPageLabel'=>'',        
                   			'maxButtonCount'=>0
                   		),
                   		'summaryText'=>'Trang {page}/{pages}'

					)); ?>    