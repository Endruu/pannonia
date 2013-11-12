<?php

/**
 * This is the model class for table "ai_log_main".
 *
 * The followings are the available columns in table 'ai_log_main':
 * @property integer $ai_log_main_id
 * @property string $start_time
 * @property integer $duration
 * @property integer $peak_memory
 * @property integer $user_id
 *
 * The followings are the available model relations:
 * @property User $user
 * @property AiLogSub[] $aiLogSubs
 */
class AiLogMain extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AiLogMain the static model class
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
		return 'ai_log_main';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ai_log_main_id, start_time, duration, peak_memory, user_id', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'children' => array(self::HAS_MANY, 'AiLogSub', 'ai_log_main_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ai_log_main_id' => 'Ai Log Main',
			'start_time' => 'Start Time',
			'duration' => 'Duration',
			'peak_memory' => 'Peak Memory',
			'user_id' => 'User',
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

		$criteria->compare('ai_log_main_id',$this->ai_log_main_id);
		$criteria->compare('start_time',$this->start_time,true);
		$criteria->compare('duration',$this->duration);
		$criteria->compare('peak_memory',$this->peak_memory);
		$criteria->compare('user_id',$this->user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}