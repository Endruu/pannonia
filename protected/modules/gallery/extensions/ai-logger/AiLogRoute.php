<?php

class AiLogRoute extends CDbLogRoute
{
	protected function createLogTable($db,$tableName)
	{
	}
	
	protected function processLogs($logs)
	{
		$aiMain = new AiLogMain();
		
		foreach( $logs as $log ) {
			$aiSub = new AiLogSub();
			$aiSub->level		= $log[1];
			$aiSub->category	= $log[2];
			
			if( preg_match("/M([0-9]+):A([0-9]+):I([0-9]+):(.*)/", $log[0], $m) ) {
				$aiSub->ailog_main_id	= $m[1] ? $m[1] : null;
				$aiSub->aid				= $m[2];
				$aiSub->iid				= $m[3] ? $m[3] : null;
				$aiSub->msg				= $m[4];
			} else {
				$aiSub->msg				= $log[0];
			}
			
			if( $aiSub->ailog_main_id ) {
				if( $aiSub->ailog_main_id != $aiMain->ailog_main_id )
					$aiMain = $aiMain->findByPk($aiSub->ailog_main_id);
				$aiSub->logtime	= (int)(($log[3] - $aiMain->start_time)*1000000);	//usec
			} else {
				$aiSub->logtime	= (int)$log[3];
			}
			
			$aiSub->save();
		}
	}
}