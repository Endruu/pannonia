<?php

class AttributeWidget extends CWidget
{
    public	'preTag'	= '';
	public	'data'		= null;
	
	public function init() {
		if( $this->preTag )
			$this->preTag .= '-';
	}
	
	public function a( $attr ) {
		echo "<div class='attr-container attr-$this->pretag$attr'>"
		echo '<span class="attr-name">' . CHtml::encode($this->data->getAttributeLabel($attr)) . '</span>';
		echo '<span class="attr-name">' . CHtml::encode($this->data->$attr) . '</span>';
		echo '</div>'
	}
}