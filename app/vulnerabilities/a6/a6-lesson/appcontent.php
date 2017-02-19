<header>
    <div class="wrapper">
        <h2> Szyfrowanie hasła </h2>
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
        Analizowany zostanie przykład aplikacji, w której użytkownik może utworzyć nowe kon-to, a następnie się zalogować. Po wejściu na stronę wyświetli się formularz logowania oraz odnośnik przekierowujący do rejestracji. 
    </p>
    <p>
        Poniżej znajduje się dodatkowa funkcjonalność zwracająca identyfikator wybranego z listy użytkownika. Można założyć, iż nie jest to poufna dana i każdy może ją wyświetlić np. w celu głosowania na użytkowników w formie id. 
    </p>
    <p>
        Formularz rejestracji dodaje użytkowników do utworzonej w bazie tabeli a6_użytkownicy. Schemat utworzenia tej tabeli w  bazie danych prezentuje się następująco:
    </p>
    <xmp class="prettyprint">
CREATE TABLE `a6_uzytkownicy` (
  `Id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `Nazwa` varchar(20) NOT NULL UNIQUE KEY,
  `Haslo` varchar(30) NOT NULL
)
    </xmp>
    <p>
        Identyfikator jest automatycznie zwiększany podczas dodawania użytkownika. Dodatko-wo kolumna Nazwa posiada unikalny klucz, dzięki czemu nie ma możliwości zastosowa-nia w bazie dwóch użytkowników o takim samym loginie. Tabela została uzupełniona przykładowymi danymi użytkowników.
    </p>
    <xmp class="prettyprint">
INSERT INTO `a6_uzytkownicy` (`Id`, `Nazwa`, `Haslo`) VALUES
(1, 'login1', 'haslo1'),
(2, 'login2', 'haslo2'),
(3, 'login3', 'haslo3');
    </xmp>
    <p>
        `Zarówno logowanie jak i rejestracja zabezpieczona jest przed atakami typu SQL Injec-tion. Celem atakującego jest zalogowanie się do serwisu zdobywając poufne dane logo-wania. 
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
        <h3> Formularz logowania, rejestracji i sprawdzenia identyfikatora</h3>
        <xmp class="prettyprint">
<?php echo file_get_contents( "source/code.php" ); ?>
        </xmp>
        <p>
            Formularz odpowiedzialny za uwierzytelnienie użytkownika zawiera pola input wysyła-jący do skryptu aplikacje wartości nazwy użytkownika i hasła. Przekazuje także parametr action o wartości login, poprzez który wywołuje funkcje weryfikacji danych i logowanie użytkownika. 
        </p>
        <p>
            Poniżej znajduje się odnośnik, który w parametrze action wysyła wartość registerForm. W tym przypadku aplikacja wczyta szablon strony z formularzem rejestracyjnym użytkownika. 
        </p>
        <p>
            U dołu strony znajduje się drugi formularz z polem typu select. Wartościami opcj tego znacznika są nazwy użytkowników pobrane w pętli foreach z tablicy $users. Po wysłaniu formularze przeka-zuje metodą GET wartość getId parametru action w celu wywołania funkcji odpowiadającej za sprawdzenie identyfikatora wskazanego użytkownika.
        </p>
        <xmp class="prettyprint">
<?php echo file_get_contents( "source/register.php" ); ?>
        </xmp>
        <p>
            Formularz rejestracji zrealizowany jest na identycznej zasadzie jak formularz logowania, z tą różnicą, iż wartością parametru action jest register. Wywoływana jest zatem funkcja w serwisie odpowiadająca za dodanie użytkownika do bazy.
        </p>
        <h3> Funcje aplikacji</h3>
        <xmp class="prettyprint">
<?php echo file_get_contents( "source/functions.php" ); ?>
        </xmp>
        <p>
            Zarówno w logowaniu jak i rejestrowaniu użytkowników na stronie, zastosowane zapyta-nia parametryzowane. Analiza ich działania została opisana w rozdziale 4.1.4 odnośnie sposobów obrony przed atakami SQL Injection. W przypadku funkcji logującej wywołana zostaje zapytanie:
        </p>
        <xmp class="prettyprint">
SELECT Haslo, Nazwa, Id FROM a6_uzytkownicy WHERE Nazwa=? AND Haslo=?
        </xmp>
        <p>
            Natomiast zapytanie SQL dla rejestracji nowego użytkownika prezentuje się następująco:
        </p>
        <xmp class="prettyprint">
INSERT INTO a6_uzytkownicy (Nazwa, Haslo) VALUES (?,?)
        </xmp>
        <p>
            Zapytania przygotowywane są metodą prepare($query), później przypisywane do nich są parametry przekazane funkcją bind_param("ss", $user, $pass), po czym wykonywane są instrukcją execute().
        </p>
        <p>
            W funkcji sprawdzającej identyfikator w pierwszej kolejności bezpośrednie przypisanie otrzymanej metodą POST wartości z pola username do zmiennej $user. Kolejnym krokiem jest przypisanie tej wartości do zapytania SQL wykonującej filtracje identyfikatora według nazwy użytkownika:
        </p>
        <xmp class="prettyprint">
$query = "SELECT Id FROM a6_uzytkownicy WHERE Nazwa='$user'";
        </xmp>
        <p>
           Po wykonaniu zapytania i sprawdzeniu istnienia wierszy wynikowego identyfikator zapi-sywany jest w odpowiednim komunikacie, który wyświetli się po przesłaniu formularza przez użytkownika.
        </p>
</div>
<div data-button="a1-sqli-lesson1-4" class="workspace">
    <h2> Analiza podatności</h2>
    <p>
        Pomimo, iż logowanie i rejestracja są zabezpieczone na podatność wstrzyknięć zapytań, to funkcja odpowiedzialna za wyświetlanie identyfikatora użytkownika już nie. By doko-nać ataku wystarczy korzystając z narzędzi developerskich przeglądarki zmienić wartość jednego z pól opcji formularza. W miejsce nazwy użytkownika w polu value możemy wpisać następującą instrukcję:
    </p>
    <xmp class="prettyprint">
' UNION SELECT Haslo FROM a6_uzytkownicy WHERE Nazwa='login3
    </xmp>
    <p>
        Całe zapytanie przesyłane do bazy dany przyjmie postać:
    </p>
    <xmp class="prettyprint">
SELECT Id FROM a6_uzytkownicy WHERE Nazwa='' 
UNION SELECT Haslo FROM a6_uzytkownicy WHERE Nazwa='login3'
    </xmp>
    <p>
        Efektem tego zamiast wyświetlenia identyfikatora danego użytkownika zostanie wyświe-tlone hasło użytkownika login3. Posiadając tą informację atakujący może już bez pro-blemu zalogować się do systemu jako dowolny użytkownik poznając przy tym poufną daną jaką jest jego hasło.
    </p>
    <p>
        Jak widzimy przechowując hasło w postaci nieszyfrowanej daje możliwości nie tylko ataku w tym serwisie, ale także umożliwi próbę przejęcia konta użytkownika na innych serwisach, w których użytkownik wykorzystał te same dane logowania. 
    </p>
</div>