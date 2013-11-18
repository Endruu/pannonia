<?php

/**
 * This is the model class for table "image".
 *
 * The followings are the available columns in table 'image':
 * @property integer $image_id
 * @property string $name
 * @property integer $public
 * @property integer $album_id
 * @property integer $stamp_id
 * @property string $extension
 * @property string $hash
 * @property string $original_name
 * @property integer $ai_info_id
 * @property string $deleted
 *
 * The followings are the available model relations:
 * @property AiLogSub[] $aiLogSubs
 * @property AiInfo $aiInfo
 * @property Album $album
 * @property Stamp $stamp
 */
class Image extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Image the static model class
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
		return 'image';
	}

	public function behaviors()
	{
		return array(
			'StampBehavior'		=> array(
				'class'	=> 'application.components.StampBehavior',
			),
			'AiLogBehavior'		=> array(
				'class'	=> 'application.modules.gallery.extensions.ai-logger.AiLogBehavior',
			),
			'AiInfoBehavior'	=> array(
				'class'	=> 'application.modules.gallery.extensions.AiInfoBehavior',
			),
			'ThumbnailBehavior'	=> array(
				'class'	=> 'application.modules.gallery.extensions.thumbnail.ThumbnailBehavior',
			),
		);
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('public', 'required'),
			array('public', 'numerical', 'integerOnly'=>true),
			array('name, original_name', 'length', 'max'=>120),
			array('extension', 'length', 'max'=>3),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('image_id, name, public, album_id, stamp_id, extension, hash, original_name, ai_info_id, deleted', 'safe', 'on'=>'search'),
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
			'aiLogSubs' => array(self::HAS_MANY, 'AiLogSub', 'iid'),
			'information' => array(self::BELONGS_TO, 'AiInfo', 'ai_info_id'),
			'album' => array(self::BELONGS_TO, 'Album', 'album_id'),
			'stamp' => array(self::BELONGS_TO, 'Stamp', 'stamp_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'image_id'		=> 'ID',
			'name'			=> 'Név',
			'public'		=> 'Publikus',
			'album_id'		=> 'Album ID',
			'stamp_id'		=> 'Stamp ID',
			'extension'		=> 'Kiterjesztés',
			'hash'			=> 'Hash',
			'original_name'	=> 'Eredeti név',
			'ai_info_id'	=> 'Info ID',
			'deleted'		=> 'Törölve',
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

		$criteria->compare('image_id',$this->image_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('public',$this->public);
		$criteria->compare('album_id',$this->album_id);
		$criteria->compare('stamp_id',$this->stamp_id);
		$criteria->compare('extension',$this->extension,true);
		$criteria->compare('hash',$this->hash,true);
		$criteria->compare('original_name',$this->original_name,true);
		$criteria->compare('ai_info_id',$this->ai_info_id);
		$criteria->compare('deleted',$this->deleted,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getForIndex($public = true) {
		
		if( $public )
			$this->getDbCriteria()->mergeWith(array('condition' => 't.public=1'));
			
		$this->with(
			array(
				'information',
				'album'			=> array(
					'select'	=> 'name, stamp_id',
				),
				'album.stamp'	=> array(
					'alias'		=> 'aStamp',
				),
			)
		)->ifState('valid');
		
		return new CActiveDataProvider('Image', array( 'criteria' => $this->getDbCriteria()));
		
	}
}