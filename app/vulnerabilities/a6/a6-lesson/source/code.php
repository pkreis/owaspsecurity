<h3> Logowanie użytkownika</h3>
<?php
if(isset($_SESSION['info'])){
    echo "<p>".$_SESSION['info']."</p>";
    }
?>
<form action="vulnerabilities/a6/a6-lesson/index.php?action=login" method="post">
  <input type="text" name="user" placeholder="Nazwa użytkownika">
  <input type="password" name="pass" placeholder="Hasło">
  <input type="submit" value="Zaloguj">
</form>
<a href="vulnerabilities/a6/a6-lesson/index.php?action=registerForm" class="button">Rejestracja</a>
<h4> Sprawdź identfikatory użytkoników!</h4>
<form action="vulnerabilities/a6/a6-lesson/index.php?action=getId" method="post">
  <select name="username" id="username">
    <?php foreach($users as $u):?>
    <option value="<?php echo $u['Nazwa']?>"><?php echo $u['Nazwa']?></option>
    <?php endforeach; ?>
  </select>
  <br>
  <input type="submit" value="Sprawdź">
</form>