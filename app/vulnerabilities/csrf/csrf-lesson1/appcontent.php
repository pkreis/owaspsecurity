<header>
    <div class="wrapper">
        <h2> Fałszowanie żądań </h2>
        <h3> </h3>
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
    <h2>Fałszowanie żądań</h2>
    <p>
        Przykładem aplikacji podatnej na atak CSRF, może być aplikacja zawierająca program lojalnościowy dla użytkowników serwisu. Każdy członek będzie posiadał własne saldo specjalnych punktów. Użytkownik będzie mógł przekazać swoje punkty innym klientom.  
    </p>
    <p>
        Przykładem aplikacji podatnej na atak CSRF, może być aplikacja zawierająca program lojalnościowy dla użytkowników serwisu. Każdy członek będzie posiadał własne saldo specjalnych punktów. Użytkownik będzie mógł przekazać swoje punkty innym klientom.  
    </p>
    <p>
       Schemat tabeli przedstawiającej dane użytkowników:
    </p>
    <xmp class="prettyprint">
CREATE TABLE a1_użytkownicy
(
Id INTEGER PRIMARY KEY,
Nazwa TEXT NOT NULL,
Haslo TEXT NOT NULL,
Punkty INTEGER UNSIGNED NOT NULL DEFAULT 0
)
    </xmp>
    <p>
       Do standardowych danych logowania dodana została kolumna Punkty o typie liczby całkowitej z ograniczeniem do wartości tylko nieujemnych. Zastosowano modyfikator NOT NULL oraz ustawienie domyślnej wartości na 0.
    </p>
    <p>
       Zawartość tabeli została wypełniona przykładowymi danymi:
    </p>
    <xmp class="prettyprint">
INSERT INTO `a7_uzytkownicy` (`Id`, `Nazwa`, `Haslo`, `Punkty`) VALUES
(1, 'login1', 'haslo1', 100),
(2, 'login2', 'haslo2', 0),
(3, 'login3', 'haslo3', 60);
    </xmp>
    <p>
        Pierwszym elementem strony jest formularz logowania użytkownika. Po zalogowaniu ukazuje się stan konta i przycisk przekierowujący do funkcji przekazania swojej waluty. Po przejściu do ekranu transferu punktów użytkownik zobaczy formularz, w którym wybiera odbiorcę swoich punktów i ilość punktów do przekazania. Po dokonaniu transferu użytkownik otrzymuje informację o prawidłowo lub nieprawidłowo zrealizowanej transakcji. 
    </p>
    <p>
        Celem atakującego jest zakamuflowanie odpowiedniego żądania, które przekaże punkty na swoje konto, przekazując ukryty odnośnik zalogowanemu użytkownikowi w serwisie.
    </p>
    <p>
        <a href="vulnerabilities/csrf/csrf-lesson1/index.php?action=transfer&userid=3&points=10">Wygrałeś 1000zł! Wejdź i odbierz nagrodę!</a>
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
    <h3> Formularz logowania i funkcja logowania</h3>
    <xmp class="prettyprint">
<?php echo file_get_contents( "source/home.php" ); ?>
    </xmp>
    <p>
        W pierwszej kolejności w szablonie sprawdzane jest czy użytkownik jest zalogowany. Jeśli nie jest wyświetlany jest formularz logowania, który wywołuje funkcję logowania poprzez  przekazanie parametru action o wartości login. W serwisie zostanie wywołana funkcja odpowiadająca za proces logowania. 
    </p>
    <p>
        Jeśli natomiast użytkownik jest zalogowany przedstawione na ekranie zostaje stan konta punktów tego danego użytkownika. Poniżej znajdują się dwa przyciski. Pierwszy przekierowuje do funkcjonalności przekazywania punktów innemu użytkownikowi, a drugi służy do wylogowania.
    </p>
    <p>
        Funkcja logowania została wykorzystana z poprawionej wersji aplikacji podatnej na ataki SQL Injection, która była opisywana w jednym z wcześniejszych rozdziałów. Jedyną drobną zmianą jest przypisanie wiersza identyfikatora i nazwy użytkownika do zmiennej sesji
    </p>
    <xmp class="prettyprint">
if($result->num_rows){
  $result->bind_result($haslo, $nazwa, $id);
  $result->fetch();
  $array = array(
    "Nazwa" => $nazwa,
    "Id" => $id,
  );
  sessionMsg("Zalogwano pomyślnie");
  $_SESSION['zalogowany'] = $array  ;
  return LOGIN_OK;
}
    </xmp>    
    <p>
        Po sprawdzeniu istnienia wierszu wynikowego zapisujemy wartości zmiennych $nazwa ora $id do tablicy $array, która zostaje przypisana do zmiennej sesji zalogowany. Zamiast tworzyć nową tabelę i pobierać wartości z metody bind_result można wykorzystać metodę get¬_result, zwracającej wiersz już jako tabelę, jednakże do funkcjonowania tej funkcji potrzebny jest dodatkowo natywny sterownik MySQL (mysqlnd). 
    </p>
    </xmp>    
    <h3> Formularz transferu punktów</h3>
    <xmp class="prettyprint">
