<?php $this->beginWidget(
	'bootstrap.widgets.TbModal',
	array(
		'id'			=> 'album-create-modal',
		'autoOpen'		=> true,
		'options'		=> array(
			'keyboard'	=> false,
			'backdrop'	=> 'static',
			//'remote'	=> Yii::app()->createUrl('gallery/album/createModal'),
		)
	)
); ?>

<div class="modal-header">
	<h4>Új album</h4>
</div>
 
 
<div class="modal-body">
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
	$this->widget(
		'bootstrap.widgets.TbButton',
		array(
			'buttonType' => 'ajaxSubmit',
			'type'		=> 'primary',
			'label'		=> 'Létrehoz',
			'url'		=> Yii::app()->createUrl('gallery/album/createModal'),
			'ajaxOptions' => array(
				'update' => '#modcont'
			)
		)
	);
?>

<?php
	$this->endWidget();
	unset($form);
?>
</div>

 
 
<div class="modal-footer">
<?php
	
	$this->widget(
		'bootstrap.widgets.TbButton',
		array(
			'label'		=> 'Kész',
			'disabled'	=> true,
			'url'		=> '#',	// ide kell!
			'htmlOptions' => array('data-dismiss' => 'modal'),
		)
	);
	
	$this->widget(
		'bootstrap.widgets.TbButton',
		array(
			'label' => 'Mégse',
			'url' => '#',	// ide kell!
			'htmlOptions' => array('data-dismiss' => 'modal'),
		)
	);
?>
</div>
 
<?php $this->endWidget(); ?>