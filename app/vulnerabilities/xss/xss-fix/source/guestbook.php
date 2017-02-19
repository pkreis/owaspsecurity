<?php
if(isset($_SESSION['info'])){
    echo "<p>".$_SESSION['info']."</p>";
    }
?>

<?php
require_once 'HTMLPurifier/HTMLPurifier.auto.php';
$config = HTMLPurifier_Config::createDefault();
$purifier = new HTMLPurifier($config);
?>

<p>Wpisy księgi gości:</p>

<hr style="margin:2px">

<?php foreach ($gbdata as $p): ?>
<div style="font-weight:bold">
    Data: <?php echo $p['data'];?>,
    Autor: <?php echo $purifier->purify($p['autor']);?>
</div>
<div>Treść: <?php echo $purifier->purify($p['tresc']);?></div>
<hr style="margin:2px">
<?php endforeach; ?>

<a class="button" href="vulnerabilities/xss/xss-fix/index.php">Dodaj</a>