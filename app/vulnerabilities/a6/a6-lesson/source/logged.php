<?php
if(isset($_SESSION['info'])){
    echo "<p>".$_SESSION['info']."</p>";
    }
?>
<h3>
    Witaj. Jesteś zalogowany!
</h3>
<a class="button" href="vulnerabilities/a6/a6-lesson/index.php?action=logout">Wylogowanie</a>