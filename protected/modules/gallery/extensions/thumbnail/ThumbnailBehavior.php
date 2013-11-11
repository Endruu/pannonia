<?php

require_once dirname(__FILE__) . 'php-thumb/ThumbLib.inc.php';

class ThumbnailBehavior extends CActiveRecordBehavior {
	
	public	$albumPath		= YiiBase::getPathOfAlias('webroot') . '/images/';
	public	$width			= 256;
	public	$height			= 192;
	
	private	$_thumbPath		= '';
	private	$_originPath	= '';
	private	$_thumb			= '';
	private	$_original		= '';
	
	private function initVars() {
		if( !$this->_thumb ) {
		
			if( !($this->albumPath && $this->width && $this->height) ) {
				// hiba
				return 0;
			}
		
			$this->_thumbPath	= $this->_originPath	= $this->albumPath . $this->owner->album->getName() .'/';
			$this->_thumb		= $this->_original		= sprintf("%08d.", $this->owner->image_id );
			
			if( $this->owner->image_id->isPicture() ) {
				$this->_thumbPath	.= 'pic/thumb/';
				$this->_originPath	.= 'pic/src/';
				$this->_original	.= $this->owner->extension;
			} else {
				$this->_thumbPath	.= 'vid/thumb/';
				$this->_originPath	.= 'vid/splash/';
				$this->_original	.= 'jpg';
			}
			$this->_thumb .= 'jpg';
		}
		return 1;
	}
	
	public getThumbnail() {
		$this->initVars();
		return $this->_thumb;
	}
	
	public getImage() {
		$this->initVars();
		return $this->_original;
	}
	
	public function beforeDelete($event)
	{
		$this->initVars();
	}
	
	public function afterDelete($event)
	{
		if( $_thumb ) {
			if( rename($this->_thumbPath . $this->_thumb, $this->albumPath . 'del/thumbs/' . $this->_thumb) ) {
			} else {
			}
		} else {
		}
	} 
	
	public function afterSave($event)
	{
		if( $this->initVars() ) {
			try {
				$thumb = PhpThumbFactory::create($this->_originPath . $this->_original);
				$thumb->adaptiveResize($this->width, $this->height)->save($this->_thumbPath . $this->_thumb, 'jpg');
			}
			catch (Exception $e) {
				// log error
			}
			
		}
	} 
}