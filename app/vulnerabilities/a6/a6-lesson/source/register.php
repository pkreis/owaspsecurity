<h3> Rejestracja</h3>
<?php
if(isset($_SESSION['info'])){
    echo "<p>".$_SESSION['info']."</p>";
    }
?>
<form action="vulnerabilities/a6/a6-lesson/index.php?action=register" method="post" class="register">
  <input type="text" name="user" placeholder="Nazwa użytkownika">  <br>
  <input type="password" name="pass" placeholder="Hasło"> <br>
  <input type="submit" value="Zarejestruj">
</form>
