<?php

require_once dirname(__FILE__) . '/php-thumb/ThumbLib.inc.php';

class ThumbnailBehavior extends CActiveRecordBehavior {

	public	$module			= null;

	public	$albumPath		= '';
	public	$thumbWidth		= '';
	public	$thumbHeight	= '';
	public	$phpThumbOptions = array();
	
	private	$_thumbPath		= '';
	private	$_originPath	= '';
	private	$_thumb			= '';
	private	$_original		= '';
	private	$_delete		= '';
	
	private function initVars($force = false) {
		if( !$this->_thumb || $force ) {
			$this->module		= Yii::app()->getModule('gallery');
			$this->albumPath	= $this->module->albumPath; 
			$this->thumbWidth	= $this->module->thumbWidth;
			$this->thumbHeight	= $this->module->thumbHeight;
			$this->phpThumbOptions	= $this->module->phpThumbOptions;
		
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
			return Yii::app()->getBaseUrl() . substr($this->_thumbPath . $this->_thumb, strlen(Yii::getPathOfAlias('webroot')));
		return $this->_thumbPath . $this->_thumb;
	}
	
	public function getImage($url = false) {
		if( !$this->initVars() )
			$this->owner->aiError("Init failed!", 'Thumb.GetImage');
		
		if($url)
			return Yii::app()->getBaseUrl() . substr($this->_originPath . $this->_original, strlen(Yii::getPathOfAlias('webroot')));
		return $this->_originPath . $this->_original;
	}
	
	public function createThumb() {
		$this->owner->aiInfo('Trying to create thumbnail!', 'Thumb.Create');
		if( $this->initVars() ) {
			try {
				Yii::getLogger()->flush(true);	// just in case if memory is exceeded while resizing
				$thumb = PhpThumbFactory::create($this->_originPath . $this->_original, $this->phpThumbOptions);
				$thumb->adaptiveResize($this->thumbWidth+2, $this->thumbHeight+2)->save($this->_thumbPath . $this->_thumb, 'jpg');
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

	public function afterSave($event) {
		if($this->owner->getIsNewRecord()) {
			if($this->initVars(true)) {
				$oldname = $this->_originPath . $this->owner->original_name;
				$newname = $this->_originPath . $this->_original;
				if( rename($oldname, $newname)) {
					$this->owner->aiInfo($this->owner->original_name . " renamed to $this->_original", 'Thumb.AfterSave');
				} else {
					$this->owner->aiError("Failed to rename " . $this->owner->original_name . " to $this->_original!", 'Thumb.AfterSave');
				}
			} else {
				$this->owner->aiError("Init failed!", 'Thumb.AfterSave');
			}
		}
	}

	public function beforeSave($event) {
		if($this->owner->getIsNewRecord()) {
			if(!isset($this->owner->public)) $this->owner->public = false;
			if( preg_match( "/.*\.([jpegnif]{3,4})/", strtolower($this->owner->original_name), $m ) ) {	// check picture type
				$ext = $m[1];
				if($ext == 'jpeg') $ext = 'jpg';
				$this->owner->extension = $ext;
			} else {
				$this->owner->aiError("Failed to determine extension of: $this->owner->original_name" , 'Thumb.BeforeSave');
				$event->isValid = false;
			}
		}
	}

}
