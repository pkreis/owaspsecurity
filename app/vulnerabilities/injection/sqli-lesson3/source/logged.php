<?php
if(isset($_SESSION['info'])){
    echo "<p>".$_SESSION['info']."</p>";
    }
?>
<h3>
    Witaj. Jesteś zalogowany!
</h3>
<a class="button" href="vulnerabilities/injection/sqli-lesson3/index.php?action=logout">Wylogowanie</a>