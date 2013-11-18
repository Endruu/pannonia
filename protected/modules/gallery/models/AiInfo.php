<?php

/**
 * This is the model class for table "ai_info".
 *
 * The followings are the available columns in table 'ai_info':
 * @property integer $ai_info_id
 * @property string $take_time
 * @property string $take_place
 * @property string $take_author
 *
 * The followings are the available model relations:
 * @property Album[] $albums
 * @property Image[] $images
 */
class AiInfo extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AiInfo the static model class
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
		return 'ai_info';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('take_place, take_author', 'length', 'max'=>120),
			array('take_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ai_info_id, take_time, take_place, take_author', 'safe', 'on'=>'search'),
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
			'albums' => array(self::HAS_MANY, 'Album', 'ai_info_id'),
			'images' => array(self::HAS_MANY, 'Image', 'ai_info_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ai_info_id' => 'Ai Info',
			'take_time' => 'Take Time',
			'take_place' => 'Take Place',
			'take_author' => 'Take Author',
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

		$criteria->compare('ai_info_id',$this->ai_info_id);
		$criteria->compare('take_time',$this->take_time,true);
		$criteria->compare('take_place',$this->take_place,true);
		$criteria->compare('take_author',$this->take_author,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}