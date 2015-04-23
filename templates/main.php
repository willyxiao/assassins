	<?php
		$user = $user[0];
		$target = query("SELECT * FROM users WHERE userid=?", $user["to_kill"]); 
		$target = $target[0];
	?>
	<div style="text-align: center">
	<h1>
		Your next target is <?= $target["name"] ?>
	</h1>
	<h3>
		NOTICE!!! REPORT YOUR KILLS BEFORE YOUR DEATH!!!
	</h3>
	<script>
		function color(id) {
			$("#" + id).prop("disabled", true); 
		}
		$(document).ready(function() {
			<?= ($user["kill"] == 1) ? "color('killed');" : "" ?>
			<?= ($user["dead"] == 1) ? "color('dead');" : "" ?>
			function reset() {
				location.reload(); 
			}

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
						story: $("#killstory").val(), 
					}, 
					success: function() {reset()}, 
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
						story: $("#deathstory").val(), 
					}, 
					success: function() {reset()}, 
					error: function() {alert("there was an error! email wxiao@college...");}, 
				})
			}); 
		}); 
	</script>
	<form>
	<?php if($user["killed"] != 1): ?>
	<div class="row">
    		<div class="large-12 columns">
     		<label>Kill Story
        		<textarea id="killstory" placeholder="15 hours later, Kevin entered the dhall..."></textarea>
      		</label>
    		</div>
  	</div>
	<a href="#" id="kill" class="button">Killed My Target</a>

	<div style="height: 20px"></div>
	<?php if($target["dead"] != 1): ?>
	<div class="row">
    		<div class="large-12 columns">
      		<label>My Obituary
        		<textarea id="deathstory" placeholder="One day, I was answering some calls for scas..." ></textarea>
      		</label>
    		</div>
  	</div>
	<a href="#" id="dead" class="button">I got wasted</a>
	<?php else: ?>
		<p> Your target claims to have been killed. Please write your kill story and report it! </p>
	<?php endif; ?>
	</form>
	<?php else: ?>
		<p> You've already killed your target, awaiting confirmation from them...before you can do anything else. </p>
	<?php endif; ?>
	</div>

<script src="js/vendor/jquery.js"></script>
  <script src="js/foundation.min.js"></script>
  <script>
    $(document).foundation();
  </script>

	<?php require("kill_story_js_loader.php") ?>
</body>
</html>
