<div id="message">
<?php 
  if($message):
    echo 'Tytul: '.$message['title']. '<br />' .$message['content'].'';
  else:
    echo 'Brak wiadomości.';
  endif;
?>
</div>
<a href="vulnerabilities/idor/idor-lesson1/index.php" class="button">Powrót</a>
