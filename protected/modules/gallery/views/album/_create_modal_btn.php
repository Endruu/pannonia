<?php $this->widget(
	'bootstrap.widgets.TbButton',
	array(
		'label'			=> 'Új album',
		'type'			=> 'primary',
		'htmlOptions'	=> array(
			'data-toggle'	=> 'modal',
			'data-target'	=> '#album-create-modal',
		),
	)
);