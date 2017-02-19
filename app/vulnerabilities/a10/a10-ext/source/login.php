<h3> Logowanie użytkownika</h3>
<?php
if(isset($_SESSION['hacked'])){
    echo "<p>".$_SESSION['hacked']."</p>";
    }
else { echo "<p>Nieprawidłowy login lub hasło!</p>";}
?>
<form action="vulnerabilities/a10/a10-ext/index.php?action=login" method="post">
  <input type="text" name="user" placeholder="Nazwa użytkownika">
  <input type="password" name="pass" placeholder="Hasło">
  <input type="submit" value="Zaloguj">
</form>
