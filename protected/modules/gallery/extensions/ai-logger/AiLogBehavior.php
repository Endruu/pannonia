<?php

class AiLogBehavior extends CActiveRecordBehavior {
	private $_aiLogger = new AiLogger();

	public function startAiLog() {
		$this->_aiLogger->start();
	}
	
	public function stopAiLog() {
		$this->_aiLogger->stop();
	}

	public function aiLog($msg, $level, $category) {
		if( $this->owner->tableName() == 'album' ) {
			$aid = $this->owner->album_id;
			$iid = 0;
		} else {
			$aid = $this->owner->album->album_id;
			$iid = $this->owner->image_id;
		}
		$this->_aiLogger->log($msg, $level, $category, $aid, $iid);
	}
	
	public function aiInfo($msg, $category) {
		$this->aiLog($msg, 'INFO', $category);
	}
	
	public function aiError($msg, $category) {
		$this->aiLog($msg, 'ERROR', $category);
	}
	
	public function aiFlush() {
		$this->aiLog->save();
	}
}

class AiLogger {

	private static $_aiLogger = null;
	
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
		if( self::$_aiLogger === null ) {
			self::$_aiLogger = new CLogger;
			self::$_aiLogger->autoDump	= true;
			self::$_aiLogger->autoFlush	= 10;
		}
		
		$msg = "M" . $this->_MainId . ":A$aid:I$iid:" . $msg;
		self::$_aiLogger->log($msg, $level, $category);
	}
	
	public function save() {
		self::$_aiLogger->flush(true);
	}
}