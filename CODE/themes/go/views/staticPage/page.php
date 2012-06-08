<?php 
$this->pageTitle = 'Trang '.$page->title;
Yii::app()->clientScript->registerMetaTag($page->metadesc, 'description');
Yii::app()->clientScript->registerMetaTag(Keyword::viewListKeyword($page->keyword), 'keywords');
?>
<div class="main-left">
        	<div class="winget">
                <div class="winget-title">
                    <label>Giới thiệu</label>
                    <div class="ver-line"></div>
                    <div class="small-name"><?php echo $page->title?></div>
                </div>
                <div class="winget-content">
                	<div class="main-content">
                    	<?php echo $page->fulltext?>
                    </div><!--main-content-->
                </div><!--winget-content-->
            </div><!--winget-->
        </div><!--main-left-->
        <div class="sidebar-right">
        	<div class="box-video">
        	<?php $this->widget('wVideo',array('view'=>'video'));?> 
        	</div>
       		<div class="winget">
               <?php $this->widget('wCategory',array('type'=>Category::TYPE_PRODUCT,'view'=>'menu-left'));?>
            </div><!--winget-->
            <div class="winget">
                <?php $this->widget('wSupport',array('view'=>'support','limit'=>Setting::s('SIZE_SUPPORT','Support')));?>
                </div><!--winget-content-->
            </div><!--winget-->
        </div><!--sidebar-right-->