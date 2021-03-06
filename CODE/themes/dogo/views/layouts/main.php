<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name='AUTHOR' content='<?php echo Language::t(Setting::s('META_AUTHOR','System'),'layout');?>'>
<meta name='COPYRIGHT' content='<?php echo Language::t(Setting::s('META_COPYRIGHT','System'),'layout');?>'>
<link rel="shortcut icon" href="<?php Yii::app()->theme->baseUrl?>/images/fav.png" type="image/x-icon" />
<title><?php echo $this->pageTitle;?></title>
<!--css default-->
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl?>/css/reset.css">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl?>/css/common.css">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl?>/css/form.css">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl?>/css/style.css">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl?>/css/nivo-slider.css">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl?>/css/jquery.fancybox-1.3.4.css">
</head>
<body>
<div class="webtitle">
	<div class="wrapper">
    	<span class="email-label"><?php echo Language::t('Liên hệ qua Email','layout');?>:</span>
        <a class="email-link"><?php echo Setting::s('EMAIL_CONTACT','System');?></a>
        <div class="box-language">
        	<?php echo Language::t('Ngôn ngữ','layout');?>:
            <a href="<?php echo Yii::app()->createUrl('site/language',array('language'=>'vi'))?>" class="active"><img src="<?php echo Yii::app()->theme->baseUrl?>/images/vie.png" width="21" height="11" alt="vie" /></a>
            <a href="<?php echo Yii::app()->createUrl('site/language',array('language'=>'en'))?>"><img src="<?php echo Yii::app()->theme->baseUrl?>/images/eng.png" width="21" height="11" alt="eng" /></a> 
        </div><!--box-language-->
    </div><!--wrapper-->
</div>
<div class="header">
	<div class="wrapper">
    	<a class="logo"></a>
        <div class="fright" style="width:200px;">
        	<div class="hotline"><?php echo Language::t('Hotline','layout');?>: <span><?php echo Setting::s('HOTLINE','System');?></span></div>
        	<a href="<?php echo Yii::app()->createUrl('cart/cart')?>" class="btn-showcart"><?php echo Language::t('Giỏ hàng','layout');?>:<span id="qty_cart"> <?php if(isset(Yii::app()->session['cart']))echo sizeof(Yii::app()->session['cart']); else {Yii::app()->session['cart']=array();echo '0';}?></span></a>
        </div>
    </div><!--wrapper-->	
</div><!--header-->
<div class="menu">
	<div class="wrapper">
         	<?php $this->widget('wMenu',array('type'=>Menu::TYPE_USER_MENU,'view'=>'front-end-menu'))?>
         	<?php $this->widget('wQuickSearch')?>
    </div><!--wrapper-->
</div><!--menu-->
<div class="slider-outer">
    <div class="wrapper">
    	<div class="slider-wrapper theme-default">				
            <?php $this->widget('wBanner',array('code'=>Banner::CODE_HEADLINE,'view'=>'head-line'))?>
      	</div><!--slider-wrapper-->
      	<div class="slider-right">
       			<?php $this->widget('wVideo',array('view'=>'video'));?> 
            <div class="box">
            	<div class="box-title"><label><?php echo Language::t('Hướng dẫn','layout');?></label></div>
                <div class="box-content">
                	<div class="box-intro">
                        <ul>
                            <li><a href="<?php echo Yii::app()->createUrl('staticPage/view',array('cat_alias'=>News::ALIAS_GUIDE_CATEGORY))?>"><?php echo Language::t('Hướng dẫn mua hàng','layout');?></a></li>
                            <li><a href="<?php echo Yii::app()->createUrl('staticPage/view',array('cat_alias'=>News::ALIAS_GUIDE_CATEGORY))?>"><?php echo Language::t('Phương thức thanh toán','layout');?></a></li>
                        </ul>
                    </div><!--box-intro-->
                </div><!--box-content-->
            </div><!--box-->
        </div><!--slider-right-->
    </div><!--wrapper-->
</div><!--slider-outer-->
<div class="wrapper">
    <div class="tree-outer">
    	<div class="tree-view">
    		<?php 
    			$this->widget('wBreadCrumbs',array('data'=>$this->bread_crumbs));
    		?>        	
        </div><!--tree-view-->
        <span class="update-time"><?php echo date("d/m/Y"); ?></span>
    </div><!--tree-outer-->
    <div class="bground">
    	<div class="sidebar">
        	<div class="box">
            	<?php $this->widget('wCategory',array('type'=>Category::TYPE_PRODUCT,'view'=>'menu-left'));?> 
            </div><!--box-->
            <div class="box">
            	<?php $this->widget('wProduct',array('view'=>'remark','special'=>Product::SPECIAL_REMARK,'limit'=>Setting::s('SIZE_REMARK_PRODUCT','Product')));?> 
            </div><!--box-->
            <div class="box-ad">
            	<?php $this->widget('wBanner',array('code'=>Banner::CODE_LEFT,'view'=>'banner-left'));?> 
            </div><!--box-ad-->
        </div><!--sidebar-->
        <div class="main">
        	<?php echo $content;?>
        </div><!--main-->
    </div><!--bground-->
    <div class="clearfix"></div>
</div><!--wrapper-->
<div class="menu-bottom">
	<div class="wrapper">
    <?php $this->widget('wMenu',array('type'=>Menu::TYPE_USER_MENU,'view'=>'front-end-menu'))?>
	</div><!--wrapper-->
</div><!--menu-bottom-->
<div class="footer">
	<div class="footer-line"></div>
	<div class="wrapper">
    	<div class="char-outer">
            <h5>Thống kê</h5>
            	<div class="row"><label><?php echo Language::t('Tổng truy nhập','layout');?>:</label>
                <span>
               	<?php
	                Yii::app()->counter->refresh();
					echo Yii::app()->counter->getTotal();
				?>
				</span>
				</div>
                <div class="row"><label><?php echo Language::t('Đang online','layout');?>:</label>
                <span>
               	<?php
					echo Yii::app()->counter->getOnline();
				?>
				</span>
				</div>				
        </div><!--char-outer-->
         	
        <div class="footer-right">
        	<h5><?php echo Language::t(Setting::s('COMPANY','System'),'layout');?></h5>
			<p><?php echo Language::t('Showroom','layout');?>: <?php echo Language::t(Setting::s('ADDRESS_SHOWROOM','System'),'layout');?></p>
			<p><?php echo Language::t('Tel/Fax','layout');?>: <?php echo Language::t(Setting::s('TEL/FAX','System'),'layout');?></p>
			<p><?php echo Language::t('Mobile','layout');?>: <?php echo Language::t(Setting::s('MOBILE','System'),'layout');?></p>
			<p><?php echo Language::t('Email','layout');?>: <?php echo Language::t(Setting::s('EMAIL','System'),'layout');?></p>
        </div><!--footer-right-->
        <div class="designer"><?php echo Language::t(Setting::s('DESIGN_BY','System'),'layout');?></div>  
    </div><!--wrapper-->
</div><!--footer-->
<!--js default-->
<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl?>/js/jquery.nivo.slider.pack.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl?>/js/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl?>/js/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl?>/js/tab.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl?>/js/main.slider.js"></script>
<script type="text/javascript" src="http://apis.google.com/js/plusone.js"></script>
<script type="text/javascript">
$(document).ready(function(){
<?php if(Yii::app()->controller->id != "site" || Yii::app()->controller->action->id != "index"):?>
$(window).scrollTop($(".main").offset().top); 
<?php endif;?>
});
</script>
</body>
</html>