<h3> Artykuł </h3>
<?php
if(isset($_SESSION['info'])){
    echo "<p>".$_SESSION['info']."</p>";
    }
?>
<p>
    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla non sollicitudin nisl, nec fermentum orci. Quisque venenatis quam nec sapien auctor dictum. Ut efficitur tortor et mi vulputate sollicitudin. Maecenas sodales fermentum nisl, a pulvinar ipsum elementum vitae. Nam fermentum dui eros, molestie pellentesque orci rhoncus eu. Duis tincidunt et nisl sed fringilla. Sed eget dui rhoncus, volutpat enim sed, hendrerit arcu. Donec vitae faucibus diam, sed finibus lectus. Phasellus neque ante, porttitor non felis at, vehicula aliquet ipsum.
    <br><br>
    Aenean vitae nisi id lorem consequat ultricies. Aenean dignissim metus ut metus tincidunt accumsan. Vestibulum ac efficitur augue, non viverra metus. Cras sed vehicula diam. Nullam commodo tortor eros, non lobortis tellus faucibus a. Suspendisse lacinia a lorem sit amet tristique. Mauris semper nunc nunc, id vestibulum nisi commodo ullamcorper. Sed metus urna, mollis nec ...
</p>
<?php if(isset($_SESSION['zalogowany'])): ?>
<a class="button" href="vulnerabilities/a10/a10-lesson/article.php">Zobacz pełny artykuł</a>
<?php else:?>
<a href="vulnerabilities/a10/a10-lesson/login.php?redirect=article.php" class="button"> Zaloguj się by przeczytać cały artykuł</a>
<?php endif; ?>