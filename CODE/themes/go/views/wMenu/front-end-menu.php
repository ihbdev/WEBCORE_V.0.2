   <?php if($this->beginCache('front-end-menu',array('dependency'=>array(
			'class'=>'system.caching.dependencies.CDbCacheDependency',
			'sql'=>'SELECT MAX(id) FROM tbl_category')))){
   ?>
    <ul>
   <?php foreach ($list_menus as $id=>$item):?>
   			<?php $menu=Menu::model()->findByPk($id);?>
            <li><a href="<?php echo $menu->url;?>"><?php echo Language::t($menu->name,'layout');?></a></li>
   <?php endforeach;?>
   </ul>
   <?php $this->endCache();}?>
