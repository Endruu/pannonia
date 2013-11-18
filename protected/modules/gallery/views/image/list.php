<div class="Image-ListContainer">

	<?php $this->widget('zii.widgets.CListView', array(
		'dataProvider'		=> $dataProvider,
		'itemView'			=> '_thumbnail',
		'enablePagination'	=> false,
	)); ?>
	
</div>

<?php echo CHtml::script("var ts = new ThumbScripts({width: $thumbWidth, height: $thumbHeight}); ts.afterLoad();"); ?>