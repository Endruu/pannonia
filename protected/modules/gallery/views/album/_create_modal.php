<?php $this->beginWidget(
	'bootstrap.widgets.TbModal',
	array(
		'id'			=> 'album-create-modal',
		'options'		=> array(
			'keyboard'	=> false,
			'backdrop'	=> 'static',
			'remote'	=> Yii::app()->createUrl('album/createModal'),
		)
	)
); ?>

<div class="modal-header">
	<h4>Új album</h4>
</div>
 
 
<div class="modal-body">

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