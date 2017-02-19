 <form action="vulnerabilities/idor/idor-lesson1-fix/index.php" method="get">
  <select size='6' name="id">
    <?php foreach($messages as $message):
       if(!isset($_SESSION['zalogowany']) && $message['registered']){
         $dis = 'disabled="disabled"';
         $id = '0';
       }
       else{
         $dis = '';
         $id = $message['id'];
       }
    ?>
    <option value="<?php echo $id; ?>" <?php echo $dis; ?>><?php echo $message['title']?></option>
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
<a href="vulnerabilities/idor/idor-lesson1-fix/index.php?action=logout" class="button">Wylogowanie</a>

<?php else: ?>
<form action="vulnerabilities/idor/idor-lesson1-fix/index.php?action=login" method="post" class="form-inline">
    <input type="text" name="user" placeholder="Login">
    <input type="password" name="pass" placeholder="Hasło">
    <input type="submit" value="Zaloguj">
  </form>
<?php endif; ?>