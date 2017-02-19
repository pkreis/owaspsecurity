<header>
    <div class="wrapper">
        <h2> SQL Injections </h2>
        <h3> (Zabezpieczenie)</h3>
        <div class="navbar">
            <img src="style/images/logo_polsl_aei.png">
        </div>
    </div>
    <div class="panel">
        <button data-button="a1-sqli-fix-1">Wstęp</button>
        <button data-button="a1-sqli-fix-2">Filtry i ścisłe typowanie</button>
        <button data-button="a1-sqli-fix-3">Sekwencja ucieczki</button>
        <button data-button="a1-sqli-fix-4">Zapytania parametryzowane</button>
        <button data-button="a1-sqli-fix-5">Zabezpieczona aplikacja</button>
    </div>
</header>
<div class="blankspace" style="height:180px;"></div>
<div data-button="a1-sqli-fix-1" class="workspace">
    <h2> Wstęp</h2>
    <p>
        Najważniejszym błędem, który umożliwi przeprowadzenie ataku SQL Injection jest brak weryfikacji danych wejściowych. Podstawą zabezpieczenia aplikacji jest zatem sprawdzenie czy posiadają one poprawny format. 
    </p>
</div>
<div data-button="a1-sqli-fix-2" class="workspace">
    <h2>Filtry i ścisłe typowanie</h2>
        <p>
            Dbanie o poprawność typu danych jest jednym z metod ochrony serwisu. Analizując ponownie przykład Kontroli dostępu do danych widzimy, iż do aplikacji wysyłany jest identyfikator kategorii, który jest liczbą całkowitą. Należy zatem wykonać sprawdzenie czy na pewno otrzymany parametr jest taką liczbą. Najlepiej wymusić konwersje otrzymanego ciągu na wartość całkowitą. Jeśli wstawiony był inny tekst do zapytania zostanie on zignorowany. Konwersja odbywa się za pomocą funkcji intval , zatem kod ma następującą postać: 
        </p>
        <xmp class="prettyprint">
