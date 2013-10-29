<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List User', 'url'=>array('index')),
	array('label'=>'Manage User', 'url'=>array('admin')),
);
?>

<?php
	$form = $this->beginWidget(
		'bootstrap.widgets.TbActiveForm',
		array(
			'id' => 'user-registration',
			'type' => 'horizontal',
			//'htmlOptions' => array('class' => 'well'), // for inset effect
		)
	);
?>
 
<fieldset>
 
	<legend>Regisztráció</legend>
	
	<?php
		echo $form->textFieldRow(
			$model,
			'nick'
		);
	?>
	
	 <?php
		echo $form->textFieldRow(
			$model,
			'name'
		);
	?>

</fieldset>
 
<div class="form-actions">
	<?php
		$this->widget(
			'bootstrap.widgets.TbButton',
			array(
				'buttonType' => 'submit',
				'type' => 'primary',
				'label' => 'Submit'
				)
		);
	?>
</div>

<?php
$this->endWidget();
unset($form);