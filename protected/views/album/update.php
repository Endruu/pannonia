<?php
/* @var $this AlbumController */
/* @var $model Album */

$this->breadcrumbs=array(
	'Albums'=>array('index'),
	$model->name=>array('view','id'=>$model->album_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Album', 'url'=>array('index')),
	array('label'=>'Create Album', 'url'=>array('create')),
	array('label'=>'View Album', 'url'=>array('view', 'id'=>$model->album_id)),
	array('label'=>'Manage Album', 'url'=>array('admin')),
);
?>

<h1>Update Album <?php echo $model->album_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>