   <?php if($this->beginCache('front-end-menu',array('dependency'=>array(
			'class'=>'system.caching.dependencies.CDbCacheDependency',
			'sql'=>'SELECT MAX(id) FROM tbl_category')))){
   ?>
   <ul>
   <?php foreach ($list_menus as $menu):?>
            <li class="<?php if(isset($menu['class'])) echo $menu['class'];?>"><a href="<?php echo $menu['url'];?>"><?php echo Language::t($menu['name'],'layout');?></a></li>
   <?php endforeach;?>
   </ul>
   <?php $this->endCache();}?>
