<?php
  $user = $user[0];
  $deathstory = query("SELECT * FROM killstory WHERE dead=? AND is_kill_story=1", $user["userid"]);
  $deathstory = (count($deathstory) < 1);
?>
<div style="text-align: center">
  <h1>You walked too close to the light...</h1>
  <iframe width="560" height="315" src="//www.youtube.com/embed/nQ3yHCrditg" frameborder="0" allowfullscreen></iframe>
  <div style="padding-top: 10px">
    <a target="_blank" href="http://www.huffingtonpost.com/2011/06/23/what-happen-when-we-die_n_882738.html#s296717title=There_Is_An">Here's More.</a>
  </div>
  <?php if(!$deathstory): ?>
    <script>
      $(document).ready(function(){
        $("#dead").click(function() {
          function reset() {
            location.reload();
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
      })
    </script>
    <div class="row">
          <div class="large-12 columns">
            <label>My Obituary
              <textarea id="deathstory" placeholder="One day, I was answering some calls for scas..." ></textarea>
            </label>
          </div>
      </div>
    <a href="#" id="dead" class="button">I got wasted</a>
  <?php endif; ?>
  <div style="height: 50px"></div>
  <?php require("kill_story_js_loader.php") ?>
</div>

</body>
</html>
