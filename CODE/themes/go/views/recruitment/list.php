<?php 
$this->pageTitle = 'Trang danh sách tuyển dụng của '.Setting::s('FRONT_SITE_TITLE','System');
Yii::app()->clientScript->registerMetaTag(Setting::s('META_DESCRIPTION','System'), 'description');
?>
    	<div class="bg-left">
        	<div class="winget">
                <div class="winget-title"><label><?php echo Language::t('Tuyển dụng nhân sự'); ?></label></div>
                <div class="winget-content">
                	<div class="main-content">  
                    	<p><b><?php echo Language::t('Vị trí tuyển dụng'); ?></b></p>
                        <div class="employee-list">
                        	<ul>
                        	<?php  foreach ($list_left as $item):?>                      
                            	<li><a href="<?php echo $item->url?>"><?php echo $item->title?></a></li>
                            <?php endforeach;?>
                            </ul>
                        </div><!--employee-list-->
                    </div><!--main-content-->
                    <div class="employee-download" style="visibility:hidden;">
                    	Download hồ sơ ứng tuyển <a href="#">tại đây</a>
                        <a class="button" href="#">Gửi hồ sơ</a>
                    </div><!--employee-download-->
                    <img class="ad-img1" src="<?php echo Yii::app()->theme->baseUrl?>/images/banner1.png" />
                </div><!--winget-content-->
            </div><!--winget-->
        </div><!--bg-left-->
        <div class="bg-right">
       		<div class="winget">
                <div class="winget-title"><label><?php echo Language::t('Đăng ký làm đại lý'); ?></label></div>
                <div class="winget-content">
                    <div class="main-content">  
                    <?php echo $right->fulltext?>
                    </div><!--main-content-->
                    <div class="employee-download">
                    	<?php echo Language::t('Download hồ sơ ứng tuyển'); ?> <?php echo CHtml::link(Language::t('tại đây'),array('/site/download','path'=>$right->attach),array('target'=>'_blank'));	?>
                        <a class="button" href="<?php echo $right->url?>"><?php echo Language::t('Gửi hồ sơ'); ?></a>
                    </div><!--employee-download-->
                    <img class="ad-img2" src="<?php echo Yii::app()->theme->baseUrl?>/images/banner2.png" />
                </div><!--winget-content-->
            </div><!--winget-->
        </div><!--bg-right-->