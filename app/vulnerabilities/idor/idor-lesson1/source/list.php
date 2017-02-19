 <form action="vulnerabilities/idor/idor-lesson1/index.php" method="get">
  <select size='6' name="id">
    <?php foreach($messages as $message):
       if(!isset($_SESSION['zalogowany']) && $message['registered']){
         $dis = 'disabled="disabled"';
       }
       else{
         $dis = '';
       }
    ?>
    <option value="<?php echo $message['id']?>" <?php echo $dis; ?>><?php echo $message['title']?></option>
    <?php endforeach; ?>
  </select>
  <input type="hidden" name="action" value="showMessage">
  <br>
  <input type="submit" value="Sprawdź wiadomość">
</form>
<br>
<?php if(isset($_SESSION['zalogowany'])): ?>

Jesteś zalogowany jako <?php echo $_SESSION['zalogowany']; ?>.
<br>
<a href="vulnerabilities/idor/idor-lesson1/index.php?action=logout" class="button">Wylogowanie</a>

<?php else: ?>
<form action="vulnerabilities/idor/idor-lesson1/index.php?action=login" method="post" class="form-inline">
    <input type="text" name="user" placeholder="Login">
    <input type="password" name="pass" placeholder="Hasło">
    <input type="submit" value="Zaloguj">
  </form>
<?php endif; ?>