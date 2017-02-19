<?php
if(isset($_SESSION['info'])){
    echo "<p>".$_SESSION['info']."</p>";
    }
?>
<h3>Wysyłanie obrazów</h3>
<form action="vulnerabilities/a5/a5-lesson/index.php?action=upload" method="post" 
      enctype="multipart/form-data" class="form-horizontal">
  <label for="file">Wybierz plik z obrazem</label>
  <input type="file" name="file">
  <br><br>
  <label for="desc">Opis obrazu</label>
  <input type="text" name="desc" class="input-xxlarge">
  <input type="submit" value="Wyślij" class="btn">
</form>
<a class="button" href="vulnerabilities/a5/a5-lesson/index.php">Powrót</a>