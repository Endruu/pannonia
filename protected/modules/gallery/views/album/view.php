<?php
/* @var $this AlbumController */
/* @var $model Album */

$this->breadcrumbs=array(
	'Albums'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Album', 'url'=>array('index')),
	array('label'=>'Create Album', 'url'=>array('create')),
	array('label'=>'Update Album', 'url'=>array('update', 'id'=>$model->album_id)),
	array('label'=>'Delete Album', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->album_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Album', 'url'=>array('admin')),
);
?>

<h1>View Album #<?php echo $model->album_id; ?></h1>
<?php echo date("Y-m-d H:i:s", microtime(true)); ?>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'album_id',
		'name',
		'stamp_id',
		'public',
	),
)); ?>
