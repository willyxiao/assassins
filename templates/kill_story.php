<?php 
	$killstories = query("SELECT story, TIME(ADDTIME(time, '3:0:0.0')) as time2  FROM killstory WHERE is_kill_story=1 ORDER BY time DESC"); 
	$deathstories = query("SELECT story, TIME(ADDTIME(time, '3:0:0.0')) as time2 FROM killstory WHERE is_kill_story != 1 ORDER BY time DESC"); 
?>
<div class="row">
	<div class="small-6 large-6 columns">
	<table>
	  <thead>
	    <tr>
	      <th>Time</th>
	      <th width="400">Kill Story</th>
	    </tr>
	  </thead>
	  <tbody>
	  	<?php foreach($killstories as $killstory) :?>
		<tr>
			<td><?= htmlspecialchars($killstory["time2"]) ?></td>
			<td><?= htmlspecialchars(stripslashes($killstory["story"])) ?></td>
		</tr>
		<?php endforeach; ?>
	  </tbody>
	</table>
	</div>
	<div class="small-6 large-6 columns">
	<table>
	  <thead>
	    <tr>
	      <th>Time</th>
	      <th width="400">Death Story</th>
	    </tr>
	  </thead>
	  <tbody>
	  	<?php foreach($deathstories as $killstory) :?>
		<tr>
			<td><?= htmlspecialchars($killstory["time2"]) ?></td>
			<td><?= htmlspecialchars(stripslashes($killstory["story"])) ?></td>
		</tr>
		<?php endforeach; ?>
	  </tbody>
	</table>
	</div>
</div>
