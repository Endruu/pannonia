<?php
/* @var $this AlbumController */
/* @var $model Album */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'album-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'stamp_id'); ?>
		<?php echo $form->textField($model,'stamp_id'); ?>
		<?php echo $form->error($model,'stamp_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'public'); ?>
		<?php echo $form->textField($model,'public'); ?>
		<?php echo $form->error($model,'public'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->