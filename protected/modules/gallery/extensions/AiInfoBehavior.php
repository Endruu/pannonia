<?php

class AiInfoBehavior extends CActiveRecordBehavior {

	public function getState( $isState = null ) {
		if( $this->owner->isLectored() ) {
			if( $this->owner->isDeleted() ) {
				if( $isState === null ) return 'deleted';
				return $isState === 'deleted' ? true : false;
			} else {
				if( $isState === null ) return 'valid';
				return $isState === 'valid' ? true : false;
			}
		} else {
			if( $this->owner->isDeleted() ) {
				if( $isState === null ) return 'temporary';
				return $isState === 'temporary' ? true : false;
			} else {
				if( $isState === null ) return 'draft';
				return $isState === 'draft' ? true : false;
			}
		}
	}
	
	public function ifState( $state = 'valid' ) {
		$crit = new CDbCriteria();
		$crit->with = 'stamp';
		
		switch( $state ) {
			case 'valid'	:
				$crit->condition = 'stamp.lectored_at IS NOT NULL AND t.deleted IS NULL';
				break;
			case 'deleted'	:
				$crit->condition = 'stamp.lectored_at IS NOT NULL AND t.deleted IS NOT NULL';
				break;
			case 'draft'	:
				$crit->condition = 'stamp.lectored_at IS NULL AND t.deleted IS NULL';
				break;
			case 'temporary':
				$crit->condition = 'stamp.lectored_at IS NULL AND t.deleted IS NOT NULL';
				break;
		}
		
		$this->owner->getDbCriteria()->mergeWith($crit);
		return $this->owner;
	}

	public function isDeleted() {
		return $this->owner->deleted ? true : false;
	}
	
	public function getDate($full = false) {
		if( $this->owner->ai_info_id && $this->owner->aiInfo->take_time ) {
			return $full ? $this->owner->aiInfo->take_time : mb_substr($this->owner->aiInfo->take_time, 0, 10);
		}
		return '';
	}
	
	public function isPicture() {
		return true;
	}
}
