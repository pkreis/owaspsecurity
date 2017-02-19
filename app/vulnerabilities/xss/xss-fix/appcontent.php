<header>
    <div class="wrapper">
        <h2> Cross Site Scripting </h2>
        <h3> (Zabezpieczenie)</h3>
        <div class="navbar">
            <img src="style/images/logo_polsl_aei.png">
        </div>
    </div>
    <div class="panel">
        <button data-button="a3-fix-fix-1">Wstęp</button>
        <button data-button="a3-fix-fix-2">Usunięcie znaczników</button>
        <button data-button="a3-fix-fix-3">Zamiana znaków specjalnych na encje</button>
        <button data-button="a3-fix-fix-4">Zabezpieczona aplikacja</button>
    </div>
</header>
<div class="blankspace" style="height:180px;"></div>
<div data-button="a3-fix-fix-1" class="workspace">
    <h2> Wstęp</h2>
    <p>
        Ataki Cross Site Scripting powstają poprzez bezpośrednie wstawianie danych z zewnętrznych źródeł. Tworząc aplikacje internetową należy zatem przyjąć, iż dane pochodzące z zewnątrz mogą być niepoprawne i złośliwe. Najlepszym sposobem zabezpieczenia się jest zatem założenie, iż wszelkie dane wstawiane do kodu strony są niezaufane i należy poddać je weryfikacji. W takiej sytuacji pozbywamy się zarówno zagrożeń wewnętrznych jak i zewnętrznych, niezależnie czy administrator czy włamywacz modyfikuje dane w serwisie.
    </p>
</div>
<div data-button="a3-fix-fix-2" class="workspace">
    <h2>Usunięcie znaczników</h2>
        <p>
            Najbardziej podstawowym sposobem zabezpieczenia się jest całkowite usunięcie znaczników z otrzymanego ciągu. Można to robić na bazie wyrażeń regularnych lub dedykowanych funkcji.
        </p>
        <p>
            Wyrażenie regularne ma na celu walidacje wprowadzanych danych. Zadaniem programisty jest zaprojektowanie określonego wzorca po czym funkcja sprawdza poprawność wprowadzonych danych z wprowadzonym wzorcem.
        </p>
        <p>
            Funkcja preg_match() jest podstawową funkcją php dotyczącą wyrażeń regularnych. Pierwszym argumentem jest wzorzec sprawdzania, a drugim jest źródło treści do którego zostanie wykonana weryfikacja na podstawie wzorca.  
        </p>
        <p>
            Stosując zatem poniższe zapytanie
        </p>
        <xmp class="prettyprint">
if(preg_match('/^[a-zA-Z0-9\.\,\s ]+$/', $_REQUEST['search']))
        </xmp>
        <p>
            Zezwalamy  na użycie tylko znaków a-z , A-Z , 0-9, kropki, przecinka  i spacji. Oczywiście listę dozwolonych znaków należało by rozszerzyć o polskie znaki czy inne znaki specjalne, które nie wpłynęły by na możliwość ingerencji w kod źródłowy. Jednakże takie wywołani uniemożliwi już wprowadzanie takiego kodu jak &lt;script>alert("Atak XSS")&lt;/script> jednakże uniemożliwi wykorzystanie tych znaków przez użytkowników, którzy nie mają złych celów.
        </p>
        <p>
            PHP posiada również dedykowaną funkcję strip_tags, która automatycznie usuwa znaczniki. Przykładowe wywołanie mogłoby wyglądać nasępująco:
        </p>
        <xmp class="prettyprint">
echo strip_tags($p['autor']);
echo strip_tags($p['tresc']);
        </xmp>
        <p>
            Dzięki temu dane pobrany przykładowo z bazy danych od razu będą pozbawione znaczników, jednakże tak jak poprzednio chcąc zapisać nierówność matematyczną nie będziemy w stanie, gdyż funkcja ta zignoruje znak < oraz >
        </p>
        <p>
            Jeśli chcemy jednak dopuścić część znaczników HTML stosuje się czarne lub białe listy. Czarna lista zawiera znaczniki zabronione, które zostaną usunięte w kodzie wynikowym. Rozwiązanie to jest jednak jest trudno poprawnie zrealizować, gdyż trudno sporządzić pełną listę groźnych znaczników, co wiąże się z błędem bezpieczeństwa, gdyż powstają coraz to nowsze metody ataków za pomocą istniejących już znaczników.
        </p>
        <p>
            Lepszym podejściem jest zastosowanie białej listy. Dzięki niej definiowany jest zestaw znaczników, które uznane są za bezpieczne i mogą się znaleźć na witrynie. Można zastosować do tego wspomnianą funkcję strip_tags, wywołując ją z dwoma parametrami, gdzie drugim z nim jest zestaw dopuszczalnych znaczników. Odpowiednie wywołanie funkcji pozwalającej pogrubić tekst wygląda następująco:
        </p>
        <xmp class="prettyprint">