if(isset($_REQUEST['cat']) && $_REQUEST['cat'] != ''){
$catQuery = "AND kategoria = {$_REQUEST['cat']}";
        </xmp>
        <p>
            Należało by zmienić w następujący sposób:
        </p>
        <xmp class="prettyprint">
if(isset($_REQUEST['cat'])){
$cat = intval($_REQUEST['cid']);
$catQuery = "AND kategoria = $cat";
}
        </xmp>
        <p>
            W przypadku błędnego parametru cat  który nie jest liczbą całkowitą zapytanie będzie miało postać:
        </p>
        <xmp class="prettyprint">
SELECT * FROM News WHERE aktywna = 1 AND kategoria = 0
        </xmp>
        <p>
            Nie zostaną zatem wyświetlone żadne wyniki, gdyż nie istnieje taka kategoria. Kod można zapisać w prostszy sposób zakładając, iż kategorię posiadają identyfikatory większe od 0. Wystarczy sprawdzić czy otrzymany parametr po konwersji jest większy od wspomnianego 0. Jeśli jest większy to mamy pewność, iż została przekazana prawidłowa dodatnia liczba całkowita:
        </p>
        <xmp class="prettyprint">
if(isset($_REQUEST['cat']) && ($cat = intval($_REQUEST['cat'])) > 0){
$catQuery = "AND kategoria = $cat";
}
        </xmp>
        <p>
            Wartym zastosowania rozwiązaniem jest użycie funkcji filter_input posiadającej większe możliwości niż przy zwykłe rzutowanie. Wywoływuje się ją w następujący sposób:
        </p>
        <xmp class="prettyprint">
filter_input(źródło, parametr [, filtr[, opcje]])
        </xmp>
        <p>
            W argumencie źródło mogą się znajdować takie wartości jak INPUT_GET czy INPUT_POST określając jaką metodą otrzymano wartość parametru, którego nazwę wpisuję się w argument parametr. Istnieje wiele rodzajów filtrowania np. FILTER_VALIDATE_INT, FILTER_VALIDATE_BOOLEAN, FILTER_VALIDATE_FLOAT zwracające wartości w odpowiednim typie.
        </p>
        <p>
            Wynikiem funkcji jest wartość parametry gdy spełnia ona wprowadzone reguły filtrowania. Jeśli wartość nie spełnia ich to wynikiem jest false lub null gdy parametr jest pusty. Stosując tą funkcję do powyższego przykładu instrukcja warunkowa przyjmie następującą postać:
        </p>
        <xmp class="prettyprint">
if($cat = filter_input(INPUT_GET, 'cat', FILTER_VALIDATE_INT)){
$catQuery = "AND kategoria = $cat";
}
        </xmp>
</div>
<div data-button="a1-sqli-fix-3" class="workspace">
    <h2>Sekwencja ucieczki</h2>
        <p>
            W większości podatnych aplikacji na ataki SQL Injection wstrzyknięcie kodu jest możliwe poprzez doklejenie do zapytania nowych fragmentów zapytania SQL. Aby było to możliwe wysyłany był znak ' wyznaczający koniec poprzedniego ciągu. Aby znak ten mógł być używany jako treść należy zastosować sekwencje ucieczki (ang. Escape sequence). W MySQL, aby było to możliwe należy znak specjalny poprzedzić znakiem \ .
        </p>
        <p>
            Stosuje się zatem odpowiednie metody służące do zapisywania jako tekst całej zawartości przesyłanego parametru. Dla mysqli w wersji obiektowej byłaby to metoda real_escape_string, natomiast w wersji proceduralnej - funkcja mysqli_real_escape_string.
        </p>
        <p>
            Aby skorzystać z tego rozwiązania w przykładzie logowania użytkowników należało by zmienić sposób odczytu parametrów user oraz pass na następujący:
        </p>
        <xmp class="prettyprint">
$user = $conn->real_escape_string($_POST['user']);
$pass = $conn->real_escape_string($_POST['pass']);
        </xmp>
        <p>
            W ten sposób parametry pobrane z żądania są najpierw poddawane działaniu metody real_escape_string, której wynik działania trafia do zmiennej $user i $pass. Ich wartości wstawanie są do zapytania SQL nie zaburzając jej struktury. Dzięki takim zabiegom ataki SQL Injection mające na celu dopisanie swojego zapytania nie powiodą się, gdyż poprzez zastosowanie sekwencji specjalnych cała treść wpisywana przez użytkownika strony i przesyłana do serwera będzie traktowana jako właściwy parametr. 
        </p>
</div>
<div data-button="a1-sqli-fix-4" class="workspace">
    <h2>Zapytania parametryzowanee</h2>
        <p>
            W przedstawianych przykładach podatności części statyczne zapytań, jak i pobierane parametry żądania trafiały do zmiennej $query, która następnie była wywoływana na serwerze bazy danych. Stosując zapytania parametryzowane możemy oddzielić wpisywane od kodu źródłowego uzyskując przez to większą kontrole nad tym procesem. Pozwalają one unikać wstrzykiwania kodu SQL, a czasem nawet zwiększyć wydajność aplikacji.
        </p>
        <p>
            Korzystając z zapytań parametryzowanych pierwszym etapem jest oznaczenie miejsc występowania parametrów w zapytaniu. Następnie następuje dołączenie parametrów i wykonanie zapytania. Przy wstawianiu parametrów do zapytania określa się ich typy, dziki czemu trudno o wstrzyknięcie złośliwego fragmentu kodu. Dane pobierane jako ciągi są automatycznie także poddawane sekwencji ucieczki.
        </p>
        <p>
            Zapytanie parametryzowane wysyła się do serwera za pomocą funkcji prepare (lub mysqli_prepare). W rezultacie wynikiem jest obiekt zapytania na którym można zastosować m.in. wstawienie parametrów do zapytania (bind_param), wykonać zapytanie z podanymi parametrami (execute), pobranie wiersza wynikowego (fetch) czy za powiązanie danych wynikowych ze zmiennymi (bind_result).W zapytaniu umiejscowienie parametrów wyrażane jest za pomocą znaku ?. 
        </p>
        <p>
            Wykorzystanie zapytań parametryzowanych zostanie przedstawione na przykładzie logowania, które znajduje się w dziale Ataki na logowanie. Ich zastosowanie pozwoli pozbyć występujących w nim błędów.
        </p>
        <p>
            W pierwszym kroku należy przekształcić zapytanie tak, by w miejsce gdzie teraz wstawiane są zmienne $user i $pass znajdowała się tylko informacja, w którym miejscu będą wstawiane wartości. Kod będzie zatem wyglądał następująco:
        </p>
        <xmp class="prettyprint">
$query = "SELECT Haslo, Nazwa, Id ";
$query .= "FROM a1_uzytkownicy WHERE Nazwa=? AND Haslo=?; 
        </xmp>
        <p>
            Takie zapytanie wysyłane jest następnie do serwera poprzez funkcję prepare, zatem dla tego przykładu przyjmnie postać: 
        </p>
        <xmp class="prettyprint">
$conn->prepare($query))
        </xmp>
        <p>
           Następnym krokiem jest dla uzykanego obiektu jest powiazanie zapytania z parametrami za pomocą metody bind_param. Pierwszym argumentem jest wartość określająca typ parametrów. Typy określane są za pomocą liter:
        </p>
        <p>
            •	i — liczba całkowita, <br>
            •	d — liczba zmiennoprzecinkowa,<br>
            •	s — ciąg znaków,<br>
            •	b — dane binarne.

        </p>
        <p>
            W tym przypadku zarówno nazwa użytkownika jak i hasło są ciągiem znaków zatem zapytanie będzie wyglądać następująco:
        </p>
        <xmp class="prettyprint">
$result->bind_param("ss", $user, $pass)
        </xmp>
        <p>
            Następnie należy wykonać metody execute i store_result. Jeśli te polecenia zostaną wykonane poprawnie sprawdzane jest czy wynik zwrócił rozwiązanie. Gdy istnieje wiersz wynikowy dane można powiązać ze zmiennymi dzięki metodzie bind_results :
        </p>
        <xmp class="prettyprint">
$result->bind_result($haslo, $nazwa, $id);
        </xmp>
        <p>
            Odczyt wierszu wynikowego odbywa dzięki poleceniu:
        </p>
        <xmp class="prettyprint">
$result->fetch();
        </xmp>
        <p>
            W ten sposób serwis z logowaniem został zabezpieczony przed niepożądanymi wstrzyknięciami zapytań SQL.
        </p>
</div>
<div data-button="a1-sqli-fix-5" class="workspace lesson center">
    <h2> Zabezpieczona aplikacja</h2>
    <h3> Wykorzystanie zapytań parametryzowanych</h3>
        <div class="lessonContent">
            <?php include('source/functions.php'); ?>
        </div>
</div>