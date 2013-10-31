<?php

/**
 * This is the model class for table "stamp".
 *
 * The followings are the available columns in table 'stamp':
 * @property integer $stamp_id
 * @property string $created_at
 * @property string $modified_at
 * @property integer $creator_id
 * @property integer $modifier_id
 * @property integer $parent_id
 * @property string $lectored_at
 *
 * The followings are the available model relations:
 * @property Album[] $albums
 * @property Picture[] $pictures
 * @property User $modifier
 * @property User $creator
 * @property User $parent
 */
class Stamp extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Stamp the static model class
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
		return 'stamp';
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
			array('stamp_id, created_at, modified_at, creator_id, modifier_id, parent_id, lectored_at', 'safe', 'on'=>'search'),
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
			'albums' => array(self::HAS_MANY, 'Album', 'stamp_id'),
			'pictures' => array(self::HAS_MANY, 'Picture', 'stamp_id'),
			'modifier' => array(self::BELONGS_TO, 'User', 'modifier_id'),
			'creator' => array(self::BELONGS_TO, 'User', 'creator_id'),
			'parent' => array(self::BELONGS_TO, 'User', 'parent_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'stamp_id' => 'Stamp',
			'created_at' => 'Létrehozva',
			'modified_at' => 'Módosítva',
			'creator_id' => 'Létrehozta',
			'modifier_id' => 'Módosította',
			'parent_id' => 'Felelős',
			'lectored_at' => 'Engedélyezve',
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

		$criteria->compare('stamp_id',$this->stamp_id);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('modified_at',$this->modified_at,true);
		$criteria->compare('creator_id',$this->creator_id);
		$criteria->compare('modifier_id',$this->modifier_id);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('lectored_at',$this->lectored_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	protected function beforeSave()
	{
		if( $this->isNewRecord ) {
			$this->creator_id = 1;	// majd át kell írni a bejelentkezettre
			$this->created_at = new CDbExpression('NOW()');
		} else {
			$this->modifier_id = 1;	// majd át kell írni a bejelentkezettre
			$this->modified_at = new CDbExpression('NOW()');
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
	
	public function lector() {
		$this->parent_id = 1;	// majd át kell írni a bejelentkezettre
		$this->lectored_at = new CDbExpression('NOW()');
		return $this->save();
	}
	
	public function isLectored() {
		if( $this->lectored_at ) {
			return true;
		} else {
			return false;
		}
	}
}