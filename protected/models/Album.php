<?php

/**
 * This is the model class for table "album".
 *
 * The followings are the available columns in table 'album':
 * @property integer $album_id
 * @property string $name
 * @property integer $stamp_id
 * @property integer $public
 *
 * The followings are the available model relations:
 * @property Stamp $stamp
 * @property Picture[] $pictures
 */
class Album extends CActiveRecord
{

	protected $path = '';
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Album the static model class
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
		return 'album';
	}
	
	public function behaviors()
	{
		return array(
			'StampBehavior' => array(
				'class'=>'application.components.StampBehavior',
			)
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
			array('name, public', 'required'),
			array('name', 'unique'),
			array('public', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('album_id, name, stamp_id, public', 'safe', 'on'=>'search'),
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
			'stamp' => array(self::BELONGS_TO, 'Stamp', 'stamp_id'),
			'pictures' => array(self::HAS_MANY, 'Picture', 'album_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'album_id' => 'ID',
			'name' => 'Név',
			'stamp_id' => 'Stamp',
			'public' => 'Publikus',
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

		$criteria->compare('album_id',$this->album_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('stamp_id',$this->stamp_id);
		$criteria->compare('public',$this->public);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function setAlbumPath()
	{
		$this->path = Yii::getPathOfAlias('webroot') . '/images/';
		if( $this->primaryKey == null ) {
			$this->path .= sprintf('t%05d', mt_rand(0,99999));		// temporary
		} else {
			if( $this->stamp->parent_id ) {
				$this->path .= sprintf('a%05d', $this->album_id);	// normal
			} else {
				$this->path .= sprintf('d%05d', $this->album_id);	// draft
			}
		}
	}
	
	protected function afterConstruct()
	{
		$this->setAlbumPath();
		
		if($this->hasEventHandler('onAfterConstruct'))
			$this->onAfterConstruct(new CEvent($this));
	}
	
	protected function afterFind()
	{
		$this->setAlbumPath();
		
		if($this->hasEventHandler('onAfterFind'))
			$this->onAfterFind(new CEvent($this));
	}

	protected function beforeSave()
	{
		
		if( !is_dir( $this->path ) ) {
			if( mkdir( $this->path, 0777, true ) ) {
				chmod( $this->path, 0777 );
			} else {
				$this->addError('name','Nem sikerült létrehozni a mappát!');
				return false;
			}
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
	
	protected function afterSave()
	{
		$this->isNewRecord = false;
		$oldpath = $this->path;
		$this->setAlbumPath();
		
		if( $oldpath != $this->path ) {
			if( is_dir( $oldpath ) ) {
				if( !rename($oldpath, $this->path) ) {
					$this->addError('name','Nem sikerült véglegesíteni a mappát!');
					if( !rmdir($oldpath) ) {
						$this->addError('name','Nem sikerült eltávolítani a mappát!');
					} else {
						$this->delete();
					}
				}
			} else {
				$this->addError('name','Hiányzó mappa!');
				$this->delete();
			}
		}
		
		
		if($this->hasEventHandler('onAfterSave'))
			$this->onAfterSave(new CEvent($this));
			
	}
	
	protected function beforeDelete()
	{
		if( is_dir( $this->path ) && !rmdir($this->path) ) {
			$this->addError('name','Nem sikerült eltávolítani a mappát!');
			return false;
		}
	
		if($this->hasEventHandler('onBeforeDelete'))
		{
			$event=new CModelEvent($this);
			$this->onBeforeDelete($event);
			return $event->isValid;
		}
		else
			return true;
	}
	
}