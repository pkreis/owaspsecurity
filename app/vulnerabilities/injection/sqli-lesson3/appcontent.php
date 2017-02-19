<header>
    <div class="wrapper">
        <h2> SQL Injections </h2>
        <h3> (Ślepy atak - Blind SQL Injection)</h3>
        <div class="navbar">
            <img src="style/images/logo_polsl_aei.png">
        </div>
    </div>
    <div class="panel">
        <button data-button="a1-sqli-lesson3-1">Opis zadania</button>
        <button data-button="a1-sqli-lesson3-2">Lekcja</button>
        <button data-button="a1-sqli-lesson3-3">Kod Źródłowy</button>
        <button data-button="a1-sqli-lesson3-4">Analiza podatności</button>
    </div>
</header>
<div class="blankspace" style="height:180px;"></div>
<div data-button="a1-sqli-lesson3-1" class="workspace">
    <h2> Ślepy atak</h2>
    <p>
        Innym rodzajem ataku wstrzykiwania jest Blind SQL Injection czyli ślepy atak. Polega on na tym, iż atakujący nie otrzymuje bezpośrednio jawnych danych, a tylko odpowiedzi typu prawda i fałsz. 
    </p>
    <p>
        Analizowany przykład będzie zliczał po wysłaniu formularza ilość wiadomości w danej kategorii. Wybór kategorii będzie realizowany w ten sam sposób jak w rozdziale „Dostęp do ukrytych danych” gdzie mamy listę rozwijaną z kategoriami wiadomości do wyboru oraz przyciskiem wysłania wybranego wyboru.
    </p>
    <p>
        Celem potencjalnego atakującego jest otrzymanie informacji na jakiej wersji działa serwer MySQL.
    </p>
</div>
<div data-button="a1-sqli-lesson3-2" class="workspace lesson">
    <h2> Badanie podatności</h2>
        <div class="lessonContent">
            <?php include('source/functions.php'); ?>
        </div>
</div>
<div data-button="a1-sqli-lesson3-3" class="workspace">
    <h2> Kod źródłowy</h2>
    <h3> Lista kategorii </h3>
    <xmp class="prettyprint">
<?php echo file_get_contents( "source/code.php" ); ?>
    </xmp>
    <p>
        Tak jak w przypadku skryptu odnośnie  dostępu do ukrytych danych znajduje się formularz wyboru kategorii, które są pobierane z tabeli $categories. Po wyborze z listy odpowiedniej kategorii sprawdzane jest przy pomocy otrzymanego motodą GET parametru cat i ustawienie aktywnie zaznaczonej kategorii. U dołu szablonu wyboru znajduje się instrukcja :
    </p>
    <xmp class="prettyprint">
echo "Ilość wiadomości w \"$selectedCat\" to $counter.";
    </xmp>
    <p>
        Odpowiada ona za wyświetlenie nazwy wybranej kategorii (zmienna $selectedCat) oraz liczby wiadomości (zmienna $counter).
    </p>
    <h3> Funcje pobrania danych</h3>
    <xmp class="prettyprint">
<?php echo file_get_contents( "source/functions.php" ); ?>
    </xmp>
    <p>
        Funkcja wyświetlająca szablon strony przekazuje tablicę kategorii. Za pomocą funkcji  getData, która informuje o liczbie wpisów w danym podzbiorze.
    </p>
    <p>
        Struktura pobierania parametru cat jest identyczna jak w poprzednim przykładzie. Sprawdzamy czy parametr został pobrany i nie jest pusty. Następuje bezpośrednie przypisanie otrzymanego parametru do zmiennej $catQuery wraz z fragmentem zapytania SQL, a kompletne zapytanie do bazy danych jest następujące:
    </p>
    <xmp class="prettyprint">
SELECT COUNT (*) FROM a1_wiadomosci
WHERE aktywna = 1 AND kategoria = {$_REQUEST['cat']}
    </xmp>
    <p>
        Klauzula SELECT COUNT zlicza ilość zgodnych wierszy sprawdzanych w warunku WHERE. Następuje wywołanie i zapisanie wyniku do zmiennej. Zapytanie zawsze zwraca tylko jeden wiersz z jedną kolumną wynikową. Zwracana jest więc tylko pojedyncza wartość liczbowa (instrukcja return $row[0]).

    </p>
