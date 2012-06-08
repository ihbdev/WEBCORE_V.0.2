<!--begin inside content-->
	<div class="folder top">
		<!--begin title-->
		<div class="folder-header">
			<h1>Thông tin chi tiết của đơn đăng kí</h1>
			<div class="header-menu">
				<ul>
					<li><a class="header-menu-active new-icon" href=""><span>Thông tin chi tiết của đơn đăng kí</span></a></li>					
				</ul>
			</div>
		</div>
		<!--end title-->
		<div class="folder-content form">
		<div>
                <input type="button" class="button" value="Danh sách đơn đăng kí" style="width:180px;" onClick="parent.location='<?php echo Yii::app()->createUrl('admin/register')?>'"/>
                <div class="line top bottom"></div>	
            </div>
			<!--begin left content-->
			<div class="fl">
				<ul>
					<div class="row">
						<li>
							<label><?php echo $model->getAttributeLabel('fullname'); ?>:</label>
							<?php echo $model->fullname;?>			
						</li>
					</div>	
					<div class="row">
					<li>
							<label><?php echo $model->getAttributeLabel('email'); ?>:</label>
							<?php echo $model->email;?>	
					</li>	
					</div>
					<div class="row">
					<li>
							<label><?php echo $model->getAttributeLabel('phone'); ?>:</label>
							<?php echo $model->phone;?>	
					</li>	
					</div>	
					<div class="row">
					<li>
							<label><?php echo $model->getAttributeLabel('address'); ?>:</label>
							<?php echo $model->address;?>	
					</li>	
					</div>	
					<div class="row">
					<li>
							<label><?php echo $model->getAttributeLabel('attach'); ?>:</label>
							<?php  echo CHtml::link("Download",array('/site/download','path'=>$model->attach),array('target'=>'_blank'))?>	
					</li>	
					</div>	
				</ul>
			</div>
			<!--end left content-->			
			<div class="clear"></div>          
		</div>
	</div>
	<!--end inside content-->