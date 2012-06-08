<?php
class iPhoenixLinkPager extends CLinkPager
{
	/**
	 * Creates a page button.
	 * You may override this method to customize the page buttons.
	 * @param string $label the text label for the button
	 * @param integer $page the page number
	 * @param string $class the CSS class for the page button. This could be 'page', 'first', 'last', 'next' or 'previous'.
	 * @param boolean $hidden whether this page button is visible
	 * @param boolean $selected whether this page button is selected
	 * @return string the generated button
	 */
	public $header='';
	public $htmlOptions=array('class'=>'');
	public function run()
	{
		$this->registerClientScript();
		$buttons=$this->createPageButtons();
		if(empty($buttons))
			return;
		echo '<div class="pages">';
		echo '<div class="pages-inner">';	
		echo implode("\n",$buttons);
		echo '</div>';
		echo '</div>';
	}
	protected function createPageButton($label,$page,$class,$hidden,$selected)
	{
		if($hidden || $selected)
			$class.=' '.($hidden ? self::CSS_HIDDEN_PAGE : self::CSS_SELECTED_PAGE);
		return CHtml::link($label,$this->createPageUrl($page));
	}
}
?>