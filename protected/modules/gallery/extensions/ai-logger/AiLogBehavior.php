<?php

class AiLogBehavior extends CActiveRecordBehavior {
	private $_aiLogger = null;

	public function startAiLog() {
		$this->getAiLogger()->start();
	}
	
	public function stopAiLog() {
		$this->getAiLogger()->stop();
	}

	public function aiLog($msg, $level, $category) {
		if( $this->owner->tableName() == 'album' ) {
			$category = 'AiLog.Album.' . $category;
			$aid = $this->owner->getIsNewRecord() ? 0 : $this->owner->getPrimaryKey();
			$iid = 0;
		} else {
			$category = 'AiLog.Image.' . $category;
			$aid = $this->owner->album->getPrimaryKey();
			$iid = $this->owner->getIsNewRecord() ? 0 : $this->owner->getPrimaryKey();
		}
		$this->getAiLogger()->log($msg, $level, $category, $aid, $iid);
	}
	
	public function aiTrace($msg, $category) {
		$this->aiLog($msg, 'TRACE', $category);
	}
	
	public function aiInfo($msg, $category) {
		$this->aiLog($msg, 'INFO', $category);
	}
	
	public function aiWarn($msg, $category) {
		$this->aiLog($msg, 'WARNING', $category);
	}
	
	public function aiError($msg, $category) {
		$this->aiLog($msg, 'ERROR', $category);
	}
	
	public function aiFlush() {
		$this->aiLog->save();
	}
	
	public function getAiLogger() {
		if( $this->_aiLogger === null )
			$this->_aiLogger = new AiLogger();
		return $this->_aiLogger;
	}
	
	public function saveState() {
		$attr	= $this->owner->getAttributes();
		$table	= $this->owner->tableName();
		foreach( $attr as $key => $val ) {
			if( $val ) {
				$keys[]		= $key;
				$values[]	= $val;
			}
		}
		$keys	= implode(', ', $keys);
		$values	= implode("', '", $values);
		$this->aiInfo("Recovery Insert: < $table ( $keys ) VALUES ( '$values' ) >", "Insert");
	}
}

class AiLogger {
	
	private $_startTime;
	private $_aiMain	= null;
	private $_MainId	= 0;
	
	public function start() {
		if( $this->_aiMain === null ) {
			
			$this->_startTime = microtime(true);
			
			$aiMain = new AiLogMain();
			$aiMain->start_time	= (int)$this->_startTime;
			$aiMain->user_id	= 1;
			if($aiMain->save()) {
				$this->_MainId = $aiMain->ai_log_main_id;
			}
			$this->_aiMain = $aiMain;
			
		} else {
			Yii::log("start() called before stop()", "ERROR", "AiLogBehavior");
		}
	}
	
	public function stop() {
		if( $this->_aiMain !== null ) {
		
			$this->_aiMain->duration = (int)( (microtime(true) - $this->_startTime)*1000000);	// usec
			$this->_aiMain->peak_memory = memory_get_peak_usage(true);
			$this->_aiMain->save();
			
			$this->_aiMain	= null;
			$this->_MainId	= 0;
			
		} else {
			Yii::log("stop() called before start()", "ERROR", "AiLogBehavior");
		}
	}
	
	public function log($msg, $level, $category, $aid, $iid = 0) {
		$msg = "M" . $this->_MainId . ":A$aid:I$iid:" . $msg;
		Yii::log($msg, $level, $category);
	}
	
	public function flushFromDb( $attr, $id ) {
		$filename = Yii::app()->getModule('gallery')->albumPath . 'logs/';
		
		Yii::getLogger()->flush(true);	// write pending logs to db before flushing db itself
		
		if( strtolower($attr) == 'album' ) {
			$attr = 'aid';
			$filename .= sprintf("a%05d.txt", $id);
		} else {
			$attr = 'iid';
			$filename .= sprintf("i%05d.txt", $id);
		}
		
		$crit = new CDbCriteria();
		$crit->compare($attr, "=$id");
		$crit->with		= 'parent';
		$crit->order	= 't.ai_log_main_id, ai_log_sub_id ASC';
		$del = AiLogSub::model()->findAll($crit);
		
		$file = fopen($filename, 'a');
		if( !$file) {
			return 0;
		}
		
		fwrite($file, sprintf("PermaDelete: %s\n", date("Y-m-d H:i:s")));
		
		foreach( $del as $d ) {
			$m = $d->ai_log_main_id ? $d->ai_log_main_id : 0;
			$a = $d->aid ? $d->aid : 0;
			$i = $d->iid ? $d->iid : 0;
			
			$l = "\n>> ";
			
			$l .= sprintf("%-7d | ", $d->getPrimaryKey());
			
			if( $m ) {
				$d->logtime /= 1000000;	// usec->sec
				$d->logtime += $d->parent->start_time;
			}
			$l .= sprintf("%-26s | ", $d->getLogTime());
			
			$l .= sprintf("%-10s | ", strtoupper($d->level));
			
			$l .= "M$m:A$a:I$i | ";
			
			$l .= $d->category;
			
			$l .= "\n  - " . implode("\n  - ", explode("\n", $d->msg));
			
			fwrite($file, $l);
		}
		
		fwrite($file,"\n\n");
		return fclose($file);
	}
	
	public function deleteFromDb( $attr, $id ) {
		if( strtolower($attr) == 'album' ) {
			$attr = 'aid';
		} else {
			$attr = 'iid';
		}
		
		$crit = new CDbCriteria();
		$crit->compare($attr, "=$id");
		$rowNum = AiLogSub::model()->count($crit);
		$delNum = AiLogSub::model()->deleteAll($crit);
		
		return ( $rowNum - $delNum ) ? false : true;
		return false;
	}
}