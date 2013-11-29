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

	private $fullPath	= '';
	private $dirName	= '';
	
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
			'StampBehavior'		=> array(
				'class'	=> 'application.components.StampBehavior',
			),
			'AiLogBehavior'		=> array(
				'class'	=> 'application.modules.gallery.extensions.ai-logger.AiLogBehavior',
			),
			'AiInfoBehavior'	=> array(
				'class'	=> 'application.modules.gallery.extensions.AiInfoBehavior',
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
			'aiLogSubs' => array(self::HAS_MANY, 'AiLogSub', 'aid'),
			'information' => array(self::BELONGS_TO, 'AiInfo', 'ai_info_id'),
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
		$criteria->with = 'stamp';
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function createDir()
	{
		if( !$this->getIsNewRecord() ) {
			$this->aiInfo("Creating directory for new album", "CreateDir");
			
			$this->setPath();
			
			$path	= Yii::app()->getModule('gallery')->albumPath . $this->dirName . '/';
			$map	= Yii::app()->getModule('gallery')->albumMap;
			
			foreach( $map['videos'] as $n => $p ) {
				$pd = $path . $p;
				if( !is_dir($pd) ) {
					if( !mkdir($pd, 0777, true) ) {
						$this->aiError("Can't create directory for videos-$n:\n$pd", "CreateDir");
						return 0;
					}
				}
				if( $map['deleted'] ) {
					$pd = $path . $map['deleted'] . $p;
					if( !is_dir($pd) ) {
						if( !mkdir($pd, 0777, true) ) {
							$this->aiError("Can't create directory for deleted videos-$n:\n$pd", "CreateDir");
							return 0;
						}
					}
				}
			}
			
			foreach( $map['pictures'] as $n => $p ) {
				$pd = $path . $p;
				if( !is_dir($pd) ) {
					if( !mkdir($pd, 0777, true) ) {
						$this->aiError("Can't create directory for pictures-$n:\n$pd", "CreateDir");
						return 0;
					}
				}
				if( $map['deleted'] ) {
					$pd = $path . $map['deleted'] . $p;
					if( !is_dir($pd) ) {
						if( !mkdir($pd, 0777, true) ) {
							$this->aiError("Can't create directory for deleted pictures-$n:\n$pd", "CreateDir");
							return 0;
						}
					}
				}
			}
			
			$this->aiInfo("Directory " . $this->dirName . " created." , "CreateDir");
		
		} else {
			$this->aiWarn("Directory already exists!", "CreateDir");
		}
		
		return 1;
	}
	
	private function _delDirSub( $path, $dir, $force = false ) {
		$pdir = $path . $dir;
		
		if( is_dir($pdir) ) {
			if( $force ) {
				$obj = scandir($pdir);
				foreach( $obj as $o ) {
					if( is_file( $pdir . $o ) ) {
						if( unlink( $pdir . $o ) ) {
							$this->aiWarn("File deleted: $pdir$o", "DeleteDir");
						} else {
							$this->aiError("Can't delete file : $pdir$o", "DeleteDir");
							return 0;
						}
					}
				}
			}
			
			$dirs[0] = ''; $i = 0;
			foreach( explode('/', $dir) as $d ) {
				$i++;
				$dirs[$i] = $dirs[$i-1] . $d . '/';
			}
			array_shift($dirs);				// $dirs[0] = ''
			$dirs = array_reverse($dirs);
			array_shift($dirs);				// last '/'
			
			foreach( $dirs as $d ) {
				if( is_dir($path . $d) ) {
					if( @rmdir($path . $d) ) {
						$this->aiInfo("Directory deleted: $path$d", "DeleteDir");
					} else {
						$this->aiWarn("Can't delete directory: $path$d", "DeleteDir");
						return 0;
					}
				}
			}
		}
		
		return 1;
	}
	
	public function deleteDir( $forceDeleted = false, $forceNormal = false ) {
		$this->setPath();
		$path	= Yii::app()->getModule('gallery')->albumPath . $this->dirName . '/';
		$map	= Yii::app()->getModule('gallery')->albumMap;
		
		$this->aiInfo("Deleting directory: $path", "DeleteDir");
		
		foreach( $map['videos'] as $n => $p ) {

			if( $map['deleted'] )
				$this->_delDirSub($path, $map['deleted'].$p, $forceDeleted);
			
			$this->_delDirSub($path, $p, $forceNormal);

		}
		
		foreach( $map['pictures'] as $n => $p ) {

			if( $map['deleted'] )
				$this->_delDirSub($path, $map['deleted'].$p, $forceDeleted);
			
			$this->_delDirSub($path, $p, $forceNormal);

		}
		
		if( @rmdir($path) ) {
			$this->aiInfo("Directory deleted: $path", "DeleteDir");
		} else {
			$this->aiError("Can't delete directory: $path", "DeleteDir");
			return 0;
		}
		
		return 1;
	}
	
	public function setPath() {
		if( $this->stamp_id === null ) {
			$this->aiError("Missing stamp", "SetPath");
			return;
		}
	
		if( $this->stamp->isLectored() ) {
			$this->dirName = sprintf('a%05d', $this->album_id);	// normal
		} else {
			$this->dirName = sprintf('d%05d', $this->album_id);	// draft
		}
		
		$this->fullPath = Yii::app()->getModule('gallery')->albumPath . $this->dirName . '/';
	}
	
	public function getDirName() {
		if( !$this->dirName )
			$this->setPath();
		return $this->dirName;
	}
	
	protected function afterFind()
	{
		$this->setPath();
		
		if($this->hasEventHandler('onAfterFind'))
			$this->onAfterFind(new CEvent($this));
	}
	
	public function save($runValidation=true,$attributes=null)
	{
		if(!$runValidation || $this->validate($attributes))
			if( $this->getIsNewRecord() ) {
				if( $this->insert($attributes) ) {
					if( $this->createDir() ) {
						$this->saveState();
						return true;
					} else {
						if( !( $this->delete() && $this->permaDelete() ) ) {
							$this->aiError("Can't delete corrupt album!", "Save");
						}
						return false;
					}
				} else {
					return false;
				}
			} else {
				return $this->update($attributes);
			}
		else
			return false;
	}

	public function delete()
	{
		return $this->permaDelete();
		
		if(!$this->getIsNewRecord())
		{
			Yii::trace(get_class($this).'.delete()','system.db.ar.CActiveRecord');
			$this->aiInfo("Attempting to delete album", "Delete");
			$this->deleted = new CDbExpression('NOW()');
			if( $this->update('deleted') ) {
				$this->aiInfo("Album deleted", "Delete");
				return true;
			} else {
				$this->aiError("Failed to delete album", "Delete");
				return false;
			}
		}
		else
			throw new CDbException(Yii::t('yii','The active record cannot be deleted because it is new.'));
		
	}

	public function permaDelete() {
		$pk = $this->getPrimaryKey();
		$this->aiInfo("Attempting to permanently delete album...", "PermaDelete");
		$this->saveState();
		if( !$this->deleteDir(true) ) {
			$this->aiWarn("Can't delete directory!", "Album.PermaDelete");
		}
		
		if( $this->aiLogger->flushFromDb('album', $pk) ) {
			if( $this->aiLogger->deleteFromDb('album', $pk) ) {
				if($this->beforeDelete())
				{
					$result = $this->deleteByPk($pk) > 0;
					$this->afterDelete();
					if( $result ) {
						$this->aiInfo("Album permanently deleted!", "PermaDelete");
						return true;
					}
				}
			}
		}
		$this->aiError("Failed to permanently delete album!", "PermaDelete");
		return false;
	}
	
	public function scanDirectory($type = 'pic', $options = null, $createThumbs = false) {
		$module = Yii::app()->getModule('gallery');
		$srcDir = $this->fullPath . ($type == 'pic' ? $module->albumMap['pictures']['src'] : $module->albumMap['videos']['src']);
		$lastImage = Yii::app()->db->createCommand()->select('image_id')->from('image')->order('image_id DESC')->limit(1)->queryScalar();//getLastInsertID(Image::model()->getMetaData()->tableSchema);
		
		$this->aiInfo("Scanning directory $srcDir!", "ScanDirectory");
		
		$files = scandir($srcDir);
		$i = 1;
		foreach( $files as $file ) {
			if( !is_file($srcDir.$file) ) continue;
			if( preg_match( "/([0-9]{8})\.([jpgnifJPGNIF]{3})/", $file, $m ) ) {	// check picture type
				$id = (int)$m[1];
				$ext = strtolower($m[2]);
				$this->aiWarn("$id - $ext - $lastImage", "ScanDirectory");
				if( $id <= $lastImage ) {	// possible existing image
					if(Image::model()->exists("image_id=$id AND extension='$ext'")) {
						$this->aiWarn("Existing file: $file!", "ScanDirectory");
						continue;
					}
				}
			}
			
			$this->aiInfo("Adding new image!", "ScanDirectory");
			$img = new Image();
			$img->original_name = $file;
			$img->album_id = $this->album_id;
			if(is_array($options)) {
				if(array_key_exists('public', $options))	$img->public = $options->public;
				if(array_key_exists('name', $options))		$img->name = $options->name . $i++ . '.';
				//if(array_key_exists('info', $options))		$img->createInfo($options->info);
			}
			if( $img->save() ) {
				if($createThumbs) $img->createThumb();
			} else {
				
				//$this->aiError("Error while saving image: " . implode("\n", $img->getErrors()), "ScanDirectory");
			}
		}
		
	}
	
	public function getImages($public = true) {
		$img = Image::model();
		
		if( $public )
			$img->getDbCriteria()->mergeWith(array('condition' => 't.public=1'));
		
		$img->getDbCriteria()->mergeWith(array('condition' => 't.album_id=' . $this->album_id));
		$img->with('information')->ifState('valid');
		
		return new CActiveDataProvider('Image', array( 'criteria' => $img->getDbCriteria()));
	}
	
	public static function getAlbums($public = true, $sort = 'time', $order = 'DESC') {
		$album = self::model();
		
		if( $public )
			$album->getDbCriteria()->mergeWith(array('condition' => 't.public=1'));
		
		$album->with('information')->ifState('valid');
		
		if($sort == 'time')
			$sort = 'stamp.created_at';
			
		$album->getDbCriteria()->order = "$sort $order";
		
		return new CActiveDataProvider('Album', array( 'criteria' => $album->getDbCriteria()));
	}
}