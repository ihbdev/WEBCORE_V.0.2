<div class="winget-title"><label><?php echo Language::t('Hỗ trợ trực tuyến','layout')?></label></div>
                <div class="winget-content">
                	<div class="box-support">
                	<?php 
                	foreach ($list_support as $support){
                		if($support->checkSkypeOnline()){
                			$skype=Yii::app()->theme->baseUrl.'/images/skype-online.png';
                		}
                		else 
                		{
                			$skype=Yii::app()->theme->baseUrl.'/images/skype-offline.png';
                		}
                		echo '<a href="skype:'.$support->skype.'?call"><img src="'.$skype.'"><span class="online">'.$support->name.'</span></a>';
                		if($support->checkYahooOnline()){
                			$yahoo=Yii::app()->theme->baseUrl.'/images/yahoo-online.png';
                		}
                		else 
                		{
                			$yahoo=Yii::app()->theme->baseUrl.'/images/yahoo-offline.png';
                		}
                		echo '<a href="ymsgr:sendim?'.$support->yahoo.'"><img src="'.$yahoo.'"><span class="online">'.$support->name.'</span></a>';
                	}
                	?>
                    </div><!--box-support-->
                    <div class="hotline"></div>
                </div><!--winget-content-->               