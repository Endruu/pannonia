<?php
/* @var $this AlbumController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Albums',
);

$this->menu=array(
	array('label'=>'Create Album', 'url'=>array('create')),
	array('label'=>'Manage Album', 'url'=>array('admin')),
);
?>

<h1>Albums</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>


<?php $this->renderPartial("_create_modal"); ?>
<?php $this->renderPartial("_create_modal_btn"); ?>