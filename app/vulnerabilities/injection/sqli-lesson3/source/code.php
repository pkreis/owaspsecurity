<h3> Ilość wiadomości </h3>
<form method="get" action="vulnerabilities/injection/sqli-lesson3/index.php">
  <select name="cat">
    <?php
      foreach($categories as $c => $value):
        if(isset($_REQUEST['cat']) && $_REQUEST['cat'] == $c){
          $selected = 'selected = "selected"';
          $selectedCat = $value;
        }
        else {
            $selected = '';
        }
        echo "<option value='$c' $selected>$value</option>";
      endforeach;
    ?>
  </select>
  <input type="submit" value="Wybierz">
</form>

<p>
    <?php 
        if(isset($_REQUEST['cat']) && $_REQUEST['cat'] != '') {
            echo "Ilość wiadomości w \"$selectedCat\" to $counter."; 
        }
    ?>
</p>