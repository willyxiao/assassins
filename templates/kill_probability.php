<h1>Next Kill</h1>
<table>
  <thead>
    <tr>
      <th>Within next x hours</th>
      <th>Probability</th>
    </tr>
  </thead>
  <tbody id="probTBody">
  </tbody>
</table>
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

      timeSubtract += (8/9)*Math.max(0, Math.min(d, upper) - Math.max(a, lower))

      return (hour - timeSubtract)
    }

    function find_prob(hour){
      var prob = (-1*Math.pow(beta,alpha))*Math.pow(beta+adjust(hour)*<?= $alive ?>,-1*alpha) + 1;
      return "<tr><td>" + String(hour) + "</td><td>" + String(prob).substring(0,5) + "</td></tr>";
    }

    var hours = [1,2,4,12,24]
    for(n in hours){
      $("#probTBody").append(find_prob(hours[n]))
    }
  })
</script>