<?php echo file_get_contents( "source/transfer.php" ); ?>
    </xmp>
    <p>
        W szablonie strony odpowiedzialnej za transfer punktów znajduje się formularz, który wysyła parametr action o wartości transfer, który wywołuje funkcje w serwisie przekazania punktów dla innego użytkownika. W formularzu z listy rozwijanej wybierany jest użytkownik docelowy, a następnie w polu liczbowym określamy liczbe punktów. 
    </p>
    <p>
        Lista realizowana jest za pomocą znacznika select wyświetlająca swoje opcje w pętli foreach dla wszystkich wierszy znajdujących się w tabeli $users. W polu input o typie number dodatkowo wstawiona jest instrukcja warunkowa, czy wartość zmiennej $ammount jest liczbą całkowitą dodatnią i następnie jej wartość wstawiana jest do atrybutu max. W przeciwnym wypadku wartość znacznika ustalana jest na 0 i nadawany jest atrybut tylko do odczytu readonly='readonly'. 
    </p>
    <h3> Funkcje prezentujące treśc i stan konta</h3>
    <xmp class="prettyprint">
<?php echo file_get_contents( "listings/1.php" ); ?>
    </xmp>
    <p>
        Za wyświetlenie zawartości strony odpowiadają funkcje content oraz getTransferForm. W obu funkcjach do zmiennej $user pobierana jest zapisana w sesji nazwa użytkownika oraz do zmiennej $ammount wynik funkcji pointsAmmount. Funkcja ta przyjmuje jako parametr pobrany z sesji identyfikator użytkownika.  Z bazy danych pobiera wiersz wynikowy wyświetlający ilość punktów użytkownika o danym id i zwraca tą wartość jako wynik funkcji.
    </p>
    <p>
        Obsługą listy użytkowników zajmuje się funkcja getTransferForm. Z bazy danych pobrane zostają wszystkie nazwy użytkowników poza tym, który znajduje się aktualnie w zmiennej sesji zalogowany. Dane te są zapisywane do tablicy $users, która zostanie wykorzystana w szablonie formularza transferu punktów.
    </p>
    <h3> Funkcja transferu punktów </h3>
    <xmp class="prettyprint">
<?php echo file_get_contents( "listings/2.php" ); ?>
    </xmp>
    <p>
        W pierwszej kolejności sprawdzane jest, czy funkcja została wywołana przez zalogowanego użytkownika, w przeciwnym wypadku jej działanie zostanie zakończone. Tym samym sposobem następnie jest sprawdzanie czy do funkcji zostały przekazane parametry userid oraz points. W celu zapewnienia bezpieczeństwa przesłany wartości konwertujemy na typ liczb całkowitych,  a później sprawdzamy czy identyfikator użytkownika jest większy od 0 i liczba punktów większa lub równo 0. 
    </p>
    <p>
        Aby nie dopuścić do sytuacji, w której nastąpi niespodziewany błąd bazy danych i punkty użytkownika zostaną odebrane lecz nie zostaną one przekazane odbiorcy zastosowany został mechanizm transakcji. W ten sposób wszystkie zapytania SQL znajdujące się między nimi zostaną wywołane jako jedna całość. PHP posiada wbudowane interfejsy transakcyjne, zatem w naszym przypadku zapytania SQL znajdują się pomiędzy instrukcjami autocommit(false) oraz commit() wywołanych dla zainicjalizowanego połączenia z bazą.
    </p>
    <p>
        Pierwszym zapytaniem jest zaktualizowanie liczby punktów użytkownika o identyfikatorze znajdującym się w zmiennej sesji $_SESSION['zalogowany']['Id'], a drugie zapytanie to dodanie tych punktów do użytkownika wskazanego w formularzu transferu punktów.
    </p>
    <p>
        Po prawidłowej realizacji przekazania punktów ustawiany jest komunikat o pomyślnym przekazaniu punktów. 
    </p>
</div>
<div data-button="a1-sqli-lesson1-4" class="workspace">
    <h2> Analiza podatności</h2>
    <p>
        Pomimo, iż aplikacja jest zabezpieczona przed nieuprawnionymi działaniami użytkowników, serwis jest jednak podatny na atak CSRF. Jeśli użytkownik jest zalogowany w serwisie i rozpoczął przeglądanie innych stron czy też odbiera pocztę elektroniczną jest możliwość, iż atakujący skłoni użytkownika do odwiedzenia odpowiednie przygotowanego żądania, które uruchomi proces przekazania punktów na konto atakującego. Odnośnik zawierający odpowiednie parametry żądania może wyglądać następująco:
    </p>
    <xmp class="prettyprint">
http://adres.serwisu/index.php?action=transfer&userid=3&points=10
    </xmp>
    <p>
        Wystarczy zatem, iż atakujący umieści powyższy adres URL do znacznika odwołania &lt;a>, który po wywołaniu przekaże punkty na swoje konto. Innym sposobem, jest zastosowanie znacznika obrazu &lt;img> o ścieżce wywołania żądania. Dodając do tego styl CSS opisujący, iż obraz ma zostać ukryty spowoduje to wykonanie żądania w imieniu użytkownika bez jego wiedzy, gdzyż strona internetowa na której znajduje się ten znacznik nie ujawnia ukrytego szkodliwego na zewnątrz. Kod znacznika obrazujący ten przykład mógłby wyglądać następująco:
    </p>
    <xmp class="prettyprint">
<img src=" http://adres.serwisu/index.php?action=transfer&userid=3&points=10" style="display: none;">
    </xmp>
    <p>
        Najczęstszym sposobem wykorzystywanym przez atakujących jest umieszczenie żądania w wiadomości e-mail, gdyż użytkownicy często nieświadomi  niebezpieczeństwa klikają w odnośniki o treści np. „Wygrałeś 1000zł! Wejdź i odbierz nagrodę!”
    </p>
    <p>
        Warunkiem działania tego ataku jest jednak to, iż użytkownik musi być zalogowany w tym serwisie oraz że ma wystarczającą ilość punktów. Włamywacze podszywają się zatem za użytkownika i wywołują operacje w jego imieniu, dlatego ciężko czasem również udowodnić użytkownikowi swoją niewinność.
    </p>
</div>