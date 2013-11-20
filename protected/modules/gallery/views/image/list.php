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
	<!--Arrow Navigation-->
	<a id="prevslide" class="load-item"></a>
	<a id="nextslide" class="load-item"></a>
</div>


<?php echo CHtml::script("initTS({width: $thumbWidth, height: $thumbHeight});"); ?>