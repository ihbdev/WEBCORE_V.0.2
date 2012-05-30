<?php 
$cs = Yii::app()->getClientScript();
$cs->registerCssFile(Yii::app()->request->getBaseUrl(true).'/css/admin/sprite.css');
?>
	<!--begin inside content-->
	<div class="folder top">
		<!--begin title-->
		<div class="folder-header">
			<h1>
			<?php 
			switch ($type){
				case Role::TYPE_OPERATION: echo "Danh mục chức năng";
				break;
				case Role::TYPE_TASK: echo 'Danh mục tác vụ';
				break;
				case Role::TYPE_ROLE: echo "Danh mục quyền";
				break;
				default: echo 'Danh mục';
				break;
				
			}
			?>
			</h1>
			<div class="header-menu">
				<ul>
					<li><a class="header-menu-active new-icon" href=""><span>
			<?php 
			switch ($type){
				case Role::TYPE_OPERATION: echo "Danh mục chức năng";
				break;
				case Role::TYPE_TASK: echo 'Danh mục tác vụ';
				break;
				case Role::TYPE_ROLE: echo "Danh mục quyền";
				break;
				default: echo 'Danh mục';
				break;
				
			}
			?>
					</span></a></li>					
				</ul>
			</div>
		</div>
		<!--end title-->
		<div class="folder-content form">
			<!--begin left content-->
			<?php 	
			switch ($type){
				case Role::TYPE_OPERATION: 
				$tree='_tree_operation';	
				$form='_form_operation';
				break;
				case Role::TYPE_TASK: 
				$tree='_tree_task';	
				$form='_form_task';
				break;
				case Role::TYPE_ROLE: 
				$tree='_tree_role';	
				$form='_form_role';
				break;
				default: echo 'Danh mục';
				break;
				
			}
			echo $this->renderPartial($form, array('model'=>$model,'type'=>$type,'action'=>$action)); 
			?>
			<!--end left content-->
			<!--begin right content-->
			<?php			
			echo $this->renderPartial($tree, array('list'=>$model->list_nodes)); 			
			?>
			<!--end right content-->
			<div class="clear"></div>
		</div>
	</div>
	<!--end inside content-->
<div type="hidden" value="" id="popup_value"></div>
<?php 
$lang='vi';
if(isset($_GET['lang'])){
	$lang=$_GET['lang'];
}
$cs = Yii::app()->getClientScript(); 
// Script delete
$cs->registerScript(
  'js-delete-role',
  "jQuery(function($) { $('body').on('click','.i16-trashgray',	
  		function(){
  			$('#popup_value').val(this.id);
  			jConfirm(
  				\"Bạn muốn xóa danh mục này?\",
  				\"Xác nhận xóa danh mục\",
  				function(r){
  					if(r){
  					jQuery.ajax({
  						'data':{id : $(\"#popup_value\").val(), type: ".$model->type.", current_id: $(\"#current_id\").val()},
  						'dataType':'json',
  						'success':function(data){
  							if(data.status == true){
								$(\".folder-content\").html(data.content);
								$(\".folder-content\").append('<div class=\"clear\"></div>');
							}
							else {
								jAlert(data.content);
							}
        				},
        				'type':'GET',
        				'url':'".$this->createUrl('role/delete')."',
        				'cache':false});
        			}
        		}
        	);
        	return false;	
        	});
        })",
  CClientScript::POS_END
);

// Script load form update 
$cs->registerScript(
  'js-update-role',
  "jQuery(
  	function($)
	{ 
		$('body').on(
  			'click',
  			'.i16-statustext',	
  			function(){
  				jQuery.ajax({
  					'data':{id : this.id, type: ".$model->type."},
  					'success':function(data){
						$(\".folder-content\").html(data);
						$(\".folder-content\").append('<div class=\"clear\"></div>');
					},
					'type':'GET',
					'url':'".$this->createUrl('role/update')."',
					'cache':false
				});
				return false;
			}
		);
	}
	);",
  CClientScript::POS_END
);
// Script load form create 
$cs->registerScript(
  'js-create-role',
  "jQuery(
  	function($) 
  	{ 
  		$('body').on(
  			'click',
  			'#create-role',	
  			function(){
  				jQuery.ajax({
  					'success':function(data){
						$(\".folder-content\").html(data);
						$(\".folder-content\").append('<div class=\"clear\"></div>');
        			},
        			'type':'GET',
        			'url':'".$this->createUrl('role/create')."',
        			'cache':false,
        			'data':{type:".$model->type.",lang: '".$lang."'}
        		});
        		return false;
        	}
        );
     }
    );",
  CClientScript::POS_END
);
// Script update & create role to database
$cs->registerScript(
  'js-write-role',
  "jQuery(
  	function($) { 
  		$('body').on(
  			'click',
  			'#write-role',	
  			function(){
  				jQuery.ajax({
  					'success':function(data){
						$(\".folder-content\").html(data);
						$(\".folder-content\").append('<div class=\"clear\"></div>');
        			},
        			'type':'POST',
        			'url':'".$this->createUrl('role/write',array('type'=>$model->type,'lang'=>$lang))."',
        			'cache':false,
        			'data':jQuery(this).parents(\"form\").serialize()
        		});
        		return false;
        	}
        );
      }
   );",
  CClientScript::POS_END
);
?>