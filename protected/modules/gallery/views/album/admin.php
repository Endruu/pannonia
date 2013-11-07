<?php
/* @var $this AlbumController */
/* @var $model Album */

$this->breadcrumbs=array(
	'Albums'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Album', 'url'=>array('index')),
	array('label'=>'Create Album', 'url'=>array('create')),
);

?>

<h1>Albumok - Admin</h1>

<?php

$gridColumns = array(
	array('name'=>'album_id', 'header' => 'A#', 'htmlOptions' => array('style' => 'width: 50px')),
	array('name'=>'name', 'header' => CHtml::activeLabel($model, 'name')),
	array(
		'name'		=> 'public',
		'header'	=> CHtml::activeLabel($model, 'public'),
		'class'		=> 'bootstrap.widgets.TbToggleColumn',
		'checkedButtonLabel'	=> 'Publikus',
		'uncheckedButtonLabel'	=> 'Privát',
		'toggleAction'			=> 'ignore',
		'htmlOptions'			=> array('style' => 'width: 70px')
	),
	array(
		'name'=>'stamp.created_at',
		'header' => CHtml::activeLabel(Stamp::model(), 'created_at')
	),
	array(
		'htmlOptions' => array('nowrap'=>'nowrap'),
		'class'=>'bootstrap.widgets.TbButtonColumn',
	)
);

$this->widget(
	'bootstrap.widgets.TbExtendedGridView',
	array(
		//'filter' => $person,
		'fixedHeader' => true,
		'type' => 'striped bordered',
		//'headerOffset' => 40,
		// 40px is the height of the main navigation at bootstrap
		'dataProvider' => $model->search(),	// kontrollerbe!
		'template' => "{items}",
		'columns' => $gridColumns,
	)
);