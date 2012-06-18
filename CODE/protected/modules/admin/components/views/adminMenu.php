<div id="menuBar">
				<ul id="ja-cssmenu">
					<?php 
					foreach ($list as $id=>$item){
						$menu=Menu::model()->findByPk($id);
						$class='';
						if(isset($item['last-item']) && $item['last-item']) $class .= ' last-item';
						if(isset($item['first-item']) && $item['first-item']) $class .= ' first-item';
						if(isset($item['first']) && $item['first']) $class .= ' first';
						if(isset($item['last']) && $item['last']) $class .= ' last';
						if(isset($item['havechild']) && $item['havechild'] && $item['level'] > 1) $class .=' x';
						if(isset($item['active']) && $item['active']) $class .= ' active';
						if(isset($item['havechild']) && $item['havechild'] && $item['level'] == 1){
							echo '<li class="havechild">';
							echo '<a id="'.$id.'" class="'.$class.'" href="'.$menu->url.'">'.$menu->name.'</a>';
							echo '<ul>';
							}
						elseif (isset($item['havechild']) && $item['havechild'] && $item['level'] >1){
							echo '<li class="x">';
							echo '<a id="'.$id.'" class="'.$class.'" href="'.$menu->url.'">'.$menu->name.'</a>';
							echo '<ul>';
						}
						else {
							echo '<li>';
							echo '<a id="'.$id.'" class="'.$class.'" href="'.$menu->url.'">'.$menu->name.'</a>';
							echo '</li>';
						}
						if(isset($item['level_close']) && $item['level_close']) {
							for ($i=0;$i<$item['level_close'];$i++) {
									echo '</ul>';
									echo '</li>';
							}
						}
					}
					?>
				</ul>
			</div>