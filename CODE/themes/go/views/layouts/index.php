<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta HTTP-EQUIV="REFRESH" content="5; url=<?php echo Yii::app()->createUrl('site/home')?>">
<meta name='AUTHOR' content='<?php echo Language::t(Setting::s('META_AUTHOR','System'),'layout');?>'>
<meta name='COPYRIGHT' content='<?php echo Language::t(Setting::s('META_COPYRIGHT','System'),'layout');?>'>
<link rel="shortcut icon" href="<?php Yii::app()->theme->baseUrl?>/images/fav.png" type="image/x-icon" />
<title><?php echo $this->pageTitle;?></title>
<!--css default-->
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl?>/css/reset.css">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl?>/css/trailer.css">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl?>/css/print.css" media="print">
<!--[if IE]> <link href="<?php echo Yii::app()->theme->baseUrl?>/css/ie.css" rel="stylesheet" type="text/css"> <![endif]-->
</head>
<body onload="start()">
<?php echo $content;?>
<!--js default-->
<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl?>/js/loading.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl?>/js/jquery-1.7.1.min.js"></script>
</body>
</html>
