<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name='AUTHOR' content='<?php echo Language::t(Setting::s('META_AUTHOR','System'));?>'>
<meta name='COPYRIGHT' content='<?php echo Language::t(Setting::s('META_COPYRIGHT','System'));?>'>
<meta name="keywords" content= "<?php echo Language::t(Setting::s('META_KEYWORD','System'));?>">
<meta name="desc" content="<?php echo Language::t(Setting::s('META_DESCRIPTION','System'));?>">
<link rel="shortcut icon" href="<?php Yii::app()->theme->baseUrl?>/images/fav.png" type="image/x-icon" />
<!--css default-->
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl?>/css/reset.css">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl?>/css/common.css">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl?>/css/form.css">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl?>/css/style.css">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl?>/css/nivo-slider.css">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl?>/css/jquery.fancybox-1.3.4.css">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl?>/css/print.css" media="print">
<title><?php echo Language::t(Setting::s('FRONT_SITE_TITLE','System'));?></title>
</head>
<body>
	<div class="wrapper">
		<div id="scroll-title">
	    	<marquee scrollamount="3" onmouseover="this.stop();" onmouseout="this.start();">
	            Không để khách hàng thiệt " là phương châm kinh doanh của chúng tôi - Liên Việt Auto cung cấp phụ kiện ô tô chính hãng, đồ chơi, dụng cụ .... cám kết giảm thêm 10% so với người bán rẻ nhất.
	        </marquee>
	    </div><!--scroll-title-->
		<div class="header">
	        <div class="header-inner">
	            <a class="logo" href="index.html"></a>
	            <div class="header-right">
	                <a href="<?php echo Yii::app()->createUrl('cart/cart')?>" class="btn-showcart"><?php echo Language::t('Giỏ hàng');?>:<span class="qty_cart"> <?php if(isset(Yii::app()->session['cart']))echo sizeof(Yii::app()->session['cart']); else {Yii::app()->session['cart']=array();echo '0';}?></span></a>
	                <p>Giỏ hàng có <span class="qty_cart"><?php echo sizeof(Yii::app()->session['cart']);?></span> sản phẩm</p>
	            </div><!--header-right-->
	        </div><!--header-inner-->
	    </div><!--header-->
	    <div class="menu">
         	<?php $this->widget('wMenu',array('group'=>Category::GROUP_USER_MENU,'view'=>'front-end-menu'))?>
	    </div><!--menu-->
	    <div class="after-menu">
	    	<div class="tree-view">
	        	<?php $this->widget('wBreadCrumbs',array('data'=>$this->bread_crumbs));?>
	        </div><!--tree-view-->
         	<?php $this->widget('wQuickSearch')?>
	    </div><!--after-menu-->
	    <div class="bground">
	        <div class="sidebar-left">
	       		<div class="winget">
	                <?php $this->widget('wMenu',array('group'=>Category::GROUP_PRODUCT,'view'=>'menu-left'));?>
	            </div><!--winget-->
	            <div class="winget">
	                <div class="winget-title"><label>Tin tức mới</label></div>
	                <div class="winget-content">
	                	<div class="box-featured">
	                		<?php $this->widget('wNews',array('view'=>'news-left-homepage','limit'=>5))?>
	                    </div><!--box-featured-->
	                </div><!--winget-content-->
	            </div><!--winget-->
	            <div class="winget">
	                <div class="winget-title"><label><?php echo Language::t('Quảng cáo');?></label></div>
	                <div class="winget-content">
	                	<div class="box-ad">
	                    	<?php $this->widget('wBanner',array('code'=>Banner::CODE_LEFT,'view'=>'banner-left'));?>
	                    </div><!--box-ad-->
	                </div><!--winget-content-->
	            </div><!--winget-->
	        </div><!--sidebar-left-->
	        <div class="main">
	        	<div class="slider-wrapper theme-default">
					<?php $this->widget('wBanner',array('code'=>Banner::CODE_HEADLINE,'view'=>'head-line'))?>
	      		</div><!--slider-wrapper-->
	        	<?php echo $content;?>
	            <div class="box-info">
	            	<div class="info-left">
	                	<label class="info-phone">Liên hệ qua điện thoại</label>
	                    <br />
						<p><b>Hotline:</b> Hà nội: <?php echo Setting::s('HOTLINE_HANOI','Contact')?></p>
	              		<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sài Gòn: <?php echo Setting::s('HOTLINE_SAIGON','Contact')?></p>
	              		<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Đà Nẵng: <?php echo Setting::s('HOTLINE_DANANG','Contact')?></p>
						<p><b>Tư vấn loa, âm thanh xe hơi:</b> 0903. 22 33 31</p>
	                    <br />
	                    <img class="info-img" src="<?php echo Yii::app()->theme->baseUrl?>/images/info.jpg">
	                    <br /><br />
	                    <label class="info-support">Hỗ trợ online</label>
						<p>Bán hàng qua mạng : lienvietauto@gmail.com</p>
						<p>Hướng dẫn mua hàng qua mạng</p>
						<p>Bán hàng cả tuần, từ thứ 2 đến CN</p>
						<p>Giờ mở cửa : 8h đến 17h (trừ có hẹn trước)</p>
	                </div><!--info-left-->
	                <div class="info-right">
	                	<p><b>Hà Nội</b></p>
	 					<br />
						<p>371a Trần Khát Chân: 04. 3972 7399</p>
						<p>76 Nguyễn Phong Sắc: 04. 3793 2190</p>
						<p>623 Nguyễn Trãi: 04. 3552 1980</p>
	 					<br />
						<p><b>TPHCM</b></p>
	 					<br />
						<p>265 Trần Bình Trọng - P4 - Q5: 08. 3938 1230</p>
						<p>290 Nguyễn Văn Linh - Q7: 08. 3775 5352</p>
	 					<br />
						<p><b>Đà Nẵng</b></p>
	 					<br />
						<p>92 Triệu Nữ Vương: 05113. 868 665</p>
	                </div><!--info-right-->
	            </div><!--box-info-->
	        </div><!--main-->
	        <div class="sidebar-right">
	        	<div class="winget">
	                <div class="winget-title"><label>Hỗ trợ</label></div>
	                <div class="winget-content">
	                	<div class="box-support">
	                    	<a href="ymsgr:sendim?<?php echo Setting::s('CONTACT_SUPPORT_1','Contact');?>"><img src="http://opi.yahoo.com/online?u=<?php echo Setting::s('CONTACT_SUPPORT_1','Contact');?>&amp;m=g&amp;t=2" border="0"></a>
	                    	<p>76 Nguyễn Phong Sắc - HN</p>
	                        <a href="ymsgr:sendim?<?php echo Setting::s('CONTACT_SUPPORT_2','Contact');?>"><img src="http://opi.yahoo.com/online?u=<?php echo Setting::s('CONTACT_SUPPORT_2','Contact');?>&amp;m=g&amp;t=2" border="0"></a>
	                    	<p>371A Trần Khát Chân - HN</p>
	                        <a href="ymsgr:sendim?<?php echo Setting::s('CONTACT_SUPPORT_3','Contact');?>"><img src="http://opi.yahoo.com/online?u=<?php echo Setting::s('CONTACT_SUPPORT_3','Contact');?>&amp;m=g&amp;t=2" border="0"></a>
	                    	<p>623 Nguyễn Trãi - HN</p>
	                    </div><!--box-support-->
	                </div><!--winget-content-->
	            </div><!--winget-->
	            <div class="winget">
	                <div class="winget-title"><label>Dịch vụ</label></div>
	                <div class="winget-content">
	                	<div class="box-service">
							<?php $this->widget('wBanner',array('code'=>Banner::CODE_BOCGHE,'view'=>'banner-bocghe'));?>
							<?php $this->widget('wBanner',array('code'=>Banner::CODE_DOXE,'view'=>'banner-doxe'));?>
							<?php $this->widget('wBanner',array('code'=>Banner::CODE_SONXE,'view'=>'banner-sonxe'));?>
	                    </div><!--box-service-->
	                </div><!--winget-content-->
	            </div><!--winget-->
	            <div class="winget">
	                <div class="winget-title"><label>Thống kê</label></div>
	                <div class="winget-content">
	                	<div class="box-chart">
	                    	<div class="row"><label class="chart-couting">Lượt truy cập:</label>
	                    		<span>
	                    			<?php
	                    			    //Yii::app()->counter->refresh();
					            		//echo Yii::app()->counter->getTotal();
					            	?>
	                    		</span>
	                    	</div>
	                        <div class="row"><label class="chart-user">User Online:</label>
	                        	<span>
	                        		<?php
            							//echo Yii::app()->counter->getOnline(); 
            						?>
            					</span>
            				</div>	
	                    </div><!--box-chart-->
	                </div><!--winget-content-->
	            </div><!--winget-->
	            <div class="winget">
	                <div class="winget-title"><label><?php echo Language::t('Quảng cáo');?></label></div>
	                <div class="winget-content">
	                	<div class="box-ad">
	                    	<?php $this->widget('wBanner',array('code'=>Banner::CODE_RIGHT,'view'=>'banner-right'));?>
	                    </div><!--box-ad-->
	                </div><!--winget-content-->
	            </div><!--winget-->
	        </div><!--sidebar-right-->  
		</div><!--bground-->
	    <div class="ad-outer">
	    	<div class="ad-scroll">
	        	<?php $this->widget('wBanner',array('code'=>Banner::CODE_FOOTER,'view'=>'banner-footer'));?>
	        </div><!--ad-scroll-->
	    </div><!--ad-outer-->
		<div class="menu-bottom">
			<?php $this->widget('wMenu',array('group'=>Category::GROUP_USER_MENU,'view'=>'front-end-menu'))?>
	    </div><!--menu-bottom-->
	    <div class="footer">
	        <p><?php echo Setting::s('CONTACT_NAME','Contact')?></p>
			<p>Email: <?php echo Setting::s('CONTACT_MAIL','Contact')?> - Địa chỉ: <?php echo Setting::s('CONTACT_ADDRESS','Contact')?></p>
			<p>Điện thoại: <b><?php echo Setting::s('CONTACT_PHONE','Contact')?></b> - Fax: <b><?php echo Setting::s('CONTACT_FAX','Contact')?></b></p> 
	    </div><!--footer-->
	</div><!--wrapper-->
<!--js default-->
<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl?>/js/jquery.nivo.slider.pack.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl?>/js/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl?>/js/jquery.fancybox-1.3.4.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl?>/js/style.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl?>/js/tab.js"></script>
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