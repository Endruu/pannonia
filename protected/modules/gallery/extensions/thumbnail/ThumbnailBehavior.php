<?php

require_once dirname(__FILE__) . 'php-thumb/ThumbLib.inc.php';

class ThumbnailBehavior extends CActiveRecordBehavior {
	
	public	$module			= Yii::app()->getModule('gallery');
	
	public	$albumPath		= $this->module->albumPath; 
	public	$thumbWidth		= $this->module->thumbWidth;
	public	$thumbHeight	= $this->module->thumbHeight;
	
	private	$_thumbPath		= '';
	private	$_originPath	= '';
	private	$_thumb			= '';
	private	$_original		= '';
	
	private function initVars() {
		if( !$this->_thumb ) {
		
			if( !($this->albumPath && $this->width && $this->height) ) {
				$this->owner->aiError("Missing default parameter(s)!", 'Thumb.Init');
				return;
			}
		
			$this->_thumbPath	= $this->_originPath	= $this->albumPath . $this->owner->album->getDirName() .'/';
			$this->_thumb		= $this->_original		= sprintf("%08d.", $this->owner->image_id );
			
			if( $this->owner->image_id->isPicture() ) {
				$this->_thumbPath	.= $this->module->albumMap['pictures']['thumb'];
				$this->_originPath	.= $this->module->albumMap['pictures']['src'];
				$this->_original	.= $this->owner->extension;
			} else {
				$this->_thumbPath	.= $this->module->albumMap['videos']['thumb'];
				$this->_originPath	.= $this->module->albumMap['videos']['splash'];
				$this->_original	.= 'jpg';
			}
			$this->_thumb .= 'jpg';
		}
	}
	
	public getThumbnail() {
		if( !$this->initVars() )
			$this->owner->aiError("Init failed!", 'Thumb.GetThumb');
		return $this->_thumb;
	}
	
	public getImage() {
		if( !$this->initVars() )
			$this->owner->aiError("Init failed!", 'Thumb.GetImage');
		return $this->_original;
	}
	
	public function createThumb() {
		if( $this->initVars() ) {
			try {
				Yii::getLogger()->flush(true);	// just in case if memory is exceeded while resizing
				$thumb = PhpThumbFactory::create($this->_originPath . $this->_original);
				$thumb->adaptiveResize($this->width, $this->height)->save($this->_thumbPath . $this->_thumb, 'jpg');
			}
			catch (Exception $e) {
				$this->owner->aiError('Error while creating thumbnail: ' . $e->getMessage(), 'Thumb.Create');
			}
		} else {
			$this->owner->aiError("Init failed!", 'Thumb.Create');
		}
	}
	
	public function deleteThumb( $move = true ) {
		if( $_thumb ) {
			if( $move == true && $this->module->albumMap['deleted'] ) {
				$delete_path = $this->module->albumMap['deleted'] . $this->_thumb;
				if( rename($this->_thumbPath . $this->_thumb, $this->albumPath . $delete_path) ) {
					$this->owner->aiInfo("Thumbnail moved\n\tfrom: $_thumb\n\to:   $delete_path", 'Thumb.Delete');
				} else {
					$this->owner->aiError("Can't move thumbnail\n\tfrom: $_thumb\n\to:   $delete_path", 'Thumb.Delete');
				}
			} else {
				if( unlink($this->_thumbPath . $this->_thumb ) {
					$this->owner->aiInfo("Thumbnail deleted: $_thumb", 'Thumb.Delete');
				} else {
					$this->owner->aiError("Can't delete thumbnail: $_thumb", 'Thumb.Delete');
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