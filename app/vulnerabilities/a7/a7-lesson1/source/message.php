<?php
if(isset($_SESSION['info'])){
    echo "<p>".$_SESSION['info']."</p>";
    }
?>
<div id='message'>
    <?php if($message): echo 'Tytul: '.$message['title']. '<br />' .$message['content'].''; ?>
    <?php if(isset($_SESSION['zalogowany'])): ?>
    <div style="margin-top:20px;">
      <form action="vulnerabilities/a7/a7-lesson1/index.php" method="post">
        <input type="submit" value="Usuń wiadomość">
        <input type="hidden" name="action" value="deleteMessage">
        <input type="hidden" name="id" value="<?php echo $message['id']; ?>">
      </form>
    </div>
    <?php endif; ?>
    <?php
    else:
      echo 'Brak wiadomości.';
    endif;
    ?>
</div>
<a href="vulnerabilities/a7/a7-lesson1/index.php" class="button">Powrót</a>