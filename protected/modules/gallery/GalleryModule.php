<?php

class GalleryModule extends CWebModule
{
	public $albumPath	= 'images/';
	public $albumMap	= null;
	public $thumbWidth	= 320;
	public $thumbHeight	= 211;
	public $phpThumbOptions = array(
		'resizeUp'				=> true,
		'jpegQuality'			=> 85,
		'correctPermissions'	=> true, 
	);

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application
		
		$this->albumPath = Yii::getPathOfAlias('webroot') . '/' . $this->albumPath;
		
		$defaultAlbumMap = array(
			'pictures'	=>	array(
								'thumb'		=> 'pic/thumb/',
								'src'		=> 'pic/src/',
							),
			'videos'	=>	array(
								'thumb'		=> 'vid/thumb/',
								'src'		=> 'vid/src/',
								'splash'	=> 'vid/splash/',
							),
			'deleted'	=> 'deleted/',
		);
		
		if( $this->albumMap === null ) {
			$this->albumMap = $defaultAlbumMap;
		} else {
			$this->albumMap = array_merge($defaultAlbumMap, $this->albumMap);
		}
		
		// import the module-level models and components
		$this->setImport(array(
			'gallery.models.*',
			'gallery.components.*',
			'gallery.extensions.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
	