        </div>
</div>
<div data-button="a9-lesson-3" class="workspace">
    <h2> Kod źródłowy</h2>
    <h3> Strona główna</h3>
    <xmp class="prettyprint">
<?php echo file_get_contents( "source/index.php" ); ?>
    </xmp>
    <h3> Formularz logowania</h3>
    <xmp class="prettyprint">
<?php echo file_get_contents( "source/login.php" ); ?>
    </xmp>
    <h3>Funkcje aplikacji</h3>
    <xmp class="prettyprint">
<?php echo file_get_contents( "source/functions.php" ); ?>
    </xmp>
</div>
<div data-button="a9-lesson-4" class="workspace">
    <h2> Analiza podatności</h2>
    <p>
        Stosowanie nieaktualnych wtyczek może być niebezpieczne nawet dla dobrze na-pisanych aplikacji. Pomimo, iż programista zna zasady bezpiecznego programowania, to nie należy zakładać, iż zainstalowane dodatki są bezpieczne. Tak jest również w tym przypadku, gdzie wersja 1.0 licznika odwiedzin jest podatna na atak typu SQL Injection.
    </p>
    <p>
        Podczas wyboru z listy daty z której chcemy sprawdzić ilość odwiedzin, we wtyczce rea-lizowana jest następujące wywołanie zapytania SQL:
    </p>
    <xmp class="prettyprint">
$date = $_POST[ "date" ];  
$query = "SELECT licznik FROM a9_licznik WHERE data='$date'";
    </xmp>
    <p>
        Jak widać, wybrana data z formularza nie jest w żaden sposób weryfikowana, za-tem przygotowując zapytanie zewnętrznym oprogramowaniem, bądź korzystając z narze-dzi deweloperskich przeglądarki możliwe jest zmienienie wartości wysyłanej do aplika-cji. W ten sposób do zmiennej $date możliwe jest wpisanie poniższej wartości która zo-stanie dopisana do zapytania:
    </p>
    <xmp class="prettyprint">
' UNION TRUNCATE a9_licznik
    </xmp>
    <p>
        Wywołanie całego zapytania wraz z dodaniem powyższej instrukcji opróżni całą zawartość tabeli a9_licznik, przez co usunie wszelkie dane o odwiedzinach. Atakujący wykorzystując tą dziurę, może nie tylko zaatakować tabelę przygotowaną dla wtyczki, ale i także cały serwis, gdzie może uzyskać dostęp do poufnych danych.
    </p>
</div>