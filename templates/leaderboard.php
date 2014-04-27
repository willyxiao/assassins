<?php
	$leaderboard = query("SELECT name, count(*) as kills FROM killstory JOIN users ON users.userid=killer WHERE is_kill_story = 1 GROUP BY killer ORDER BY kills DESC"); 
?>
<table>
	<thead>
		<th>Name</th>
		<th>Kills</th>
	</thead>
	<tbody>
		<?php foreach($leaderboard as $item): ?>
		<tr>
			<td><?= htmlspecialchars($item["name"]) ?></td>
			<td><?= htmlspecialchars($item["kills"]) ?></td>
		</tr>
		<?php endforeach; ?>
	<tbody>
</table>
