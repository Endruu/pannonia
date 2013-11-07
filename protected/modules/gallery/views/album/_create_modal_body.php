<span id='album-id'></span>

<?php
	$form = $this->beginWidget(
		'bootstrap.widgets.TbActiveForm',
		array(
			'id' => 'album-creation',
			'type' => 'inline',
		)
	);
?>
 
<fieldset id='album-creation-fieldset'>
<?php
	echo $form->textFieldRow(
		$model,
		'name',
		array(
			'height' => 29,					// elcsúszás miatt
			'style'	=> 'margin-top: -23px;'	// elcsúszás miatt
		)
	);

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

<?php
	$this->renderPartial(
		'_create_modal_submit',
		array(),
		false,		// echo
		false	// postProcess
	);
?>

<?php
	$this->endWidget();
	unset($form);
?>
