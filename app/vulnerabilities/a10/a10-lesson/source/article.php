<h3> Artykuł </h3>
<?php
if(isset($_SESSION['info'])){
    echo "<p>".$_SESSION['info']."</p>";
    }
?>
<?php if(isset($_SESSION['zalogowany'])): ?>
<p>
    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla non sollicitudin nisl, nec fermentum orci. Quisque venenatis quam nec sapien auctor dictum. Ut efficitur tortor et mi vulputate sollicitudin. Maecenas sodales fermentum nisl, a pulvinar ipsum elementum vitae. Nam fermentum dui eros, molestie pellentesque orci rhoncus eu. Duis tincidunt et nisl sed fringilla. Sed eget dui rhoncus, volutpat enim sed, hendrerit arcu. Donec vitae faucibus diam, sed finibus lectus. Phasellus neque ante, porttitor non felis at, vehicula aliquet ipsum.
    <br><br>
    Aenean vitae nisi id lorem consequat ultricies. Aenean dignissim metus ut metus tincidunt accumsan. Vestibulum ac efficitur augue, non viverra metus. Cras sed vehicula diam. Nullam commodo tortor eros, non lobortis tellus faucibus a. Suspendisse lacinia a lorem sit amet tristique. Mauris semper nunc nunc, id vestibulum nisi commodo ullamcorper. Sed metus urna, mollis nec euismod non, congue ac orci. In justo nisi, condimentum sed euismod sed, ornare at sapien. Suspendisse at est vel enim sodales malesuada. In dictum dui quis lectus placerat, eu dapibus enim porta.
    <br><br>
    Vestibulum dapibus hendrerit felis sit amet posuere. Aenean sit amet mauris sodales, lacinia justo vel, ullamcorper nunc. Proin purus nisl, accumsan id consectetur et, porttitor eu nisl. Morbi volutpat, enim at commodo vestibulum, enim ipsum tempus erat, a ultricies ante urna a turpis. Phasellus id felis eleifend, venenatis dui at, pulvinar sapien. Aenean bibendum, urna sagittis viverra consectetur, quam ante commodo tellus, at ultrices sem est vel velit. Nullam a tincidunt turpis, a rhoncus enim. Nunc blandit condimentum quam. Sed feugiat, diam nec laoreet interdum, lacus massa sagittis sapien, at laoreet lacus arcu quis dui. Suspendisse pellentesque, arcu sed blandit sollicitudin, mi augue faucibus sem, a efficitur lorem justo ac enim. Donec at congue urna, sed faucibus orci. Praesent mi odio, accumsan ut dolor et, eleifend congue ipsum. Quisque non ullamcorper mi.
    <br><br>
    Nullam suscipit nisi magna, a consequat nulla mollis vel. Vivamus pellentesque, ligula quis lobortis posuere, velit velit ornare est, eu mattis risus neque eu elit. Sed vitae mollis ligula. Fusce interdum bibendum neque, id volutpat urna rhoncus eget. Ut viverra vel dui ac malesuada. Suspendisse eu pharetra turpis. Aenean accumsan mauris et venenatis elementum. Maecenas efficitur lobortis augue in porta. Aliquam malesuada ullamcorper congue. Quisque volutpat augue tortor, non pretium felis vestibulum quis. Nam id mauris sit amet mauris sollicitudin condimentum dictum nec lorem. Mauris vitae sodales est. Mauris fringilla lorem metus, ac elementum dolor semper vitae. Donec porttitor nisi in leo congue, eu pretium risus commodo.
</p>
<a class="button" href="vulnerabilities/a10/a10-lesson/index.php?action=logout">Wylogowanie</a>
<?php else:?>
<a href="vulnerabilities/a10/a10-lesson/login.php?redirect=article.php" class="button"> Zaloguj się by przeczytać cały artykuł</a>
<?php endif; ?>