<?php
if(isset($_SESSION['info'])){
    echo "<p>".$_SESSION['info']."</p>";
    }
?>

<form action="vulnerabilities/a7/a7-fix/index.php" method="get">
  <select size='6' name="id">
    <?php foreach($messages as $message):?>
      <option value="<?php echo $message['id']; ?>"><?php echo $message['title']?></option>
    <?php endforeach; ?>
  </select>
  <input type="hidden" name="action" value="showMessage">
  <br/>
  <input type="submit" value="Sprawdź wiadomość">
</form>

<br>
<?php if(isset($_SESSION['zalogowany'])): ?>

Jesteś zalogowany jako <?php echo $_SESSION['zalogowany']; ?>.
<br>
<a href="vulnerabilities/a7/a7-fix/index.php?action=logout" class="button">Wylogowanie</a>

<?php else: ?>
<form action="vulnerabilities/a7/a7-fix/index.php?action=login" method="post" class="form-inline">
    <input type="text" name="user" placeholder="Login">
    <input type="password" name="pass" placeholder="Hasło">
    <input type="submit" value="Zaloguj">
  </form>
<?php endif; ?>