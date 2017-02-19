<header>
    <div class="wrapper">
        <h2> SQL Injections </h2>
        <h3> (Dostęp do ukrytych danych)</h3>
        <div class="navbar">
            <img src="style/images/logo_polsl_aei.png">
        </div>
    </div>
    <div class="panel">
        <button data-button="a1-sqli-lesson2-1">Opis zadania</button>
        <button data-button="a1-sqli-lesson2-2">Lekcja</button>
        <button data-button="a1-sqli-lesson2-3">Kod Źródłowy</button>
        <button data-button="a1-sqli-lesson2-4">Analiza podatności</button>
    </div>
</header>
<div class="blankspace" style="height:180px;"></div>
<div data-button="a1-sqli-lesson2-1" class="workspace">
    <h2> Dostęp do ukrytych danych</h2>
    <p>
        W aplikacjach internetowych błędy typu SQL Injection pozwalają również na wyświetlenie niepożądanych danych. Wynika to z możliwością manipulowania zapytaniami SQL przez atakującego witrynę.  Przeanalizowany zostanie przykład portalu wyświetlającego tytuły wiadomości, które posiadają odpowiednie pole w tabeli z informacją czy są aktywne, czy ukryte. Instrukcja SQL tworząca tabelę wyglądała by następująco:
    </p>
    <xmp class="prettyprint">
CREATE TABLE News
(
Id INTEGER PRIMARY KEY,
Tytul TEXT NOT NULL,
Tekst TEXT NOT NULL,
Kategoria INTEGER NOT NULL,
Aktywna BIT(1) NOT NULL
)
    </xmp>
    <p>
        Dodatkowym polem jest pole Kategoria, do którego przyporządkujemy poszczególne wiadomości tak aby w każdej znalazła zarówno się aktywna jak i nieaktywna wiadomość. Oznaczeniem aktywnej wiadomości będzie wartość 1 w polu aktywna. Wypełnienie tabeli przykładowymi wartościami wykonujemy następującym zapytaniem SQL:
    </p>
    <xmp class="prettyprint">
INSERT INTO a1_wiadomosci VALUES(1, 'Pierwszy przykładowy tytuł', '', 1, 1);
INSERT INTO a1_wiadomosci VALUES(2, 'Drugi przykładowy tytuł', '', 2, 0);
INSERT INTO a1_wiadomosci VALUES(3, 'Trzeci przykładowy tytuł', '', 2, 1);
INSERT INTO a1_wiadomosci VALUES(4, 'Czwarty przykładowy tytuł', '', 1, 1);
INSERT INTO a1_wiadomosci VALUES(5, 'Piąty przykładowy tytuł', '', 1, 0);
INSERT INTO a1_wiadomosci VALUES(6, 'Szósty przykładowy tytuł', '', 2, 1);
    </xmp>
    <p>
        Użytkownik po wejściu na stronę będzie miał dostępną listę kategorii dzięki której będzie w stanie wybrać i wyświetlić odpowiednie tytuły danych aktywnych wiadomości. Wiadomości nieaktywne nie powinny być w ogóle wyświetlane. Celem atakującego jest uzyskanie informacji o wiadomościach, które nie są prezentowane użytkownikom na witrynie.  
    </p>
</div>
<div data-button="a1-sqli-lesson2-2" class="workspace lesson">
    <h2> Badanie podatności</h2>
        <div class="lessonContent">
            <?php include('source/functions.php'); ?>
        </div>
</div>
<div data-button="a1-sqli-lesson2-3" class="workspace">
    <h2> Kod źródłowy</h2>
    <div>
        <h3> Lista wiadomości </h3>
        <xmp class="prettyprint">
