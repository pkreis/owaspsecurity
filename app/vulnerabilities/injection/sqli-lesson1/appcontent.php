<header>
    <div class="wrapper">
        <h2> SQL Injections </h2>
        <h3> (Atak na logowanie)</h3>
        <div class="navbar">
            <img src="style/images/logo_polsl_aei.png">
        </div>
    </div>
    <div class="panel">
        <button data-button="a1-sqli-lesson1-1">Opis zadania</button>
        <button data-button="a1-sqli-lesson1-2">Lekcja</button>
        <button data-button="a1-sqli-lesson1-3">Kod Źródłowy</button>
        <button data-button="a1-sqli-lesson1-4">Analiza podatności</button>
    </div>
</header>
<div class="blankspace" style="height:180px;"></div>
<div data-button="a1-sqli-lesson1-1" class="workspace">
    <h2> Atak na logowanie</h2>
    <p>
        Tworząc serwis wymagający logowania użytkowników należy wielką uwagę zwrócić na błędy SQL Injections, gdyż jest to jeden z najczęstszych wykorzystywanych podatności bezpieczeństwa.  Dane użytkowników są przechowywane w tabeli Użytkownicy. Instrukcją tworząca tabelę wyglądała by następująco:
    </p>
    <xmp class="prettyprint">
CREATE TABLE a1_użytkownicy
(
Id INTEGER PRIMARY KEY,
Nazwa TEXT NOT NULL,
Haslo TEXT NOT NULL
)
    </xmp>
    <p>
        Należy uzupełnić bazę przykładowymi danymi.  W tym przypadku posłużymy się niezakodowanym hasłem w celach instruktażowych, jednakże należy pamiętać aby w każdym tworzonym serwisie musimy zastosować ten zabieg (szczegóły w rozdziale A6. Sensitive Data Exposure). Instrukcja SQL wypełniająca kilka wierszy: 
    </p>
    <xmp class="prettyprint">
INSERT INTO a1_użytkownicy VALUES(1, 'login1', 'haslo1');
INSERT INTO a1_użytkownicy VALUES(2, 'login2', 'haslo2');
INSERT INTO a1_użytkownicy VALUES(3, 'login3', 'haslo3');
    </xmp>
    <p>
        Po wejściu na stronę użytkownik widzi formularz logowania z polem „Nazwa użytkownika” typu text oraz „Hasło” typu password. Celem potencjalnego atakującego w tym przykładzie jest zalogowanie się do serwisu nie znając danych logowania.
    </p>
</div>
<div data-button="a1-sqli-lesson1-2" class="workspace lesson center">
    <h2> Badanie podatności</h2>
        <div class="lessonContent">
            <?php include('source/functions.php'); ?>
        </div>
</div>
<div data-button="a1-sqli-lesson1-3" class="workspace">
    <h2> Kod źródłowy</h2>
        <h3> Formularz logowania</h3>
        <xmp class="prettyprint">
<?php echo file_get_contents( "source/code.php" ); ?>
        </xmp>
        <p>
            Formularz wykonania wywołuje skrypt index.php , który przekazuje parametr action o wartości login. W serwisie zostanie przez to wywołana funkcja, która będzie odpowiadać za proces logowania. Za pomocą metody POST wysyła parametry user oraz pass, które pobiera z naszego formularza logowania. Przed formularzem widzimy kod języka php wyświetlający wiadomość zapisaną w sesji. 
        </p>
        <h3> Funcje Logowania</h3>
        <xmp class="prettyprint">
<?php echo file_get_contents( "source/functions.php" ); ?>
        </xmp>
        <p>
            W pierwszej kolejności sprawdzamy czy połączenie z bazą danych jest poprawnie zainicjalizowane. Kolejnym krokiem jest weryfikacja czy za pomocą metody POST zostały przekazane parametry user  i pass, a jeśli tak się stało to przypisuje je do zmiennych  i bezpośrednio wstawia do zapytania SQL, które przyjmie następującą postać:
        </p>
        <xmp class="prettyprint">
