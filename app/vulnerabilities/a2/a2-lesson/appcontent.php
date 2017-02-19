<header>
    <div class="wrapper">
        <h2> Przechwytywanie sesji </h2>
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
    <h2> Session hijacking</h2>
    <p>
        Przechwytywanie sesji (ang. session hijacking) polega na przejęciu identyfikatora sesji, a następ-nie użycie go przez włamywacza podszywając się pod użytkownika. 
    </p>
    <p>
        Przeanalizowany zostanie przykład logowania do serwisu użytkownika. Wykorzystany zostanie kod źródłowy zastosowany w poprawionej wersji logowania z poprzedniego roz-działu. Dane logowania uzupełnione zostały w tabeli następującym zapytaniem: 
    </p>
    <xmp class="prettyprint">
INSERT INTO `a1_uzytkownicy` (`Id`, `Nazwa`, `Haslo`) VALUES
(1, 'login1', 'haslo1'),
(2, 'login2', 'haslo2'),
(3, 'login3', 'haslo3');
    </xmp>
    <p>
        Użytkownik poprzez formularz logowania uzyskuje uwierzytelnienie w serwisie. Po po-myślnym procesie wyświetlany zostaje komunikat o pomyślnym zalogowaniu oraz wy-świetlony jest identyfikator sesji. Celem atakującego jest wykorzystanie poznanego iden-tyfikatora sesji i zalogowanie się do serwisu bez potrzeby znajomości loginu oraz hasła.
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
            Formularz logowania metodą POST wysyła parametry przekazane z pól nazwy użytkow-nika i hasła. Za pomocą parametru action o wartości login wywoływana zostaje funkcja odpowiedzialna za weryfikacje danych i autoryzowanie użytkownika. 
        </p>
        <h3> Funcje aplikacji</h3>
        <xmp class="prettyprint">
<?php echo file_get_contents( "source/functions.php" ); ?>
        </xmp>
        <p>
            Analiza kodu źródłowego weryfikacji danych logowania przedstawiona została w roz-dziale „Atak na logowanie”. Zastosowana wersja w tym przykładzie jest już zabezpieczo-na przed atakami SQL Injection omawiane w rozdziale sposobu obrony przed tą podatno-ścią bezpieczeństwa.
        </p>
        <p>
            W funkcji odpowiadającej za wyświetlenie zawartości strony została dodatkowo do zmiennej $session przypisana wartość identyfikatora sesji korzystając z poniższej meto-dy:
        </p>
        <xmp class="prettyprint">
$session = session_id();
        </xmp>
        <p>
            W szablonie strony dostępnej po zalogowaniu została więc dodana linia odpowiadająca za wyświetlenie tej zawartości:
        </p>
        <xmp class="prettyprint">
<p>Idenytifkator sesji zapisany w ciasteczu: <b>< ?php echo $session; ?></b></p>
        </xmp>
</div>
<div data-button="a1-sqli-lesson1-4" class="workspace">
    <h2> Analiza podatności</h2>
    <p>
        Jeśli serwis działa na nieszyfrowanym protokole HTTP, identyfikator można podsłuchać odpowiednim programem analizującym ruch sieciowy (np. WireShark). Podłączając się do publicznej sieci bezprzewodowej lub nawet w sieci lokalnej atakujący może podejrzeć transmisje i wychwycić poszukiwane dane. W tym przypadku było by to ciasteczko z od-powiednią wartością identyfikatora sesji. 
    </p>
    <p>
        <img src="vulnerabilities/a2/a2-lesson/images/1.png" style="max-width:60%; display:table; margin:auto auto auto auto;">
    </p>
    <p>
        W celu symulacji dwóch odrębnych sesji możemy wykorzystać dwie różne przeglądarki bądź uruchomić drugie okno jednej przeglądarki w trybie gościa. Zalogujmy się zatem w jednym oknie do serwisu poprzez przygotowany formularz. Wyświetlony identyfikator sesji kopiujemy do schowka.
    </p>
    <p>
         W drugim kliencie trzeba zatem podmienić wartość sesji zapisaną w ciasteczku PHPSESSID. W różnych przeglądarkach możemy zastosować gotowe wtyczki umożliwia-jące podmianę tej wartości. W przypadku Google Chrome jedną z nich jest wtyczka Edit-ThisCookie.  Uruchamiamy wtyczkę, która nam wyświetli listę ciasteczek. Jedyne co po-zostało to podmiana wartości ciasteczka. Po wprowadzeniu wartości zapisanej w schowku uzyskamy dostęp do serwisu bez konieczności posiadania danych logowania.
    </p>
    <p>
        <img src="vulnerabilities/a2/a2-lesson/images/2.jpg" style="max-width:30%; display:table; margin:auto auto auto auto;">
    </p>
</div>