<h3>Galeria</h3>
<?php
if(isset($_SESSION['info'])){
    echo "<p>".$_SESSION['info']."</p>";
    }
?>
<?php if(count($images)): ?>
<ul class="gallery">
  <?php foreach($images as $k => $img): ?>
    <li>
      <img src='vulnerabilities/a5/a5-lesson/images/<?php echo $img['nazwa']; ?>' alt='<?php echo $img['nazwa'];?>'>
      <p><?php if (!$img['opis']){ echo 'brak opisu'; } else { echo htmlspecialchars($img['opis'], ENT_QUOTES); } ;?></p>
    </li>
  <?php endforeach; ?>
</ul>
<?php else: ?>
  <h4>Nie ma obrazów do wyświetlenia.</h4>
<?php endif; ?>
<a href="vulnerabilities/a5/a5-lesson/index.php?action=getuploadform" class="button">Wgraj obraz </a>