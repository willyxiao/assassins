<h3><a href="https://medium.com/@willyxiao/a410d6d76a2d">Predicted Next Kill</a></h3>
<table>
  <thead>
    <tr>
      <th>Within next X hours</th>
      <th>Probability</th>
    </tr>
  </thead>
  <tbody id="probTBody">
  </tbody>
</table>
<table>
  <thead>
    <tr>
      <th>Players Left</th>
      <th>Expected Time</th>
    </tr>
  </thead>
  <tbody id="eTBody">
  </tbody>
</table>
<script>
  $(document).ready(function(){
    var alive = <?= $alive ?>

    var alpha = 92.001
    var beta = 7023.411

    function adjust(hour){
      var timeSubtract = 0
      var days = Math.floor(hour / 24)
      timeSubtract += 8*days
      var hours_left = hour % 24
      a = new Date($.now()).getHours()
      d = a + hours_left

      lower = 1
      upper = 10

      lower1 = 25
      upper1 = 34

      timeSubtract += (8/9)*Math.max(0, Math.min(d, upper) - Math.max(a, lower))
      timeSubtract += (8/9)*Math.max(0, Math.min(d, upper1) - Math.max(a, lower1))

      return (hour - timeSubtract)
    }

    function find_prob(hour){
      var prob = (-1*Math.exp(alpha*Math.log(beta)-1*alpha*Math.log(beta+adjust(hour)*(alive))) + 1);
      return "<tr><td>" + String(hour) + "</td><td>" + String(prob).substring(0,5) + "</td></tr>";
    }

    var hours = [1,2,4,8,12,24]
    for(n in hours){
      $("#probTBody").append(find_prob(hours[n]))
    }


    var post_mean = beta/alpha
    var expected_times = []
    var total_expected_times = []
    var total_sum = 0
    for(n = alive; n > 0; n--){
      total_sum += post_mean/n
      expected_times[expected_times.length] = post_mean/n
      total_expected_times[total_expected_times.length] = total_sum
    }

    function addMinutes(date, minutes) {
        return new Date(date.getTime() + minutes*60000);
    }

    var hourModel = []
    for(realHours = 0; realHours < 200; realHours++){
      hourModel[hourModel.length] = [realHours, adjust(realHours)]
    }

    function getRealHours(adjHours){
      for(i in hourModel){
        if(hourModel[i][1] > adjHours){
          return hourModel[i][0]
        }
      }
    }

    var playersLeft = [15, 10, 5, 1]
    for(n in playersLeft){
      if(playersLeft[n] < alive){
        $("#eTBody").append("<tr><td>"
          + playersLeft[n].toString().substring(0,5) + "</td><td>"
          + addMinutes(new Date($.now()),
                      getRealHours(total_expected_times[(alive - playersLeft[n] - 1)])*60).toLocaleString()
          + "</td></tr>")
      }
    }
  })
</script>
