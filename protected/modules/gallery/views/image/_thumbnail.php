<div class="Image-Thumbnail-MainContainer" id="img-thumb-<?php echo $data->image_id; ?>">

	<div class="Image-Hover-Layer"></div>
	<div class="Image-Hover-Leaving"></div>
	<div class="Image-Select-Layer">
		<input type="checkbox" name="Image-Select-Id" class="Image-Select-Checkbox Image-Checkbox-Hide" value="<?php echo $data->image_id; ?>">
	</div>

	<div class="Image-Thumbnail-Container">
		<img class="Image-Thumbnail" src="<?php echo $data->getThumbnail(true); ?>"/>
		<span class="Image-SourcePath"><?php echo $data->getImage(true); ?></span>
	</div>
	
	<div class="Image-Info-Container">
		<h2 class="Image-Name"><?php echo CHtml::encode($data->name); ?></h2>
		<?php if($data->public == false) echo '<span class="Image-Private"></span>'; ?>
		<h3 class="Image-Album"><?php echo CHtml::encode($data->album->name); ?></h3>	<!--js modal info -->
		<?php
			if( $data->ai_info_id ) {
				if( $data->aiInfo->take_author )
					echo '<span class="Image-Creator">' . CHtml::encode($data->aiInfo->take_author) . '</span>';
				if( $data->aiInfo->take_place )
					echo '<span class="Image-Place">' . CHtml::encode($data->aiInfo->take_place) . '</span>';
				if( $data->aiInfo->take_time )
					echo '<span class="Image-Time">' . CHtml::encode($data->aiInfo->take_time) . '</span>';
			}
		?>
	</div>
	
</div>
