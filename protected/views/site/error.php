<div class="error-container">
	<div class="error-inner">
		<a href="http://pannoniafolk.hu">
			<img src="css/images/logo.png" alt="" />
		</a>
		<div class="error-text">
			<h1><?php echo $code;?></h1>
			<h2>
				<?php
					switch ($code) {
						case 401:
							  echo "Jogosulatlan kérés!";
							  break;
						case 403:
							  echo "Tiltott oldal!";
							  break;
						case 404:
							  echo "Hiányzó oldal!";
							  break;
						case 500:
							  echo "Szerver hiba!";
							  break;
				}?>
			</h2>
		</div>
		<?php if(defined('YII_DEBUG') && YII_DEBUG === true): ?>
			<div class="error-additional">
				<hr />
				<?php echo $type; ?>
				<hr />
				 <?php echo substr($file, strlen(Yii::getPathOfAlias('webroot'))+1); ?>::<?php echo $line; ?>
				<hr />
				<?php echo nl2br($message); ?>
				<hr />
				<?php echo nl2br($trace); ?>
				<?php if(isset($source)) {
					echo '<hr />' . nl2br($source);
				}?>
			</div>
		<?php endif; ?>
	</div>
</div>