<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<div class="MainSplash-Container CenterMinWidth">
	<div class="MainSplash-Inner CenterMaxWidth CenterMinWidth">
		<div class="MainSplash-Title">
			<h1>PANNÓNIA NÉPTÁNCEGYÜTTES</h1>
			<h2>Kistarcsa</h2>
		</div>

		<div class="MainSplash-Logo">
		</div>
	</div>
</div>

<div class="MainRow MainRow-Odd CenterMinWidth">
	<div class="CenterMaxWidth CenterMinWidth">
		<div class="MainRow-Title">
			<h3>Az Együttesről</h3>
		</div>
		
		<div class="MainRow-Content">
			<p>
				A Pannónia Néptáncegyüttes 1992-ben alakult Kistarcsán. Jelenleg <strong>hat csoportban</strong> (Pöttöm, Gyerek, Ifjúsági, Felnőtt, Hagyományőrző, Szüvellő) közel <strong>150 táncos</strong> ismerkedik a népi kultúra hagyományaival.
			</p>
			<p>
				A táncegyüttes <strong>elsődleges célja</strong>, hogy a <strong>magyar népi kultúra, a néptánc hagyományainak átadásával, bemutatásával</strong> olyan kereteket teremtsünk az ifjúság számára, amelyben megtalálhatja a helyét, felfedezheti a közösséghez tartozás érzésének nagyszerűségét. 
			</p>
			<p>
				Csoportjaink arra törekszenek, hogy a Kárpát-medence nagy részéről tudjanak táncokat bemutatni.Így Somogytól Moldváig, Magyarbődtől Méhkerékig számos tájegység táncával ismerkedtünk már meg, állítottuk azt színpadra. A felnőtt csoport repertoárján bonchidai, illetve kalotaszegi román, magyarszováti, vajdaszentiványi, Küküllő menti, marosmagyarói, Kistarcsa környéki szlovák, sárközi, mezőföldi, domaházi táncanyagok szerepelnek. Szerkesztett műsoraink közül az „Én országom Moldova…” emelkedik ki, melyben a moldvai csángó magyarság tánchagyományát, kultúráját mutatjuk be.
			</p>
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
