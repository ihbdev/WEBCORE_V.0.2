   <?php if($this->beginCache('menu-left',array('dependency'=>array(
			'class'=>'system.caching.dependencies.CDbCacheDependency',
			'sql'=>'SELECT MAX(id) FROM tbl_category')))){
   ?>
    <div class="winget-title"><label>
    <?php 
    switch ($type){
    	case Category::TYPE_PRODUCT:
    		 echo Language::t('Sản phẩm Promat','layout');
    		 break;
    	case Category::TYPE_NEWS:
    		 echo Language::t('Tin tức và sự kiện','layout');
    		 break;
    	case Category::TYPE_APP:
    		 echo Language::t('Ứng dụng','layout');
    		 break;
    	case Category::TYPE_QA:
    		 echo Language::t('Danh mục câu hỏi','layout');
    		 break;
    }
    ?>
    </label></div>
                <div class="winget-content">
                	<div class="menu-left">                		
                        <ul>                
                    <?php 
					foreach ($list_menus as $id=>$item){
						$menu=Category::model()->findByPk($id);
						$class='';
						if(isset($item['active']) && $item['active']) $class = 'active';
						if(isset($item['havechild']) && $item['havechild'] && $item['level']==1){
							echo '<li class="'.$class.'">';
							echo '<a class="firstlink" id="'.$id.'" href="'.$menu->url.'">'.Language::t($menu->name,'layout').'</a>';
							echo '<ul>';
							}
						else {
							echo '<li class="'.$class.'">';
							echo '<a id="'.$id.'" href="'.$menu->url.'">'.Language::t($menu->name,'layout').'</a>';
							echo '</li>';
						}
						if(isset($item['level_close'])&& $item['level_close']) {
							for ($i=0;$i<$item['level_close'];$i++) {
									echo '</ul>';
									echo '</li>';
							}
						}
					}
					?>
                        </ul>
                    </div><!--menu-left-->
                </div><!--winget-content-->
<?php $this->endCache();}?>