</div>
<div data-button="a1-sqli-lesson3-4" class="workspace">
    <h2> Analiza podatności</h2>
    <p>
        Pomimo, że do parametru cat możemy wprowadzić dowolną wartość to atakującemu nie uda się łatwo uzyskać dużej liczby danych jak to możliwe było w skrypcie „Dostęp do ukrytych danych”. Jednakże, luka bezpieczeństwa oczywiście nadal istnieje i można tu zastosować tytułowy Blind SQL Injection. 
    </p>
    <p>
        Typowym wykorzystaniem tej podatności jest uzyskanie przez atakującego informacji o wersji serwera bazy danych. W przypadku bazy MySQL informacja ta znajduje się w zmiennej version. Aby sprawdzić jej zawartość należy zastosować zapytanie SELECT @@version.
    </p>
    <p>
        Skróconą wersję możemy uzyskać stosując zapytanie SELECT substr(@@version, 1,3) . Funkcja substr wyciąga podciąg znaków rozpoczynający się na pozycji 1 o długości 3 znaków ze zmiennej version.
    </p>
    <p>
        Jako, że zapytanie SELECT COUNT (*) w aplikacji zwraca zawsze tylko 1 wiersz możemy zastosować w tym wypadku zamiast identyfikatora cat dodatkowy warunek sprawdzający. Wywołując adres url aplikacji w następujący sposób
    </p>
    <xmp class="prettyprint">
index.php?cat=1%20AND%201=0
    </xmp>
    <p>
        Całe zapytanie SQL będzie miało taką postać: 
    </p>
    <xmp class="prettyprint">
SELECT COUNT(*) FROM a1_ wiadomosci
WHERE aktywna = 1 AND kategoria = 1 AND 1=0
    </xmp>
    <p>
        W odpowiedzi otrzymamy informację, iż liczba wiadomości jest równa 0 , ponieważ pomimo iż pierwszy warunek został spełniony, drugi jest fałszywy zatem cała zapytanie nie zwróci wyników. Gdy zastosujemy warunek AND 1=1 wtedy oba warunki zostają spełnione i wyświetli nam się prawidłowa liczba wiadomości. W ten sposób, testując na ślepo różne warunki, atakujący jest w stanie otrzymać odpowiedzi na różne pytania, które mogą mu posłużyć do przeprowadzenia kolejnych ataków.
    </p>
    <p>
        Aby otrzymać odpowiedź, jaka jest wersja serwera bazy danych należy sprawdzać po kolei różne oznaczenia wersji w dodatkowym warunku do zapytania. Trzeba je zadawać w następujący sposób:
    </p>
    <xmp class="prettyprint">
SELECT COUNT(*) FROM a1_ wiadomosci
WHERE aktywna = 1 AND kategoria = 1
AND (SELECT substr(@@version,1,3)='wersja')
    </xmp>
    <p>
        W miejsce ciągu wersja wpisujemy różne oznaczenia np. 2.0, 2.3, 3.0, 5.5, 10.0, 10.1 itd. W przypadku wersji 10 należy zastosować polecenie substr(@@version,1,4) , gdyż 4 znaki będą sprawdzane by określić numer wersji. Należy zatem wywołać adres url z następującym parametrem cat:
    </p>
    <xmp class="prettyprint">
index.php?cat=1 AND (SELECT substr(@@version,1,3)='wersja')
    </xmp>
    <p>
        Co po zakodowaniu procentowym przyjmnie postać:
    </p>
    <xmp class="prettyprint">
index.php?cat=1%20AND%20%28SELECT%20substr%28@@version,1,3%29=%27wersja%27%29
    </xmp>
    <p>
        Dzięki temu, jeśli sprawdzając nie trafimy w właściwą wersję serwera, na stronie pojawi się informacja, że jest 0 wiadomości w danej kategorii, natomiast gdy trafimy w prawidłową, liczba wiadomości będzie większa od zera. Ta informacja pozwoli już atakującemu na inne możliwości włamania się do serwisu.
    </p>
</div>














