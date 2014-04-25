<div class="row">
	<?php
		$stories = query("SELECT story, time FROM killstory ORDER BY time DESC LIMIT 3"); 
		$killstory1 = $stories[0]["story"];
		$killtime1 = $stories[0]["time"]; 
		$killstory2 = $stories[1]["story"];
		$killtime2 = $stories[1]["time"]; 
		$killstory3 = $stories[2]["story"];
		$killtime3 = $stories[3]["time"];   
	?>

	<div class="small-4 large-4 columns">
		<h1>Kill story #1</h1>
		<p>At <?= htmlspecialchars($killtime1) ?></p>
		<p>
		<?= htmlspecialchars($killstory1) ?>
		</p>
	</div>
	<div class="small-4 large-4 columns">
		<h1>Kill story #2</h1>
		<p>At <?= htmlspecialchars($killtime2) ?> </p>
		<p>
		<?= htmlspecialchars($killstory2) ?>
		</p>
	</div>
	<div class="small-4 large-4 columns">
		<h1>Kill story #3</h1>
		<p>At <?= htmlspecialchars($killtime3) ?></p>
		<p>
		<?= htmlspecialchars($killstory3) ?>
		</p>
	</div>
</div>
