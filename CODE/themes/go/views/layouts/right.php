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
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl?>/css/print.css" media="print">
<!--[if IE]> <link href="<?php echo Yii::app()->theme->baseUrl?>/css/ie.css" rel="stylesheet" type="text/css"> <![endif]-->
</head>
<body>
<div class="wrapper">
	<div class="menu">
	<?php $this->widget('wMenu',array('type'=>Menu::TYPE_USER_MENU,'view'=>'front-end-menu'))?>
    </div><!--menu-->
	<div class="header">
    	<a class="logo" href="index.html"></a>
    	<?php $this->widget('wSearch')?>       
    </div><!--header-->
    <div class="slider-wrapper">
    	<?php $this->widget('wBanner',array('code'=>Banner::CODE_HEADLINE,'view'=>'head-line'))?>        
    </div><!--slider-wrapper-->
    <div class="slider-line"></div>
    <div class="bground">    
       	<?php echo $content;?>           
	</div><!--bground-->
</div><!--wrapper-->
<div class="footer">
    <div class="wrapper">
    	<div class="footer-inner">
            <div class="footer-top">
                <div class="footer-logo"></div><div class="footer-text"></div>
            </div><!--footer-top-->
            <div class="menu-bottom">
               <?php $this->widget('wMenu',array('type'=>Menu::TYPE_USER_MENU,'view'=>'front-end-menu'))?>
            </div><!--menu-bottom-->
            <div class="footer-bottom">
                <p><b><?php echo Language::t(Setting::s('COMPANY','System'),'layout');?></b></p>
				<p><?php echo Language::t('ĐC','layout');?>: <?php echo Language::t(Setting::s('ADDRESS','System'),'layout');?>       <?php echo Language::t('ĐT','layout');?>: <?php echo Language::t(Setting::s('MOBILE','System'),'layout');?>      <?php echo Language::t('Fax','layout');?>: <?php echo Language::t(Setting::s('FAX','System'),'layout');?>       <?php echo Language::t('Mail','layout');?>: <?php echo Language::t(Setting::s('EMAIL','System'),'layout');?>       <?php echo Language::t('Web','layout');?>: <?php echo Language::t(Setting::s('WEBSITE','System'),'layout');?>        <?php echo Language::t('Hotline','layout');?>: <?php echo Language::t(Setting::s('HOTLINE','System'),'layout');?></p>
                <p style="padding-top:8px;"><?php echo Language::t(Setting::s('COPYRIGHT','System'),'layout');?></p>
            </div><!--footer-bottom-->
        </div><!--footer-inner-->
    </div><!--wrapper-->
</div><!--footer-->
<!--js default-->
<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl?>/js/style.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl?>/js/tab.js"></script>
<script type="text/javascript" src="http://apis.google.com/js/plusone.js"></script>
<script type="text/javascript">
$(document).ready(function(){
<?php if(Yii::app()->controller->id != "site" || Yii::app()->controller->action->id != "index"):?>
$(window).scrollTop($(".bground").offset().top); 
<?php endif;?>
});
</script>
</body>
</html>
