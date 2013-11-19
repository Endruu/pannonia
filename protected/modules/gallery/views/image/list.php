<div class="Image-Gallery-Container">

	<div class="Image-Album-List-Container">
	</div>

	<div class="Image-List-Container">

		<?php $this->widget('zii.widgets.CListView', array(
			'dataProvider'		=> $dataProvider,
			'itemView'			=> '_thumbnail',
			'enablePagination'	=> false,
		)); ?>
		
	</div>

</div>

<div class="Image-Viewer-Container">
</div>

<?php echo CHtml::script("var ts = new ThumbScripts({width: $thumbWidth, height: $thumbHeight}); ts.afterLoad();"); ?>