<?php
$this->widget(
	'bootstrap.widgets.TbButton',
	array(
		'buttonType' => 'submit',
		'type'		=> 'primary',
		'label'		=> 'Létrehoz',
		'url'		=> Yii::app()->createUrl('album/createModal'),
		'ajaxOptions' => array(
			'update' => '.modal-body'
		)
	)
);