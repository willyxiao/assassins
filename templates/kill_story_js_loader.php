<div id="story-container" class="row">
</div>
<script>	
	!(function() {
		var container = $("#story-container"); 
		container.html("<img src='http://celestion.com/images/ajax-loader.gif'></img>"); 
		$.ajax({
			url: "kill_story.php", 
			success: function(r) {
				setTimeout(function() {container.html(r)}, 1000); 
			}
		}); 
	})(); 

</script>
