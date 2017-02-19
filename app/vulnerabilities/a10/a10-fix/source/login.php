<h3> Logowanie użytkownika</h3>
<?php
if(isset($_SESSION['info'])){
    echo "<p>".$_SESSION['info']."</p>";
    }
?>

<br>

<form action="vulnerabilities/a10/a10-fix/login.php?action=login" method="post">
  <input type="text" name="user" placeholder="Nazwa użytkownika">
  <input type="password" name="pass" placeholder="Hasło">
  <input type="hidden" name="redirect" value="<?php echo $ref = checkReferer();?>">
  <input type="submit" value="Zaloguj">
</form>
