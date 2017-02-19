<h3> Lista wiadomości </h3>
<form method="get" action="vulnerabilities/injection/sqli-lesson2/index.php">
  <select name="cat">
    <option value="">Wszystkie</option>
    <?php
      foreach($categories as $c => $value):
        if(isset($_REQUEST['cat']) && $_REQUEST['cat'] == $c) $selected = 'selected = "selected"';
        else $selected = '';
        echo "<option value='$c' $selected>$value</option>";
      endforeach;
    ?>
  </select>
  <input type="submit" value="Wybierz" class="btn" style='vertical-align:top'>
</form>

<ul>
<?php
  foreach($data as $n):
    echo '<li>' .  $n['Tytul'];
  endforeach;
?>
</ul>