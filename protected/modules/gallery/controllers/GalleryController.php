<?php

class GalleryController extends Controller
{
	public function actionIndex()
	{
		$this->layout = '/default/layout';
		
		$module = $this->getModule();
		
		$am = new CAssetManager();
		$am->forceCopy = true;	// dev
		$assets = Yii::getPathOfAlias('webroot') . '/protected/modules/gallery/assets/';
		$am->publish($assets);
		$assets = $am->getPublishedUrl($assets) . '/';
		
		
		Yii::app()->clientScript->registerCssFile( $assets . 'css/supersized.css');
		Yii::app()->clientScript->registerCssFile( $assets . 'css/supersized.theme.css');
		Yii::app()->clientScript->registerCssFile( $assets . 'css/gallery.css');
		Yii::app()->clientScript->registerScriptFile( $assets . 'js/ThumbScripts.js', CClientScript::POS_HEAD);
		Yii::app()->clientScript->registerScriptFile( $assets . 'js/supersized.3.2.7.js', CClientScript::POS_HEAD);
		Yii::app()->clientScript->registerScriptFile( $assets . 'js/supersized.theme.js', CClientScript::POS_HEAD);
		Yii::app()->clientScript->registerScriptFile( $assets . 'js/gallery.js', CClientScript::POS_HEAD);
		Yii::app()->clientScript->registerScriptFile( $assets . 'js/jquery.lazy.min.js', CClientScript::POS_HEAD);
		
		
		$albumId = 1;
		if(isset($_GET['album']))
			$albumId = $_GET['album'];
		
		
		$album	= Album::model()->ifState('valid')->findByPk($albumId);
		if( $album === null )
			throw new CHttpException(404,'The requested page does not exist!');
		
		$images	= $album->getImages();
		$albums	= Album::getAlbums();
		
		$images->pagination = false;
		$albums->pagination = false;
		
		$this->render('index',array(
			'images'		=> $images,
			'albums'		=> $albums,
			'album'			=> $album,
			'thumbWidth'	=> $module->thumbWidth,
			'thumbHeight'	=> $module->thumbHeight,
		));
	}

}