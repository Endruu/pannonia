<?php

class AiLogRoute extends CDbLogRoute
{
	public $logTableName = 'ai_log_sub';
	public $autoCreateLogTable = false;
	
	protected function processLogs($logs)
	{
		foreach( $logs as $log ) {
			$aiSub = new AiLogSub();
			$aiSub->level		= strtoupper($log[1]);
			$aiSub->category	= $log[2];
			$aiSub->logtime		= $log[3];
			
			if( preg_match("/M([0-9]+):A([0-9]+):I([0-9]+):(.*)/", $log[0], $m) ) {
				$aiSub->ai_log_main_id	= $m[1] ? $m[1] : null;
				$aiSub->aid				= $m[2] ? $m[2] : null;
				$aiSub->iid				= $m[3] ? $m[3] : null;
				$aiSub->msg				= $m[4];
				
				/*if( $aiSub->iid ) {
					if( !Image::model()->exists(array('image_id' => $aiSub->iid)) ) {
						$aiSub->msg = 'I' . $aiSub->iid . ': ' . $aiSub->msg;
						$aiSub->iid = null;
					}
				}*/

				if( $aiSub->aid ) {
					if( !Album::model()->exists(
						array(
							'params' => array( ':aid' => $aiSub->aid),
							'condition' => 'album_id = :aid'
						)
					)) {
						$aiSub->msg = 'A' . $aiSub->aid . ': ' . $aiSub->msg;
						$aiSub->aid = null;
					}
				}
				
			} else {
				$aiSub->msg = $log[0];
			}
			
			$aiSub->save();
		}
	}
}