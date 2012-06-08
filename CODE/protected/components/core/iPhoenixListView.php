<?php
Yii::import('zii.widgets.CListView');
Yii::import('theme.components.iPhoenixLinkPager');
class iPhoenixListView extends CListView
{
	/**
	 * Renders the pager.
	 */
	public function renderPager()
	{
		if(!$this->enablePagination)
			return;
		$pager=array();
		$class='iPhoenixLinkPager';
		if(is_string($this->pager))
			$class=$this->pager;
		else if(is_array($this->pager))
		{
			$pager=$this->pager;
			if(isset($pager['class']))
			{
				$class=$pager['class'];
				unset($pager['class']);
			}
		}
		$pager['pages']=$this->dataProvider->getPagination();
		$this->widget($class,$pager);
	}
}
?>