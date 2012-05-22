   <?php if($this->beginCache('menu-left',array('dependency'=>array(
			'class'=>'system.caching.dependencies.CDbCacheDependency',
			'sql'=>'SELECT MAX(id) FROM tbl_category')))){
   ?>
<div class="box-title"><label><?php echo Language::t('Danh mục sản phẩm','layout');?></label></div>
                <div class="box-content">
                	<div class="menuleft">
                        <ul>
                    <?php 
					foreach ($list_menus as $id=>$menu){
						if($menu['havechild']){
							echo '<li class="'.$menu['class'].'">';
							echo '<a id="'.$id.'" href="'.$menu['url'].'">'.Language::t($menu['name'],'layout').'</a>';
							echo '<ul>';
							}
						else {
							echo '<li class="'.$menu['class'].'">';
							echo '<a id="'.$id.'" href="'.$menu['url'].'">'.Language::t($menu['name'],'layout').'</a>';
							echo '</li>';
						}
						if($menu['close']) {
							for ($i=0;$i<$menu['close'];$i++) {
									echo '</ul>';
									echo '</li>';
							}
						}
					}
					?>
                        </ul>
                    </div><!--menuleft-->
                </div><!--box-content-->
<?php $this->endCache();}?>