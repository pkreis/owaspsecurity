<form action="vulnerabilities/a9/a9-lesson/counter1.0.php?action=getdaycounter" method="post">
  <select name="date" id="date">
    <?php foreach($dates as $d):?>
    <option value="<?php echo $d['data']?>"><?php echo $d['data']?></option>
    <?php endforeach; ?>
  </select>
  <br>
  <input type="submit" value="Sprawdź">
</form>