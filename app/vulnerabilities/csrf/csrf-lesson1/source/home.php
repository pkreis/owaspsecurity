<h2>Program lojalnościowy</h2>
<?php
if(isset($_SESSION['info'])){
    echo "<p>".$_SESSION['info']."</p>";
    }
?>
<?php if(!isset($_SESSION['zalogowany'])): ?>
<form action="vulnerabilities/csrf/csrf-lesson1/index.php?action=login" method="post" class="form-inline">
  <input type="text" name="user" placeholder="Nazwa użytkownika">
  <input type="password" name="pass" placeholder="Hasło">
  <input type="submit" value="Zaloguj">
</form>
<?php else:?>

<div>Użytkownik: <strong><?php echo $user; ?></strong></div>
<div>Ilość punktów: <strong><?php if (!$ammount){ echo 'brak danych'; } else { echo $ammount; } ;?></strong> pkt</div>
<br> 
<a href="vulnerabilities/csrf/csrf-lesson1/index.php?action=showtransfer"  class="button">Transfer punktów</a>
<br> 
<a href="vulnerabilities/csrf/csrf-lesson1/index.php?action=logout" class="button">Wylogowanie</a>

<?php endif; ?>