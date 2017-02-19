<?php
if(isset($_SESSION['info'])){
    echo "<p>".$_SESSION['info']."</p>";
    }
?>

<form method="get" action="vulnerabilities/xss/xss-lesson2/index.php">
    <input type="text" name="search" placeholder="Fraza wyszukiwania">
    <input type="submit" value="Wyszukaj">
</form>

<?php if(isset($_REQUEST['search']) && $_REQUEST['search']):?>
  <div style="margin-bottom:0.5em;">
    Wyniki wyszukiwania dla frazy '<?php echo $_REQUEST['search']; ?>':
  </div>
<?php endif; ?>

<ul>
<?php
  foreach($data as $n):
    echo '<li>' .  $n['Tytul'];
  endforeach;
?>
</ul>