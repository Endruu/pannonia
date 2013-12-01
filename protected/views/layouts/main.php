<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/fonts/os/sb/stylesheet.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/fonts/os/reg/stylesheet.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/fonts/os/li/stylesheet.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<?php
	$this->widget('ext.widgets.menu.MenuWidget', array(
		'mainPage'		=> Yii::app()->getHomeUrl(),
		'navigation'	=> Yii::app()->params['navigation'],
		'options'		=> array(
			'above'	=> 100,
			'below'	=> 200
		),
		'forceAssets'	=> true,
	));
?>

<?php echo $content; ?>

<div class="MainRow-Footer">
</div>

</body>
</html>
