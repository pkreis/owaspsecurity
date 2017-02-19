<?php
if(isset($_SESSION['info'])){
    echo "<p>".$_SESSION['info']."</p>";
    }
?>
<h3>
    Witaj. Jesteś zalogowany!
</h3>
<p>Idenytifkator sesji zapisany w ciasteczu: <b><?php echo $session; ?></b></p>
<a class="button" href="vulnerabilities/a2/a2-lesson/index.php?action=logout">Wylogowanie</a>