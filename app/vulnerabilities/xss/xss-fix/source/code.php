<h3> Księga gości</h3>

<?php
if(isset($_SESSION['info'])){
    echo "<p>".$_SESSION['info']."</p>";
    }
?>


<form action="vulnerabilities/xss/xss-fix/index.php?action=addPost" method="post" class="guestbook">
    <input type="text" name="autor" placeholder="Autor"></br>
    <textarea name="tresc" placeholder="Treść wiadomości"></textarea><br/>
    <input type="submit" value="Dodaj">
</form>

<a class="button" href="vulnerabilities/xss/xss-fix/index.php?action=showPosts">Zobacz wpisy</a>