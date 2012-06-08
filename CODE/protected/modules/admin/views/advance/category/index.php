<?php 
$cs = Yii::app()->getClientScript();
$cs->registerCssFile(Yii::app()->request->getBaseUrl(true).'/css/admin/sprite.css');
?>
	<!--begin inside content-->
	<div class="folder top">
		<!--begin title-->
		<div class="folder-header">
			<h1><?php echo $model->config_type[$type]['label']?></h1>
			<div class="header-menu">
				<ul>
					<li><a class="header-menu-active new-icon" href=""><span><?php echo $model->config_type[$type]['label']?></span></a></li>					
				</ul>
			</div>
		</div>
		<!--end title-->
		<div class="folder-content form">
			<!--begin left content-->
			<?php 
			$form=$model->config_type[$type]['form'];
			echo $this->renderPartial($form, array('model'=>$model,'action'=>$action)); 
			?>
			<!--end left content-->
			<!--begin right content-->
			<?php			
			echo $this->renderPartial('_tree', array('list_nodes'=>$model->list_nodes)); 			
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
  'js-delete-category',
  "jQuery(function($) { $('body').on('click','.i16-trashgray',	
  		function(){
  			$('#popup_value').val(this.id);
  			jConfirm(
  				\"Bạn muốn xóa danh mục này?\",
  				\"Xác nhận xóa danh mục\",
  				function(r){
  					if(r){
  					jQuery.ajax({
  						'data':{id : $(\"#popup_value\").val(), current_id: $(\"#current_id\").val()},
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
        				'url':'".$this->createUrl('category/delete')."',
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
  'js-update-category',
  "jQuery(
  	function($)
	{ 
		$('body').on(
  			'click',
  			'.i16-statustext',	
  			function(){
  				jQuery.ajax({
  					'data':{id : this.id},
  					'success':function(data){
						$(\".folder-content\").html(data);
						$(\".folder-content\").append('<div class=\"clear\"></div>');
					},
					'type':'GET',
					'url':'".$this->createUrl('category/update')."',
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
  'js-create-category',
  "jQuery(
  	function($) 
  	{ 
  		$('body').on(
  			'click',
  			'#create-category',	
  			function(){
  				jQuery.ajax({
  					'success':function(data){
						$(\".folder-content\").html(data);
						$(\".folder-content\").append('<div class=\"clear\"></div>');
        			},
        			'type':'GET',
        			'url':'".$this->createUrl('category/create')."',
        			'cache':false,
        			'data':{type:".$model->type."}
        		});
        		return false;
        	}
        );
     }
    );",
  CClientScript::POS_END
);
// Script update & create category to database
$cs->registerScript(
  'js-write-category',
  "jQuery(
  	function($) { 
  		$('body').on(
  			'click',
  			'#write-category',	
  			function(){
  				jQuery.ajax({
  					'success':function(data){
						$(\".folder-content\").html(data);
						$(\".folder-content\").append('<div class=\"clear\"></div>');
        			},
        			'type':'POST',
        			'url':'".$this->createUrl('category/write',array('type'=>$model->type))."',
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