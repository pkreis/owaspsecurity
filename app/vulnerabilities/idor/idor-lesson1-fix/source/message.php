<div id="message">
<?php 
  if($message):
    if(!$message['registered'] || ($message['registered'] && isset($_SESSION['zalogowany']))):
      echo 'Tytul: '.$message['title']. '<br />' .$message['content'].'';
    else:
      echo 'Brak wiadomości.';
    endif;
  else:
    echo 'Brak wiadomości.';
  endif;
?>
</div>
<a href="vulnerabilities/idor/idor-lesson1-fix/index.php" class="button">Powrót</a>
