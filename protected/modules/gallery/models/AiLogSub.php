<?php

/**
 * This is the model class for table "ai_log_sub".
 *
 * The followings are the available columns in table 'ai_log_sub':
 * @property integer $ai_log_sub_id
 * @property string $level
 * @property string $category
 * @property integer $logtime
 * @property string $msg
 * @property integer $ai_log_main_id
 * @property integer $iid
 * @property integer $aid
 *
 * The followings are the available model relations:
 * @property AiLogMain $aiLogMain
 * @property Image $i
 * @property Album $a
 */
class AiLogSub extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AiLogSub the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ai_log_sub';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ai_log_sub_id, level, category, logtime, msg, ai_log_main_id, iid, aid', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'parent' => array(self::BELONGS_TO, 'AiLogMain', 'ai_log_main_id'),
			'image' => array(self::BELONGS_TO, 'Image', 'iid'),
			'album' => array(self::BELONGS_TO, 'Album', 'aid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ai_log_sub_id' => 'Ai Log Sub',
			'level' => 'Level',
			'category' => 'Category',
			'logtime' => 'Logtime',
			'msg' => 'Msg',
			'ai_log_main_id' => 'Ai Log Main',
			'iid' => 'Iid',
			'aid' => 'Aid',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('ai_log_sub_id',$this->ai_log_sub_id);
		$criteria->compare('level',$this->level,true);
		$criteria->compare('category',$this->category,true);
		$criteria->compare('logtime',$this->logtime);
		$criteria->compare('msg',$this->msg,true);
		$criteria->compare('ai_log_main_id',$this->ai_log_main_id);
		$criteria->compare('iid',$this->iid);
		$criteria->compare('aid',$this->aid);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getLogTime( $asString = true, $withMicroSec = true ) {
		if( $this->ai_log_main_id ) {
			$time =	$this->logtime /= 1000000;	// usec->sec
			$time += $this->parent->start_time;
		}
		
		if( !$asString ) return $time;
		
		$timeAsString = date("Y-m-d H:i:s", $time);
		
		if( $withMicroSec ) $timeAsString .= sprintf(".%d", ($time-(int)($time))*1000000);	// usec -> sec

		return $timeAsString;
	}
	
	protected function beforeSave()
	{
		if( $this->ai_log_main_id ) {
			$this->logtime = (int)(($this->logtime - $this->parent->start_time)*1000000);	// sec -> usec
		}
		
		if($this->hasEventHandler('onBeforeSave'))
		{
			$event=new CModelEvent($this);
			$this->onBeforeSave($event);
			return $event->isValid;
		}
		else
			return true;
	}
}