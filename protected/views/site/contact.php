<div class="MainRow MainRow-Odd CenterMinWidth MainRow-First">
	<div class="CenterMaxWidth CenterMinWidth">
		<div class="MainRow-Title">
			<h3>Elérhetőségek</h3>
		</div>
		
		<div class="MainRow-Content">
			<div class="Contact-Person Contact-Ensemble">
				<h3>Pannónia Néptáncegyüttes</h3>
				<h4>Kistarcsa</h4>
				<div class="Contact-Adress">
					<span class="Contact-Adress-Label">cím</span> <span class="Contact-Adress-Value">2143 Kistarcsa, Széchenyi út 33.</span>
				</div>
				<div class="Contact-Mail">
					<span class="Contact-Mail-Label">e-mail</span> <span class="Contact-Mail-Name">info</span><span class="Contact-Mail-At">&#64;</span><span class="Contact-Mail-Domain">pannoniafolk.hu</span>
				</div>
				<div class="Contact-Tribute">
					<span class="Contact-Tribute-Label">1%</span> <span class="Contact-Tribute-Value">18674712-1-13</span>
				</div>
			</div>
				
			<?php foreach( $people as $p ): ?>
			<div class="Contact-Person">
				<h3><?php echo $p['name']; ?></h3>
				<h4><?php echo $p['title']; ?></h4>
				<div class="Contact-Mail">
					<span class="Contact-Mail-Name"><?php echo $p['mail']; ?></span><span class="Contact-Mail-At">&#64;</span><span class="Contact-Mail-Domain">pannoniafolk.hu</span>
				</div>
			</div>
			<?php endforeach; ?>
			
			<div class="ClearFix"></div>
		</div>
		
	</div>
</div>

<div class="MainRow MainRow-Even CenterMinWidth">
	<div id="Main-Groups" class="CenterMaxWidth CenterMinWidth MainRow-Taller">
		<div class="MainRow-Title ParallelDiv PD-2">
			<h3>Próbák</h3>
		</div>
		
		<div class="MainRow-Content ParallelDiv PD-8">
			<?php $this->renderPartial('_group_index'); ?>
		</div>
		
		<div class="ClearFix"></div>
		
	</div>
</div>

<div class="MainRow MainRow-Odd CenterMinWidth Contact-Place">
	<div class="CenterMaxWidth CenterMinWidth">
		
		
		<div class="ParallelDiv PD-5">
			<div class="Contact-Place-Left">
				<div class="Contact-Place-Info">
					<h3>Csigaház</h3>
					2143 Kistarcsa<br />
					Batthyány utca 4
				</div>
				<a target="_blank" href="http://maps.google.hu/maps/ms?msid=208674042497114163641.0004b21968fa9a3216ae8&msa=0&ll=47.547661,19.260235&spn=0.0042,0.009645">
					<img src="http://maps.googleapis.com/maps/api/staticmap?center=47.54693,19.260256&zoom=15&size=400x350&format=gif&markers=color:red|47.547661,19.260235&sensor=false">
				</a>
			</div>
		</div>

		<div class="ParallelDiv PD-5">
			<div class="Contact-Place-Right">
				<a target="_blank" href="https://maps.google.hu/maps/ms?msid=208674042497114163641.0004ec809e028b9427976&msa=0&ll=47.5427,19.267&spn=0.006634,0.016512">
					<img src="http://maps.googleapis.com/maps/api/staticmap?center=47.544,19.2645&zoom=15&size=400x350&format=gif&markers=color:blue|47.5427,19.267&sensor=false">
				</a>
				<div class="Contact-Place-Info">
					<h3>Civil-ház</h3>
					2143 Kistarcsa<br />
					Széchenyi út 33
				</div>
			</div>
		</div>
		
		<div class="ClearFix"></div>
		
	</div>
</div>
	