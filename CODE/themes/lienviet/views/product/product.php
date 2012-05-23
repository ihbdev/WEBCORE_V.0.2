<?php 
$this->bread_crumbs=array(
	array('url'=>Yii::app()->createUrl('site/home'),'title'=>Language::t('Trang chủ')),
	array('url'=>Yii::app()->createUrl('product/index',array('cat_alias'=>$cat->alias)),'title'=>Language::t($cat->name)),
	array('url'=>'','title'=>Language::t($product->name)),
)
?>
<?php  
  $cs = Yii::app()->getClientScript();
  $cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/tab.js', CClientScript::POS_END);
?>

            <div class="box">
                <div class="box-title"><label><?php echo $cat->name;?></label></div>
                <div class="box-content">
                	<div class="product-detail">  
                        <div class="product-maindetail">
                        	<span class="thumbnail">
							<?php 
								echo $product->getThumb_url('detail_introimage');
							?>
							</span>
                            <div class="product-title"><?php echo $product->name;?></div>
                            <div class="row">
                            	<label>Giá:</label><span class="product-cost"><?php if($product->num_price!=0) echo number_format($product->num_price, 0, ',', '.').' '.$product->unit_price; else echo "CALL";?></span>
                            </div>
                            <div class="row">
                            	<label>Hãng:</label><span><?php echo $product->manufacturer->name;?></span>
                            </div>
                            <div class="row">
                            	<label>Lượt xem:</label><span><?php echo $product->visits;?></span>
                            </div>
                            <div class="row">
                            	<?php echo CHtml::ajaxLink(Language::t('Đặt hàng'),Yii::app()->createUrl('cart/addCart',array('id'=>$product->id)), array('success'=>'function(data){$(".qty_cart").html(" "+data);jAlert("'.Language::t('Đã thêm sản phẩm vào giỏ hàng').'");}'), array('id'=>'add-cart','class'=>'btn-addcart'));?>
                            </div>
                            <div class="clearfix"></div>
                            <div class="tab-outer">
                                <div class="tab-title">
                                    <a href="#tab1" class="active">Thông tin chung</a>
                                    <a href="#tab2">Sử dụng bảo dưỡng</a>
                                </div><!-- tab-title -->
                                <div class="tab-container">
                                    <div id="tab1" class="tab-content">
                                        <?php echo $product->description?>
                                    </div><!-- content-1 -->
                                    <div id="tab2" class="tab-content">
                                    <?php
										if($product->parameter != '') 
                        					echo $product->parameter;
                        				else
                        					echo Language::t('Chưa có thông tin cập nhật!');
                        			?>
                                    </div><!-- content-2 -->
                                </div><!-- tab-container -->
                            </div><!-- tab-outer -->
                        </div><!--product-maindetail-->	
                    </div><!--product-detail-->
                </div><!--box-content-->
            </div><!--box-->
            <div class="box">
                <div class="box-title"><label><?php echo Language::t('Sản phẩm tương tự')?></label></div>
                <div class="box-content">
                    <div class="product-list">
						<?php
							$list_similar=$product->list_similar;
							if ($list_similar==NULL) echo '<h4 style="margin:10px"> Không có sản phẩm tương tự <h4>';
						?>
	            		<?php foreach ($list_similar as $similar_product):?>
                    	<div class="item">
                        	<div class="item-top"></div>
                        	<h3><?php echo $similar_product->name;?></h3>
                            <a class="item-img" href="<?php echo $similar_product->url;?>"><?php echo $similar_product->getThumb_url('introimage')?></a>
                            <div class="item-view">
                            	<h4>Giá <?php if($product->num_price!=0) echo number_format($similar_product->num_price, 0, ',', '.').' '.$similar_product->unit_price; else echo "CALL";?></h4>
                                <a class="view-more" href="<?php echo $similar_product->url;?>">Chi tiết</a>
                            </div>
                        </div><!--item-->
						<?php endforeach;?>
                    </div><!--product-list-->
                </div><!--box-content-->
            </div><!--box-->