echo strip_tags($p['autor'], "<strong><b>");
echo strip_tags($p['tresc'], "<strong><b>");
        </xmp>
        <p>
            Usunięte zostaną wszystkie znaczniki oprócz wymienionych. Stosując jednak to rozwiązanie atakujący może dodać atrybuty do powyższych znaczników, w których może wywołać swoje skrypty:
        </p>
        <xmp class="prettyprint">
<strong onmouseover='alert("Atak XSS")'> :-) </strong>
        </xmp>
        <p>
            Należałoby zatem dodatkowo odfiltrować wszystkie atrybuty tych dozwolonych znaczników, co jednak jest niezmiernie czasochłonne.
        </p>
</div>
<div data-button="a3-fix-fix-3" class="workspace">
    <h2>Zamiana znaków specjalnych na encje</h2>
        <p>
            Podobnie jak w przypadku obrony przed atakami w SQL Injection tak samo w Cross Site Scripting zastosować można sekwencje ucieczki. W tym wypadku jest to najrozsądniejsze rozwiązanie. Gdy użytkownik wprowadzi kod HTML zostanie on wyświetlony jako tekst i nie będzie interpretowany. Najważniejsze znaki, które należy koniecznie poddać konwersji to &,< , >, " , ' , :
        </p>
        <p>
            W PHP konwersja tych znaków na odpowiadające im encje można wykonać wykorzystując funkcję htmlspecialchars. Pierwszym argumentem jest źródło danych, na które należy zastosować zamianę znaków specjalnych, drugim parametrem jest dodatkowa flaga, która najczęściej ustawiana jest na wartość ENT_QUOTES, dzięki której znak również ' ma być kodowany. Trzeci argument określa sposób kodowania znaków. Domyślne kodowanie to ISO-8859-1 w strszych wersjach PHP lub UTF-8 dla nowszych wersji. Przykładowe wywołanie mogło by wyglądać następująco:
        </p>
        <xmp class="prettyprint">
htmlspecialchars($p['tresc'], ENT_QUOTES, 'utf-8');
        </xmp>
        <p>
            Po zastosowaniu konwersji fragment kodu źródłowego strony może wyglądać następująco:
        </p>
        <xmp class="prettyprint">
<div>Treść: &lt;script&gt;alert(&#039;xss&#039;);&lt;/script&gt;</div>
        </xmp>
        <p>
            A użytkownik strony zobaczy na stronie treść:
        </p>
        <xmp class="prettyprint">
Treść: <script>alert('xss');</script>
        </xmp>
        <p>
            Stosując zatem ścieżkę ucieczki jesteśmy w stanie zabezpieczyć aplikacje przed atakami typu Cross Site Scripting, jednakże większe możliwości filtrowania wstawianego kodu na stronę dają zewnętrzne biblioteki i usługi. W przypadku PHP najpopularniejszą biblioteką jest HTML Purifier. W domyślnej konfiguracji zabezpiecza już aplikację przed atakami XSS, a dodatkowo w razie potrzeby można go skonfigurować do bardziej złożonych wymagań. 
        </p>
        <p>
            Do analizowanego wcześniej przykładu wyświetlania danych w księdze gości zostanie zaimplementowana wyżej wspomniana biblioteka. Kod szablonu prezentującego wpisy prezentuje się następująco:
        </p>
        <xmp class="prettyprint">
<?php echo file_get_contents( "source/guestbook.php" ); ?>
        </xmp>
        <p>
            Na samym początku dołączamy plik biblioteki HTMLPurifier.auto.php. Następnym krokiem jest utworzenie obiektów klas HTMLPurifier_Config oraz HTMLPurifier. W przypadku pierwszego tworzony jest obiekt konfiguracyjny zapisujący domyślną konfiguracje poprzez metodę createDefault. Obiekt ten jest następnie wykorzystany przy tworzeniu obiektu HTMLPurifier, który zostanie wykorzystany do filtrowania danych.
        </p>
        <xmp class="prettyprint">
$config = HTMLPurifier_Config::createDefault();
$purifier = new HTMLPurifier($config);
        </xmp>
        <p>
            Stosując metodę purify gdzie parametrem są dane wejściowe otrzymujemy przefiltrowany kod, dzięki któremu unieszkodliwione zostaną wszelkie skrypty zamieszczane na stronie.
        </p>
        <xmp class="prettyprint">
$purifier->purify($p['tresc']);
        </xmp>
</div>
<div data-button="a3-fix-fix-4" class="workspace lesson center">
    <h2> Zabezpieczona aplikacja</h2>
    <h3> Wykorzystanie biblioteki HTML Purify</h3>
        <div class="lessonContent">
            <?php include('source/functions.php'); ?>
        </div>
</div>