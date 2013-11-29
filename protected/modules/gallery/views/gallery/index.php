<div class="Image-Gallery-Background"></div>

<div class="Image-Gallery-Container">

	<div class="Image-Album-List-Container">
	
		<?php $this->widget('zii.widgets.CListView', array(
			'dataProvider'		=> $albums,
			'itemView'			=> '_album',
			'enablePagination'	=> false,
			'viewData'			=> array(
				'activeId'	=> $album->album_id,
			)
		)); ?>
	
	</div>
	
	<div class="Image-DividerStrip" ></div>
	
	<div class="Image-List-Container">

		<?php $this->widget('zii.widgets.CListView', array(
			'dataProvider'		=> $images,
			'itemView'			=> '_thumbnail',
			'enablePagination'	=> false,
			'emptyText'			=> '',
			'viewData'			=> array(
				'albumName'	=> $album->name,
				'albumDir'	=> $album->getDirName(),
			)
		)); ?>
		
	</div>

</div>

<div class="Image-Viewer-Container">
	<!--Arrow Navigation-->
	<a id="close" class="load-item"></a>
	<a id="prevslide" class="load-item"></a>
	<a id="nextslide" class="load-item"></a>
</div>


<?php echo CHtml::script("initTS({width: $thumbWidth, height: $thumbHeight});"); ?>