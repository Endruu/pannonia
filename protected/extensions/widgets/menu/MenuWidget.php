<?php

class MenuWidget extends CWidget
{
	private $assetPath = null;
	
	public $mainPage	= '#';
	public $navigation	= array();
	public $options		= array();
	public $forceAssets	= false;

    public function init() {
	
        if( $this->assetPath === null ) {
            $this->assetPath = Yii::app()->getAssetManager()->publish(dirname(__FILE__).DIRECTORY_SEPARATOR.'assets', true, -1, $this->forceAssets);
			
			$cs = Yii::app()->clientScript;
			$cs->registerCssFile( $this->assetPath . '/menu.css' );
			$cs->registerScriptFile( $this->assetPath . '/menu.js' );
			
			$this->render( '_menu',	array(
				'path' => $this->assetPath,
			));
		}

    }
	
	public function jsOptions() {
		$o2 = array();
		foreach( $this->options as $opt => $val ) {
			$o2[] = "$opt:\t$val";
		}
		return implode($o2, ",\n");
	}

}