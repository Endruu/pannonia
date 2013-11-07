<span id='album-id' style='display: none;'><?php echo $data->album_id; ?></span>

<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
<?php echo CHtml::encode($data->name); ?>
<br />

<b><?php echo CHtml::encode($data->getAttributeLabel('stamp_id')); ?>:</b>
<?php echo CHtml::encode($data->stamp_id); ?>
<br />

<b><?php echo CHtml::encode($data->getAttributeLabel('public')); ?>:</b>
<?php echo CHtml::encode($data->public); ?>
<br />