<?php echo file_get_contents( "source/code.php" ); ?>
        </xmp>
        <p>
            Formularz wyboru kategorii posiada pole typu SELECT, w którym pobierane są nazwy i identyfikatory kategorii znajdujące się w tabeli $categories. Dodatkowo pierwszą opcją jest wartość „Wszystkie”, przez co po wyświetleniu strony głównej wyświetlą się domyślnie wszystkie dostępne wiadomości. Po wybraniu z listy odpowiedniej kategorii  i wysłaniu formularza – jej identyfikator jest przekazywany w żądaniu metodą GET przy użyciu parametru cat. Aktywna kategoria jest sprawdzana za pomocą instrukcji warunkowej i wybrana poprzez wykorzystanie atrybutu selected.  Pod formularzem znajduje się pętla wyświetlająca listę wiadomości pobierająca dane pobrane z bazy danych przygotowanych przez wywoływany przez witrynę skrypt php.  

        </p>
        <h3> Funcje Pobrania danych</h3>
        <xmp class="prettyprint">
<?php echo file_get_contents( "source/functions.php" ); ?>
        </xmp>
    </div>
    
        <p>
            W funkcji wyświetlającej zawartość strony widzimy tablicę z informacjami dotyczącymi kategorii, która zostanie pobrana w formularzu na stronie. Następnie zostaje wywołana funkcja  getData, która odpowiada za pobranie wiadomości z bazy.
        </p>
        <p> 
            W pierwszym kroku sprawdzamy czy przekazany został parametr cat i czy nie jest pustym ciągiem znaków. Jeśli nie, to do zmiennej $catQuery umieszczana jest fragment zapytania SQL oraz pobrana wartość parametru w postaci: AND kategoria = {$_REQUEST['cat']} . Zapytanie to umożliwi filtrowanie wiadomości należących dla danej kategorii. Jeśli parametr cat nie jest pobrany zmienna $catQuery  pozostanie pusta. Powyższe zapytanie łączone zostaje z instrukcją SELECT * FROM a1_wiadomosci WHERE aktywna = 1 . Całe zapytanie SQL w przypadku podania identyfikatora kategorii przyjmuje postać:
        </p>
        <xmp class="prettyprint">
SELECT * FROM a1_wiadomosci
WHERE aktywna = 1 AND kategoria = {$_REQUEST['cat']} 
        </xmp>
        <p>
            Zapytanie zostaje wywoływane poprzez instrukcję $result = $conn->query($query), a następnie wyniki zostają zapisane za pomocą funkcji fetch_all do tablicy dwuwymiarowej, do której odwołuje się pętla pod formularzem na stronie wyświetlającej wiadomości.
        </p>
</div>
<div data-button="a1-sqli-lesson2-4" class="workspace">
    <h2> Analiza podatności</h2>
    <p>
        Po analizie kodu źródłowego zauważamy, że wartość parametru cat pobierana jest z tablicy $_REQUEST i wstawiana bezpośrednio do zapytania SQL bez poprzedniej weryfikacji. Zastosowanie takiego rozwiązania powoduje lukę bezpieczeństwa, przez którą atakujący jest w stanie wyświetlić wszystkie wiadomości z tabeli włącznie z tymi, które w kolumnie aktywna  mają wartość 0.
    </p>
    <p>
        Aby uzyskać dostęp do wszystkich wiadomości w adresie url w miejscu parametru cat należy wpisać wartość 1 OR 1=1. 
    </p>
    <p>
        Aby przeglądarka odpowiednio zinterpretowała tą instrukcję należy najpierw dokonać konwersji znaków specjalnych na odpowiednie wartości. W tym przypadku spacja zostanie zmieniona na ciąg %20.  Poniżej znajduje się lista zastrzeżonych znaków wraz z ich kodem procentowym do zakodowania w adresie url. Wywołany adres url zatem powinien mieć następującą postać:
    </p>
    <xmp class="prettyprint">
index.php?cat=1%20OR%201=1    
    </xmp>
    <p>
        Stosując takie wstrzyknięcie w funkcji getData pojawi się zatem następujące zapytanie:
    </p>
    <xmp class="prettyprint">
SELECT * FROM a1_wiadomosci 
WHERE aktywna = 1 AND Kategoria = 1 OR 1=1
    </xmp>
    <p>
        Podobnie jak w przypadku „Ataku na logowanie” tutaj pierwsza część warunku WHERE zostanie zignorowana, gdyż druga część będzie zawsze stwierdzeniem prawdziwym (1=1). Wyświetlone zostaną zatem wszystkie wiadomości z tabeli a1_wiadomości nawet te, które posiadają status nieaktywnych.
    </p>
</div>