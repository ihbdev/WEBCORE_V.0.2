<?php 
$this->bread_crumbs=array(
	array('url'=>Yii::app()->createUrl('site/home'),'title'=>Language::t('Trang chủ')),
	array('url'=>'','title'=>Language::t($cat->name)),
)
?>

            <div class="box">
				<div class="box-title"><label>Tin tức</label></div>
                <div class="box-content">
                    <div class="news-list">
		                <?php $this->widget('iPhoenixListView', array(
							'dataProvider'=>$list_page,
							'itemView'=>'_page',
							'template'=>"{items}\n{pager}",
		            		'pager'=>array('class'=>'iPhoenixLinkPager'),
		            		'itemsCssClass'=>'news-list',
		            		'pagerCssClass'=>'pages-inner',
						)); 
						?>
					</div>
				</div><!--box-content-->
			</div><!--box-->