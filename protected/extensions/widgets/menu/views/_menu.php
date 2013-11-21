<!-- Menu start -->

<?php
	echo CHtml::link(
		CHtml::image($path .'/logo_little.png', 'Főoldal'),
		$this->mainPage,
		array ( 'class' => 'MainNavigation-Logo-Fix' )
	);
?>
	
<div class="MainNavigation-Container-Placeholder"></div>
<div class="MainNavigation-Container">
	<?php
		echo CHtml::link(
			CHtml::image($path .'/logo_little.png', 'Főoldal'),
			$this->mainPage,
			array ( 'class' => 'MainNavigation-Logo' )
		);
	?>
	
	<a class="MainNavigation-Logo-Placeholder"></a>
	
	<?php
		foreach( $this->navigation as $text => $url ) {
			echo CHtml::link($text, $url, array ( 'class' => 'MainNavigation-Button' ) );
		}
	?>
</div>

<?php
	echo CHtml::script(
		'$(activateMenu({' . $this->jsOptions() . '}))'
	);
?>


<!-- Menu end -->
