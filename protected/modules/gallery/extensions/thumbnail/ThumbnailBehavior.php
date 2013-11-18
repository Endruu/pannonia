<?php

require_once dirname(__FILE__) . '/php-thumb/ThumbLib.inc.php';

class ThumbnailBehavior extends CActiveRecordBehavior {

	public	$module			= null;

	public	$albumPath		= '';
	public	$thumbWidth		= '';
	public	$thumbHeight	= '';
	
	private	$_thumbPath		= '';
	private	$_originPath	= '';
	private	$_thumb			= '';
	private	$_original		= '';
	private	$_delete		= '';
	
	private function initVars() {
		if( !$this->_thumb ) {
			$this->module		= Yii::app()->getModule('gallery');
			$this->albumPath	= $this->module->albumPath; 
			$this->thumbWidth	= $this->module->thumbWidth;
			$this->thumbHeight	= $this->module->thumbHeight;
		
		
			if( !($this->albumPath && $this->thumbWidth && $this->thumbHeight) ) {
				$this->owner->aiError("Missing default parameter(s)!", 'Thumb.Init');
				return false;
			}
		
			$this->_thumbPath	= $this->_originPath	= $this->albumPath . $this->owner->album->getDirName() .'/';
			$this->_thumb		= $this->_original		= sprintf("%08d.", $this->owner->image_id );
			
			if( $this->module->albumMap['deleted'] ) {
				$this->_delete = $this->_thumbPath . $this->module->albumMap['deleted'];
			}
			
			if( $this->owner->isPicture() ) {
				$this->_thumbPath	.= $this->module->albumMap['pictures']['thumb'];
				$this->_originPath	.= $this->module->albumMap['pictures']['src'];
				$this->_original	.= $this->owner->extension;
				if( $this->_delete )
					$this->_delete .= $this->module->albumMap['pictures']['thumb'];
			} else {
				$this->_thumbPath	.= $this->module->albumMap['videos']['thumb'];
				$this->_originPath	.= $this->module->albumMap['videos']['splash'];
				$this->_original	.= 'jpg';
				if( $this->_delete )
					$this->_delete .= $this->module->albumMap['pictures']['thumb'];
			}
			$this->_thumb .= 'jpg';
			if( $this->_delete )
				$this->_delete .= $this->_thumb;
		}
		return true;
	}
	
	public function getThumbnail($url = false) {
		if( !$this->initVars() )
			$this->owner->aiError("Init failed!", 'Thumb.GetThumb');
		if($url)
			return Yii::app()->getBaseUrl() .'/'. substr($this->_thumbPath . $this->_thumb, strlen(Yii::getPathOfAlias('webroot')));
		return $this->_thumbPath . $this->_thumb;
	}
	
	public function getImage($url = false) {
		if( !$this->initVars() )
			$this->owner->aiError("Init failed!", 'Thumb.GetImage');
		
		if($url)
			return Yii::app()->getBaseUrl() .'/'. substr($this->_originPath . $this->_original, strlen(Yii::getPathOfAlias('webroot')));
		return $this->_originPath . $this->_original;
	}
	
	public function createThumb() {
		if( $this->initVars() ) {
			try {
				Yii::getLogger()->flush(true);	// just in case if memory is exceeded while resizing
				$thumb = PhpThumbFactory::create($this->_originPath . $this->_original);
				$thumb->adaptiveResize($this->thumbWidth, $this->thumbHeight)->save($this->_thumbPath . $this->_thumb, 'jpg');
				$this->owner->aiInfo('Thumbnail created!', 'Thumb.Create');
			}
			catch (Exception $e) {
				$this->owner->aiError('Error while creating thumbnail: ' . $e->getMessage(), 'Thumb.Create');
			}
		} else {
			$this->owner->aiError("Init failed!", 'Thumb.Create');
		}
	}
	
	public function deleteThumb( $move = true ) {
		if( $this->_thumb ) {
			if( $move == true && $this->_delete ) {
				if( rename($this->_thumbPath . $this->_thumb, $this->albumPath . $this->_delete) ) {
					$this->owner->aiInfo("Thumbnail moved\n\tfrom: $this->_thumb\n\to:   $this->_delete", 'Thumb.Delete');
				} else {
					$this->owner->aiError("Can't move thumbnail\n\tfrom: $this->_thumb\n\to:   $this->_delete", 'Thumb.Delete');
				}
			} else {
				if( unlink($this->_thumbPath . $this->_thumb ) ) {
					$this->owner->aiInfo("Thumbnail deleted: $this->_thumb", 'Thumb.Delete');
				} else {
					$this->owner->aiError("Can't delete thumbnail: $this->_thumb", 'Thumb.Delete');
				}
			}
		} else {
			$this->owner->aiError("Init failed!", 'Thumb.Delete');
		}
	}
	
	// Events:
	
	public function beforeDelete($event)
	{
		$this->initVars();
	}
	
	public function afterDelete($event)
	{
		$this->deleteThumb();
	} 
	
	/*public function afterSave($event)
	{
		$this->createThumb();
	} */
}