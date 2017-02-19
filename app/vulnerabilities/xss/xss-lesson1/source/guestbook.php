<?php
if(isset($_SESSION['info'])){
    echo "<p>".$_SESSION['info']."</p>";
    }
?>

<p>Wpisy księgi gości:</p>

<hr style="margin:2px">

<?php foreach ($gbdata as $p): ?>
<div style="font-weight:bold">
    Data: <?php echo $p['data'];?>,
    Autor: <?php echo $p['autor'];?>
</div>
<div>Treść: <?php echo $p['tresc'];?></div>
<hr style="margin:2px">
<?php endforeach; ?>

<a class="button" href="vulnerabilities/xss/xss-lesson1/index.php">Dodaj</a>