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

