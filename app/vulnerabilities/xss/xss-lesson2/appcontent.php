<header>
    <div class="wrapper">
        <h2> Cross-site scripting </h2>
        <h3> (Skrypty międzyserwisowe)</h3>
        <div class="navbar">
            <img src="style/images/logo_polsl_aei.png">
        </div>
    </div>
    <div class="panel">
        <button data-button="a3-xss-lesson2-1">Opis zadania</button>
        <button data-button="a3-xss-lesson2-2">Lekcja</button>
        <button data-button="a3-xss-lesson2-3">Kod Źródłowy</button>
        <button data-button="a3-xss-lesson2-4">Analiza podatności</button>
    </div>
</header>
<div class="blankspace" style="height:180px;"></div>
<div data-button="a3-xss-lesson2-1" class="workspace">
    <h2> Atak typu Reflected XSS</h2>
    <p>
        Drugim rodzajem tego rodzaju błędu jest atak wykonywany jednokrotnie podczas wykonywania żądania zwykle za pomocą odpowiednio spreparowanego adresu URL.
    </p>
    <p>
        Przykładem serwisu podatnego na atak będzie wyszukiwarka tytułów wpisów przykładowych wiadomości. Dane będą pobierane z tabeli a1_wiadomosci, która została już wykorzystana w poprzednich podatnościach. Tabela ta została utworzona zapytaniem SQL:
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
        Dostępne do wyszukiwania będą wiadomości z wszystkich kategorii, które w kolumnie aktywna posiadają wartość 1. Użytkownik w serwisie będzie miał dostępne pole tekstowe, w którym będzie wpisywana fraza wyszukiwania oraz przycisk wysyłający to żądanie. Pod formularzem wyświetlana jest lista odpowiadających wiadomości.
    </p>
    <p>
        Celem atakującego jest wywołanie skryptu za pomocą spreparowanego URL. Warto zwrócić uwagę na to, iż aktualna wersja przeglądarki Google Chrome odrzuca próby takiego ataku, zatem przy testowaniu tej podatności, stosuje się starsze wersje lub inne przeglądarki.
    </p>
</div>
<div data-button="a3-xss-lesson2-2" class="workspace lesson">
    <h2> Badanie podatności</h2>
        <div class="lessonContent">
            <?php include('source/functions.php'); ?>
        </div>
</div>
<div data-button="a3-xss-lesson2-3" class="workspace">
    <h2> Kod źródłowy</h2>
    <h3> Formularz wyszukiwania</h3>
    <xmp class="prettyprint">
<?php echo file_get_contents( "source/code.php" ); ?>
    </xmp>
    <p>
        U góry wyświetlany jest komunikat zapisany w zmiennej sesji ustawiany przez określone funkcje w serwisie. Poniżej znajduje się formularz wyszukiwania wiadomośći. Składa się z pola tekstowego i przycisku wsysającego żądanie. Za pomocą metody GET wysyłany jest parametr search , który jest frazą wyszukiwania.
    </p>
    <p>
        Kolejnym krokiem jest wyświetlenie informacji jaka fraza została wpisana do wyszukiwania. Następuje tutaj sprawdzenie czy przekazano parametr search i jeśli warunek jest prawdą wyświetlana jest wtedy jego wartość.
    </p>
    <p>
        Pod formularzem znajduje się pętla foreach wyświetlająca wszystkie zgodne elementy wyszukiwania. Zawartość tablicy $data jest wypełniana przez funkcje php serwisu.
    </p>
    <h3> Funkcje pobierania danych</h3>
    <xmp class="prettyprint">
<?php echo file_get_contents( "source/functions.php" ); ?>
    </xmp>
    <p>
        W funkcji wywołującej szablon strony zostaje także wywołana funkcja  getData, która odpowiada za pobranie wyszukiwanych wiadomości z bazy danych.
    </p>
    <p>
        Najpierw sprawdzane jest czy parametr search został prawidłowo przesłany. Kolejnym krokiem jest zapisanie do zmiennej $searchQuery ciąg : "tytul LIKE '%{ $_REQUEST['search'] }%' AND ", który jest fragmentem zapytania SQL odpowiedzialnym za filtrację wyników pobranych z bazy według odpowiedniego filtru.  Dodając do tego warunek aktywnej wiadomości kompletne zapytanie wygląda następująco:
    </p>
    <xmp class="prettyprint">
SELECT * FROM a1_wiadomosci
WHERE tytul LIKE '%{$_REQUEST['search']}' AND aktywna = 1 
    </xmp>
    <p>
        Zapytanie zostaje wywoływane poprzez instrukcję query($query) i jeśli zostanie wykonane prawidłowo to za pomocą funkcji fetch_all zapisuje wiersze wynikowe do tablicy dwuwymiarowej, do której odwołuje się pętla pod formularzem wyszukiwania na stronie serwisu.
    </p>
</div>
<div data-button="a3-xss-lesson2-4" class="workspace">
    <h2> Analiza podatności</h2>
    <p>
        Analizując powyższy kod źródłowy zauważamy, iż wartość frazy wyszukiwania jest wysyłana do serwisu poprzez metodę GET, dzięki czemu atakujący jest w stanie przygotować odpowiedni adres URL i skłonić użytkownika do jego odwiedzenia. W odnośniku zakodowany może być złośliwy skrypt, a jako iż w adresie stosuje się procentowe kodowanie niektórych znaków zatem na pierwszy rzut oka ciężko jest wychwycić ukrytą treść. Najprostszym przykładem prezentującym ten typ podatności jest wyświetlenie komunikatu na stronie za pomocą następującego wywołania:
    </p>
    <xmp class="prettyprint">
index.php?search=qwerty<script>alert("Atak XSS")</script>
    </xmp>
    <p> 
        Co po zakodowaniu znaków będzie wyglądać w ten sposób:
    </p>
    <xmp class="prettyprint">
index.php?search=qwerty%3Cscript%3Ealert%28%22Atak%20XSS%22%29%3C%2Fscript%3E
    </xmp>
    <p>
        W ten sposób atakujący może wykonać wiele możliwości odnośnie wykonywanych skryptów. Innym ciekawym rozwiązaniem jest zastosowanie żądania
    </p>
    <xmp class="prettyprint">
index.php?search=qwerty<img src="#" onerror="alert('Atak XSS')" style="display:none">
    </xmp>
    <p>
        Wstawiany jest tutaj nieistniejący obrazek, zatem wykonana zostania instrukcja onerror , w której możliwe jest ukrycie złośliwego skryptu. Dodatkowo struktura strony się nie zmieni, ponieważ obraz został ukryty, zatem atakujący jest w stanie wykonać dowolny skrypt w imieniu użytkownika, który nawet nie zorientuje się o dokonanym ataku. 
    </p>
</div>





