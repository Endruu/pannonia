<div	class="Image-Album-MainContainer <?php if($data->album_id == $activeId) echo 'Image-Album-Active'; ?>"
		id="album-<?php echo $data->album_id; ?>"
>
	<a class="Album-Name" href="<?php echo CHtml::normalizeUrl(array('', 'album' => $data->album_id)); ?>">
		<?php echo CHtml::encode($data->name); ?>
	</a>
</div>
