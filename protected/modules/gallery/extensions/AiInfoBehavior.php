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
				$crit->condition = 'lectored_at IS NOT NULL AND deleted IS NULL';
				break;
			case 'deleted'	:
				$crit->condition = 'lectored_at IS NOT NULL AND deleted IS NOT NULL';
				break;
			case 'draft'	:
				$crit->condition = 'lectored_at IS NULL AND deleted IS NULL';
				break;
			case 'temporary':
				$crit->condition = 'lectored_at IS NULL AND deleted IS NOT NULL';
				break;
		}
		
		$this->owner->getDbCriteria()->mergeWith($crit);
		return $this->owner;
	}

	public function isDeleted() {
		return $this->owner->deleted ? true : false;
	}
}
