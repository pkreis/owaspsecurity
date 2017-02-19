<header>
    <div class="wrapper">
        <h2> Cross-site scripting </h2>
        <h3> (Skrypty międzyserwisowe)</h3>
        <div class="navbar">
            <img src="style/images/logo_polsl_aei.png">
        </div>
    </div>
    <div class="panel">
        <button data-button="a3-xss-lesson1-1">Opis zadania</button>
        <button data-button="a3-xss-lesson1-2">Lekcja</button>
        <button data-button="a3-xss-lesson1-3">Kod Źródłowy</button>
        <button data-button="a3-xss-lesson1-4">Analiza podatności</button>
    </div>
</header>
<div class="blankspace" style="height:180px;"></div>
<div data-button="a3-xss-lesson1-1" class="workspace">
    <h2> Atak typu Stored XSS</h2>
    <p>
        Księga gości jest typową aplikacją, która jest podatna na błędy typu Cross Site Scripting. Jest to efektem braku filtrowania wpisywanych danych do bazy danych. Utworzona została tabela o nazwie a3_ksiega_gosci. Zawiera on kolumny id, autor, treść oraz data. Zapytanie SQL stworzenia tabeli wygląda następująco:
    </p>
    <xmp class="prettyprint">
CREATE TABLE `guestbook`
(
`id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
`autor` VARCHAR(45) NOT NULL,
`tresc` TEXT NOT NULL,
`data` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY(`id`)
)
    </xmp>
    <p>
        Danymi wprowadzanymi przez użytkownika w formularzu będą pola autor oraz treść. Pole id będzie automatycznie zwiększane dla każdego wpisu, dzięki modyfikatorowi AUTO_INCREMENT, a data będzie również automatycznie wypełniana dzięki funkcji CURRENT_TIMESTAMP.
    </p>
    <p>
        Celem atakującego witrynę jest zmiana struktury strony oraz wprowadzenie własnych skryptów do witryny.
    </p>
</div>
<div data-button="a3-xss-lesson1-2" class="workspace lesson center">
    <h2> Badanie podatności</h2>
        <div class="lessonContent">
            <?php include('source/functions.php'); ?>
        </div>
</div>
<div data-button="a3-xss-lesson1-3" class="workspace">
<h2> Kod źródłowy</h2>
    <h3> Formularz dodawania wpisów</h3>
    <xmp class="prettyprint">
<?php echo file_get_contents( "source/code.php" ); ?>
    </xmp>
    <p>
        Po wyświetleniu strony głównej pojawia się formularz dodawania wpisów do księgi. Przekazuje on parametr action o wartości addPost, która wywoła odpowiednią funkcję w serwisie odpowiedzialną za dodanie do bazy wpisu. Poprzez metodę POST wysyła nazwę autora i treść wiadomości, które pobiera z formularz. Pod formularzem znajduje się przycisk, który za pomocą adresu url wysyła parametr action o wartości showPosts i wyświetla listę wpisów. Nad formularzem dodawania znajduje się kod wyświetlający komunikat zapisany w zmiennej sesji. 
    </p>
    <h3> Lista wpisów księgi gości</h3>
    <xmp class="prettyprint">
<?php echo file_get_contents( "source/guestbook.php" ); ?>
    </xmp>
    <p>
        Na samej górze wyświetlamy komunikat zapisany w sesji ustawiany przez funkcje skryptu. Poniżej znajduje się pętla foreach wyświetlająca listę wpisów księgi gości  pobieraną z bazy danych obsłużoną przez odpowiednią funkcję php znajdującą się w skrypcie aplikacji. Pod listą umiejscowiony jest przycisk, który przenosi na stronę główną, gdzie znajduje się formularz dodawania wpisu.
    </p>
    <h3> Funkcje dodawania wpisu do bazy danych</h3>
    <xmp class="prettyprint">
<?php echo file_get_contents( "source/functions.php" ); ?>
    </xmp>

    <p>
        W funkcji dodającej wpis do bazy w pierwszej kolejności sprawdzane jest czy wszystkie pola formularza zostały wypełnione podczas wysyłania formularza. Jeśli są prawidłowe wpisuje wartości pól autor i treść do zmiennych $name oraz $message. 
    </p>
    <p>
        Wartości tych zmiennych są bezpośrednio przypisywane do odpowiednich kolumn w bazie bez weryfikacji ich zawartości. Zapytanie SQL dodające wpis do bazy wygląda następująco:
    </p>
    <xmp class="prettyprint">
INSERT INTO a3_ksiega_gosci (autor,tresc) 
VALUES ('$name', '$message' )
    </xmp>
    <p>
        Zapytanie jest wykonywane za pomocą funkcji query($query), po czym zapisywany jest komunikat sesyjny z informacją czy dodanie do bazy zostało zakończone sukcesem.
    </p>
    <p>
        Funkcja showPosts pobiera do zmiennej $gbdata wpisy pobrane za pomocą funkcji getPosts. Dane pobierane są za pomocą zapytania SQL: 
    </p>
    <xmp class="prettyprint">
SELECT autor, tresc, data FROM a3_ksiega_gosci
    </xmp>
    <p>
        Jeśli zapytanie zostanie wykonanie pomyślnie dzięki metodzie query oraz uda się pobrać wyniki za pomocą metody fetchAll funkcja zwraca tablicę zawierające wiersze wynikowe zapytania. W przeciwnym wypadku zwracana jest pusta tablica, dzięki czemu nie trzeba sprawdzać czy zmienna $gbdata nie jest pusta. 
    </p>
</div>
<div data-button="a3-xss-lesson1-4" class="workspace">
    <h2> Analiza podatności</h2>
    <p>
        Powyższy kod jest w pełni podatny na ataki typu Cross Site Scripting. Wartości z formularza są bezpośrednio wprowadzane do bazy danych bez żadnej weryfikacji, przez co każdy może wprowadzić dowolny kod interpretowany przez przeglądarkę internetową. Można zatem dodać kod HTML, CSS, JavaScript itp. do serwisu www. Najprostszym przykładem jest wpisanie zawartości treści w znacznik &lt;b&gt;treść&lt;/b&gt; , aby zobaczyć na liście pogrubioną wysłaną wiadomość do księgi. Każdy użytkownik ma zatem możliwość ingerencji w strukturę witryny
    </p>
    <p>
        Jednym z najprostszym sposobów do uszkodzenia szablonu strony jest wpisanie w sekwencji: <em>&lt;!--</em>
    </p>
    <p>
        Jest to element rozpoczynający komentarz w języku HTML. Zniknie zatem cała zawartość szablonu który znajduje się poniżej danego wpisu, ponieważ przeglądarka nie interpretuje niczego co znajduje się pomiędzy znacznikami &lt;!--  -->. 
    </p>
    <p> 
        Zamiast wyłączania fragmentu witryny atakujący może przekierować użytkownika na inną witrynę. Wystarczy, iż w jednym z pól wpisze następującą treść:
    </p>
    <xmp class="prettyprint">
<meta http-equiv="refresh" content="0;URL='https://www.polsl.pl/'">
    </xmp>
    <p>
        Pomimo, iż znacznik meta powinien znajdować się w skecji &lt;head> to i tak większość przeglądarek wykona to polecenie i przekieruje na określony adres internetowy. 
    </p>
    <p>
        Innym sposobem zmienienia struktury strony jest modyfikacja arkusza stylów CSS.  Jednym z przykładów może być dopisanie tekstu pod głównym nagłówkiem:
    </p>
    <xmp class="prettyprint">
<style type="text/css">h2:after{content:"- witryna zaatakowana!"}</style>
    </xmp>
    <p>
        Jak widać na stronie jest możliwość manipulowania zarówno kodem HTML jak i CSS, zatem również można uruchomić skrypt JavaScript. Najprostszym do zauważenia efektem będzie zastosowanie prostego powiadomienia:
    </p>
    <xmp class="prettyprint">
<script>alert("Witryna zaatakowana")</script>
    </xmp>
    <p>
        Bezpośrednio po wywołaniu witryny na naszym ekranie ukaże się komunikat Witryna zaatakowana. W ten sposób można wykonać dowolny skrypt w języku JavaScript, dzięki czemu atakujący może wykonać dużo bardziej szkodliwe skrypty wobec zaprojektowanej aplikacji internetowej.
    </p>
</div>