SELECT Haslo, Nazwa, Id
FROM Users
WHERE Nazwa='$user' AND Haslo='$pass'
        </xmp>
        <p>
            Zapytanie to jest wysyłane do serwera za pomocą wywołania $conn->query($query). Jeśli w bazie istnieje użytkownik o podanej nazwie użytkownika zapisanej w zmiennej $user i haśle zapisanym w zmiennej $pass to zapytanie zwróci wyniki. Sprawdzenie to zostaje wykonane w instrukcji if($result->num_rows){ . Gdy użytkownik poda odpowiednie dane pobierany jest wiersz wynikowy. W zmiennej sesji „zalogowany” ustawiana jest nazwa użytkownika pobrana z tablicy $row pod indeksem 1. Gdy użytkownik poda błędne dane otrzyma odpowiedni komunikat i pozostaje niezalogowany.
        </p>
</div>
<div data-button="a1-sqli-lesson1-4" class="workspace">
    <h2> Analiza podatności</h2>
    <p>
        W przedstawionym powyżej kodzie jesteśmy w stanie zauważyć dwa podstawowe błędy. Są nimi brak weryfikacji danych wejściowych oraz sposób odczytu wyników zapytania.  Sprawdzane jest czy zapytanie zwróciło jakieś wyniki nie sprawdzając przy tym ile tych wyników zostało zwróconych. Dlatego ważnym elementem jest zastosowanie w kolumnie Users atrybutu UNIQUE by nie było możliwości powielenia nazw użytkowników.
    </p>
    <p>
        Wykorzystując brak filtrowania danych wejściowych otrzymujemy podatność na atak typu SQL Injection. W ten sposób potencjalny włamywacz jest w stanie zalogować się do serwisu bez znajomości nazwy użytkownika oraz hasła. 
    </p>
    <p>
        W przypadku powyższego skryptu wystarczy jak do pola hasła w formularza wpiszemy następujący ciąg:  abc' OR '1'='1 . Aby ułatwić sobie weryfikacje wpisywanych znaków do pola typu „password” za pomocą narzędzi deweloperskich  możemy podmienić na standardowy typ „text”, dzięki czemu można zaobserwować wpisywane znaki.
    </p>
    <p>
        Po wysłaniu powyższego żądania logowania włamywacz zostanie zalogowany do serwisu, nawet jeśli pole nazwy użytkownika pozostało puste lub wpisano dowolną nazwę.  Wysyłając formularz z takim żądaniem w zmiennej $user znajdzię się wartość np. „hacker”, a w zmiennej $pass ciąg „abc' OR '1'='1”. Całe zapytanie SQL będzie wyglądać następująco: 
    </p>
<xmp class="prettyprint">
SELECT Haslo, Nazwa, Id FROM a1_uzytkownicy
WHERE Nazwa='hacker' AND Haslo='abc' OR '1'='1';
</xmp>
    <p>
        Fragment warunku<em> Nazwa='xyz' AND Haslo='abc'</em> przestanie mieć znaczenie, gdyż ze względu na użycie operatora <em>OR</em> i drugiego warunku o wartości logicznej true (<em>'1'='1'</em> daje w wyniku true), całe wyrażenie klauzuli WHERE jest prawdziwe dla każdego wiersza tabeli Users. A zatem to zapytanie zwr&oacute;ci wszystkie wiersze tabeli <em>Users</em>! Można się o tym przekonać, wykonując je w dowolnym kliencie MySQL (rysunek 2.3). Skoro tak, występująca w metodzie login instrukcja: <em>if($result-&gt;num_rows)</em>{ spowoduje zalogowanie użytkownika, gdyż w polu num_rows znajdzie się liczba wierszy wynikowych zapytania, kt&oacute;ra zawsze będzie r&oacute;żna od 0
    </p>
    <p>
        Innym sposobem na uzyskanie dostępu jest sytuacja w kt&oacute;rej&nbsp;w zmiennej $user znajdzie się ciąg:' <em>UNION SELECT 1, 'jankowalski','3</em> a w zmiennej <em>$pass</em> &mdash; ciąg <em>1</em>. Co się wtedy stanie w aplikacji? Zapytanie SQL wysyłane do bazy przyjmie postać:</p>
<xmp class="prettyprint">
SELECT Haslo, Nazwa, Id
FROM Users
WHERE Nazwa='' UNION SELECT 1, 'jankowalski','3'
    </xmp>
    <p>
        Fragment zapytania „Nazwa='hacker' AND Haslo='abc'” zostanie zignorowany, ponieważ użycie operatora OR oraz drugiego warunku gdzie '1'='1’ zwraca wartość TRUE dzięki czemu cała klauzula WHERE również jest  prawdziwa. W wyniku tego zwrócone zostaną wszystkie wiersze tabeli a1_uzytkownicy. Znajdująca się w skrypcie instrukcja if($result->num_rows) spowoduje zalogowanie użytkownika, gdyż liczba wierszy będzie różna od zera dzięki czemu warunek zostanie spełniony. 
    </p>
    <p>
       Innym sposobem w jaki można uzyskać dostęp do serwisu jest wysłanie przez formularz w polu hasła następującego ciągu: ' UNION SELECT 1, 'hacker','2 . Całe zapytanie będzie wyglądać następująco:
    </p>
    <xmp class="prettyprint">
SELECT Haslo, Nazwa, Id FROM a1_uzytkownicy
WHERE Nazwa='' AND Haslo='' UNION SELECT 1, 'hacker','2'
    </xmp>
    <p>
        W tym przypadku efektem będą zatem dwie instrukcje połączone klauzulą UNION. Wynikiem tego będzie połączenie pustej tabeli z tabelą o jednym wierszu w której w wartościami kolejnych kolumn będą wartości „1”,  „hacker”,  „2”. Instrukcja if($result->num_rows)  ostanie spełniona, gdyż poprzez klauzule UNION całe zapytanie zwróciło wynikowy wiersz. Dzięki takiej konstrukcji zalogowany do serwisu zostanie użytkownik o identyfikatorze „1” ($row[0]), nazwie „hacker” ($row[1]) oraz haśle „1” ($row[2]).
    </p>
</div>