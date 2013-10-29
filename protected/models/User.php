<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $user_id
 * @property string $name
 * @property string $nick
 * @property integer $parent_id
 * @property string $created_at
 *
 * The followings are the available model relations:
 * @property Stamp[] $stamps
 * @property Stamp[] $stamps1
 * @property Stamp[] $stamps2
 * @property User $parent
 * @property User[] $users
 */
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
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
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, nick', 'required'),
			array('name', 'length', 'max'=>77),
			array('nick', 'length', 'max'=>15),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, name, nick, parent_id, created_at', 'safe', 'on'=>'search'),
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
			'stamps' => array(self::HAS_MANY, 'Stamp', 'modifier_id'),
			'stamps1' => array(self::HAS_MANY, 'Stamp', 'creator_id'),
			'stamps2' => array(self::HAS_MANY, 'Stamp', 'parent_id'),
			'parent' => array(self::BELONGS_TO, 'User', 'parent_id'),
			'users' => array(self::HAS_MANY, 'User', 'parent_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'ID',
			'name' => 'Név',
			'nick' => 'Becenév',
			'parent_id' => 'Felelős',
			'created_at' => 'Létrehozva',
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

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('nick',$this->nick,true);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('created_at',$this->created_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}