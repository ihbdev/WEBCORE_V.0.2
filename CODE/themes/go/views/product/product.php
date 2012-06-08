<?php 
$this->pageTitle = 'Sản phẩm '.$product->name;
$this->type_menu_left = Category::TYPE_PRODUCT;
if(isset($cat))
	$this->current_catid=$cat->id;
Yii::app()->clientScript->registerMetaTag($product->metadesc, 'description');
Yii::app()->clientScript->registerMetaTag(Keyword::viewListKeyword($product->keyword), 'keywords');
?>
  <div class="tab-outer">
                <div class="tab-title">
                	<?php 
                    $i=1;
                   	foreach ($product->config_other_tag as $index=>$label):
                   	?>
                    <a class="<?php if($i==sizeof($product->config_other_tag)) echo 'last';?>" href="#tab<?php echo $i?>"><?php echo $label?></a>
                    <?php $i=$i+1;?>
                    <?php endforeach;?>

                </div><!-- tab-title -->
                <div class="tab-container">
                    <div id="tab1" class="tab-content">
                    	<div class="product-thumbnail"><div class="thumbnail"><?php echo $product->getThumb_url('introimage')?></div></div>
                      	<?php echo $product->description?>
                        <p align="center"><?php echo $product->getThumb_url('detail_introimage')?></p>
                    </div><!-- content-1 -->
                    <div id="tab2" class="tab-content">
                        <?php echo $product->wood?>
                    </div><!-- content-2 -->
                    <div id="tab3" class="tab-content">
                        <?php echo $product->paint?>
                    </div><!-- content-3 -->
                    <div id="tab4" class="tab-content">
                        <?php echo $product->surface?>
                    </div><!-- content-4 -->
                </div><!-- tab-container -->
            </div><!-- tab-outer -->