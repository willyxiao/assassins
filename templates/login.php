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
