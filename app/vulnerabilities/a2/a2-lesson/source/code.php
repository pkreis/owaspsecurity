<h3> Logowanie użytkownika</h3>
<?php
if(isset($_SESSION['info'])){
    echo "<p>".$_SESSION['info']."</p>";
    }
?>
<form action="vulnerabilities/a2/a2-lesson/index.php?action=login" method="post">
  <input type="text" name="user" placeholder="Nazwa użytkownika">
  <input type="password" name="pass" placeholder="Hasło">
  <input type="submit" value="Zaloguj">
</form>
