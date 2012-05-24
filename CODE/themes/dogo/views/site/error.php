<?php
$this->pageTitle='Trang thông báo lỗi của website '.Setting::s('FRONT_SITE_TITLE','System');
$this->bread_crumbs=array(
	array('url'=>'','title'=>Language::t('Trang thông báo lỗi','layout')),
);
?>

<h2>Lỗi <?php echo $code; ?></h2>

<div class="error">
<?php echo CHtml::encode($message); ?>
</div>