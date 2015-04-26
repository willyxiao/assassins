	<div class="row">
		<div class="small-8 columns small-centered">
			<h1>Probability of Next Kill</h1>
			<table>
				<thead>
					<tr>
						<th>In X hours</th>
						<th>Probability</th>
					</tr>
				</thead>
				<tbody id="probTBody">
				</tbody>
			</table>
		</div>
	</div>
	<script>
		$(document).ready(function(){
			var alpha = 50.001
			var beta = 3896.786

			function adjust(hour){
				var timeSubtract = 0
				var days = Math.floor(hour / 24)
				timeSubtract += 8*days
				var hours_left = hour % 24
				a = new Date($.now()).getHours()
				d = a + hours_left
				lower = 1
				upper = 10

				timeSubtract += Math.max(0, Math.max(d, upper) - Math.min(a, lower))

				return (hours - timeSubtract)
			}

			function find_prob(hour){
				var prob = (-1*beta^alpha)*(beta+adjust(hour)*<?= $alive ?>)^(-1*alpha) + 1;
				return "<tr><td>" + String(hour) + "</td><td>" + String(prob) + "</td></tr>";
			}

			var hours = [1,2,4,12,24]
			for(n in hours){
				$("#probTBody").append(find_prob(hours[n]))
			}
		})
	</script>
	<div class="row">
		<div class="small-6 large-6 columns">
			<form id="form" action="kill.php" method="POST">
				<input type="text" name="uname" placeholder="@college username"></input>
				<input type="password" name="password" placeholder="Password (sent via email)"></input>
				<input type="submit" class="button"></input>
			</form>
		</div>
		<div class="small-6 large-6 columns">
			<?php require("leaderboard.php"); ?>
		</div>
	</div>
	<div class="row">
		<?php require("kill_story_js_loader.php") ?>
	</div>
</body>
</html>
