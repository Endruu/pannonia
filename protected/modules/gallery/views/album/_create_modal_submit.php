<?php
$this->widget(
	'bootstrap.widgets.TbButton',
	array(
		'buttonType' => 'submit',
		'type'		=> 'primary',
		'label'		=> 'Létrehoz',
		'url'		=> Yii::app()->createUrl('gallery/album/createModal'),
		'ajaxOptions' => array(
			'update' => '.modal-body'
		)
	)
);