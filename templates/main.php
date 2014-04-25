<html>
<head>
	<title><?= "Assassin" ?></title>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
</head>
<body>
	<?php
		$user = $user[0];
		$target = query("SELECT * FROM users WHERE userid=?", $user["to_kill"]); 
		$target = $target[0];
	?>

	Your next target is <?= $target["name"] ?>
	<script>
		function color(id) {
			$("#" + id).prop("disabled", true); 
		}
		$(document).ready(function() {
			<?= ($user["kill"] == 1) ? "color('killed');" : "" ?>
			<?= ($user["dead"] == 1) ? "color('dead');" : "" ?>
			$("#kill").click(function() {
				if (!confirm("You sure you killed the target?")) {
					return; 
				}

				$.ajax({
					url: "action.php", 
					type: "post", 
					data: {
						action: "kill", 
						hash: "<?= $user["password"] ?>", 
						userid: "<?= $user["userid"] ?>", 
						story: $("#killstory").value(), 
					}, 
					success: function() {color("kill"); }, 
					error: function() {alert("there was an error! emal wxiao@college...");}
				})
			}); 
			$("#dead").click(function() {
				if (!confirm("You sure you're dead? There's no turning back...")) {
					return; 
				}

				$.ajax({
					url: "action.php", 
					type: "post", 
					data: {
						action: "dead", 
						hash: "<?= $user["password"] ?>", 
						userid: "<?= $user["userid"] ?>", 
						story: $("#deathstory").value(), 
					}, 
					success: function() {color("dead"); }, 
					error: function() {alert("there was an error! email wxiao@college...");}, 
				})
			}); 
		}); 
	</script>
	<textarea rows="5" cols="5" id="killstory">Tell your kill story here...</textarea>
	<input id="kill" type="button" value="Killed"></input>
	<textarea rows="5" cols="5" id="deathstory">Write your obituary here...</textarea>
	<input id="dead" type="button" value="I Died"></input>
	
</body>
</html>
