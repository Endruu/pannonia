<?php
class StampBehavior extends CActiveRecordBehavior {

	public function beforeSave($event)
	{
		if( $this->owner->isNewRecord ) {
			$stamp = new Stamp;
			if( $stamp->save() ) {
				if( $this->owner->isNewRecord ) {
					$this->owner->stamp_id = $stamp->stamp_id;
				}
			} else {
				$event->isValid = false;
			}
		} else {
			$this->owner->stamp->save(); 
		}
	}

	public function afterDelete($event)
	{
		$this->owner->stamp->delete();
	}
	
	public function lector() {
		return $this->owner->stamp->lector();
	}
}