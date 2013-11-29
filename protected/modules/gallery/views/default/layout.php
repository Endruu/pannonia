<?php /* @var $this Controller */ ?>
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<link href="//fonts.googleapis.com/css?family=Open+Sans Condensed:300italic,300,700&subset=latin-ext" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="css/fonts/os/sb/stylesheet.css" />
	<link rel="stylesheet" type="text/css" href="css/fonts/os/reg/stylesheet.css" />
	<link rel="stylesheet" type="text/css" href="css/fonts/os/li/stylesheet.css" />
	

	
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
			'fixed'			=> true,
		));
	?>

	<?php echo $content; ?>
	
	
</body>
</html>
