<?php
/* @var $this AlbumController */
/* @var $model Album */

$this->breadcrumbs=array(
	'Albums'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Album', 'url'=>array('index')),
	array('label'=>'Manage Album', 'url'=>array('admin')),
);
?>

<?php
	$form = $this->beginWidget(
		'bootstrap.widgets.TbActiveForm',
		array(
			'id' => 'album-creation',
			'type' => 'inline',
			//'htmlOptions' => array('class' => 'well'), // for inset effect
		)
	);
?>
 
<fieldset>
 
	<legend>Új album:</legend>
	
	<?php
		echo $form->textFieldRow(
			$model,
			'name',
			array(
				'height' => 29,					// elcsúszás miatt
				'style'	=> 'margin-top: -23px;'	// elcsúszás miatt
			)
		);
	?>
	
	<?php
		echo $form->toggleButtonRow(
			$model,
			'public',
			array(
				'options' => array(
					'enabledLabel'	=> 'Publikus',
					'disabledLabel'	=> 'Privát',
					'width'			=> 150,
					'height'		=> 29,		// elcsúszás miatt
				),
				'label'	=> false,
			)
		);
	?>

</fieldset>

<div class="form-actions">

	<?php
		$this->widget(
			'bootstrap.widgets.TbButton',
			array(
				'buttonType' => 'submit',
				'type'		=> 'primary',
				'label'		=> 'Létrehoz',
			)
			
		);
	?>
	
</div>
	
<?php
$this->endWidget();
unset($form);

