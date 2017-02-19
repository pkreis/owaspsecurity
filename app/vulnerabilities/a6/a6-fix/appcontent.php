<header>
    <div class="wrapper">
        <h2> Szyfrowanie hasła </h2>
        <div class="navbar">
            <img src="style/images/logo_polsl_aei.png">
        </div>
    </div>
    <div class="panel">
        <button data-button="a6-fix-1">Wstęp</button>
        <button data-button="a6-fix-2">Szyfrowanie symetryczne</button>
        <button data-button="a6-fix-3">Funkcja skrótu</button>
        <button data-button="a6-fix-4">Solenie haseł</button>
        <button data-button="a6-fix-5">Zabezpieczona aplikacja</button>
    </div>
</header>
<div class="blankspace" style="height:180px;"></div>
<div data-button="a6-fix-1" class="workspace">
    <h2> Wstęp</h2>
    <p>
        Stosowanie niezaszyfrowanych haseł jest karygodnym błędem aplikacji internetowej. Odczytanie hasła przez atakującego naraża użytkownika na ogromne straty. W celu zwiększenia stosuje się różne metody zakodowania hasła. Każdy z opisanych poniżej zwiększy bezpieczeństwo aplikacji, jednakże nie każda metoda całkowicie uniemożliwi odczytanie hasła klienta.
    </p>
</div>
<div data-button="a6-fix-2" class="workspace">
    <h2>Szyfrowanie symetryczne</h2>
        <p>
            Jednym z rozwiązań, które zabezpieczy nasze hasło jest szyfrowanie symetryczne. Hasła śa kodowane za pomocą algorytmów takich 3DES czy AES i w takiej postaci zapisywane do bazy danych. Zaletą tego rozwiązania jest możliwość przypomnienia hasła, w przy-padku gdy użytkownik je zapomniał. 
        </p>
        <p>
            W języku PHP dostępna jest biblioteka mcrypt, która udostępnia wiele algorytmów kryp-tograficznych umożliwiając przygotowanie hasła do szyfrowania i deszyfrowania. 
        </p>
        <p>
            Pierwszym krokiem jest inicjalizacja modułu. W tym miejscu wybieramy w jakim trybie chcemy aby biblioteka pracowała. Wybierzmy algorytm 3DES w trybie CBC:
        </p>
        <xmp class="prettyprint">
$td = mcrypt_module_open('tripledes', '', 'cbc', '');
$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_DEV_URANDOM);
        </xmp>
        <p>
            Do kompletnej inicjalizacji potrzebny nam klucz według którego odbędzie się szyfrowa-nie. Kluczem może być dowolny tekst. Załóżmy, iż klucz P0l1t3c4n1k@ zapiszemy do zmiennej $key, po czym dokończymy przygotowanie funkcji szyfrującej:
        </p>
        <xmp class="prettyprint">
mcrypt_generic_init($td, $key, $iv);
        </xmp>
        <p>
            Posiadając skonfigurowaną bibliotekę pozostaje nam zapisywać podczas rejestracji za-szyfrowane hasło do bazy oraz podczas logowania sprawdzić czy hasło wprowadzone w formularzu jest takie samo, jak zaszyfrowane hasło z bazy. Szyfrowanie tworzymy nastę-pującą metodą:
        </p>
        <xmp class="prettyprint">
$encryptedPass = mcrypt_generic($td, $pass);
        </xmp>
        <p>
            Po zakończeniu szyforwania należy wyłączyć moduł mcrypt poleceniami mcrypt_generic_deinit($td) oraz  mcrypt_module_close($td). Ostatnim elementem jest w zapytaniach rejestracji jak i logowania podmienić zmienna $pass na $encryptedPass za-wierjącą zaszyfrowane hasło. 
        </p>
        <p>
            Powyższe rozwiązanie nie jest dobrym zabezpieczeniem hasła, gdyż atakujący, któremu uda odczytać się klucz szyfrujący z zmiennej $key jest w stanie odszyfrować hasło. Może tego dokonać poleceniem:
        </p>
        <xmp class="prettyprint">
$pass = mdecrypt_generic($td, $encryptedPass);
        </xmp>
        <p>
            Aplikacja pomimo zastosowania szyfrowania haseł nadal nie zapewnia użytkownikowi pełnej poufności, w razie ataku na serwis. Dodatkowo administrator czy programista są w stanie odczytać hasła użytkowników, a taka sytuacja nie powinna zaistnieć.
        </p>
</div>
<div data-button="a6-fix-3" class="workspace">
    <h2>Funkcje skrótu</h2>
        <p>
            Funkcja skrótu, a dokładniej funkcja haszująca przetwarza otrzymane dane wejściowe w ciąg bitów o danej długości. Skrót danego hasła zawsze jest taki sam, jednakże nie ma możliwości z otrzymanego ciągu bitów określić z jakiego hasła on pochodzi. Jest to za-tem instrukcja jednokierunkowa.
        </p>
        <p>
            Tak jak w przypadku szyfrowania symetrycznego tutaj również możemy zastosować róż-ne algorytmy. Aktualnie najbardziej bezpiecznymi i najczęściej wykorzystywanymi są SHA256 lub SHA512. 
        </p>
        <p>
            W języku PHP od wersji 5.1.2 można wykorzystać gotową metoda hash generującą skrót dla określonej danej wejściowej. Podczas wywołania należy dodatkowo zaznaczyć, z któ-rego algorytmu skorzystać ma funkcja:
        </p>
        <xmp class="prettyprint">
$hashPass = hash('sha256', $pass);
        </xmp>
        <p>
            Hasło w postaci skrótu wstawiamy podczas rejestracji do bazy. Podczas logowania na wprowadzone hasło stosujemy funkcje haszującą i sprawdzamy czy skrót jest równy temu zapisanemu w kolumnie Haslo.
        </p>
        <p>
            Takie rozwiązanie do niedawna dobrze chroniło wszelkie serwisy. Na przestrzeni lat po-wstały tzw. tęczowe tablice (ang. rainbow tables). Jest ona tworzona przez zapisywanie łańcuchów (ang. chains) ze skrótów haseł. Zapisane w niej jest jeden skrót na wygenero-wanych nawet kilkaset ciągów znaków. Umożliwia to przyśpieszenie ataku typu brute-force na tyle, iż wystarczy domowy komputer by złamać dane hasło. 
        </p>
        <p>
            Rozwiązaniem tego problemu jest jednak możliwe, poprzez zastosowanie „soli” (ang. salt).
        </p>
</div>
<div data-button="a6-fix-4" class="workspace">
    <h2>Solenie haseł</h2>
        <p>
            Aby zabezpieczyć hasła zapisane w bazie przed atakami wykorzystujące tęczowe tablice należy dodatkowo wygenerować „sól”. Jest to pseudolosowy ciąg znaków, który jest wy-korzystywany w funkcji haszującej razem z hasłem tworząc unikalny ciąg. 
        </p>
        <p>
            W niektórych rozwiązaniach stosuje się tą samą „sól” dla wszystkich haseł, należało by zatem w kodzie źródłowym instrukcję: 
        </p>
        <xmp class="prettyprint">
$salt = 'losowy ciąg bajtów';
$encryptedPass = hash('sha256', $salt.$pass);
        </xmp>
        <p>
            Rozwiązanie to nie jest jednak optymalne, ponieważ wyklucza tylko zastosowanie tęczo-wych tablic, jednakże metodą brute-force złamanie haseł z całej bazy potrwa o wiele kró-cej niż gdyby sól była różna dla każdego hasła.
        </p>
        <p>
            W języku PHP od wersji 5.3 można zastosować funkcję crypt, która umożliwia zapisanie soli razem z hasłem, zatem nie ma potrzeby ręcznego zapisywania w bazie soli dla każ-dego hasła. Jej wywołanie wygląda następująco: 
        </p>
        <xmp class="prettyprint">
crypt(hasło, sól);
        </xmp>
        <p>
            Podanie „soli” jest opcjonalne, i gdy nie zostanie podana system automatycznie wygene-ruje ją używając algorytmu DES. Jeśli chcemy zastosować inny algorytm konieczne jest ręczne generowanie losowej soli.
        </p>
        <p>
            W PHP wersjach 5.5 i nowszych wprowadzono funkcję password_hash. Funkcja ta gene-ruje automatycznie sól do podanego w parametrze algorytmu bez potrzeby jej generowa-nia. Wywołanie funkcji można wykonać w poniższy sposób.
        </p>
        <xmp class="prettyprint">
password_hash(hasło, ALGORYTM );
        </xmp>
        <p>
            Funkcja ta jest dosyć nową funkcją zatem wspiera na razie algorytm BLOWFISH, który uznawany jest obecnie za jeden z najbezpieczniejszych. Stosując w wywołaniu funkcji flagę PASSWORD_DEFAULT funkcja w przyszłości w zależności od wersji PHP będzie wybierać najnowszy i teoretycznie najbezpieczniejszy algorytm.
        </p>
        <p>
            Chcąc  jednak zastosować inny algorytm, należy powrócić do funkcji crypt. Aby zastoso-wać inny algorytm należy ręcznie wygenerować sól, a następnie dodać do niej przedro-stek sugerujący wybór algorytmu. Funkcja ta obsługuje 6 algorytmów, a ich przedrostki potrzebne do ich wyboru są następujące:
        </p>
        <p>
            •	Brak — DES, <br>
            •	_ — Extended DES,<br>
            •	$1$ — MD5,<br>
            •	$2a$ lub $2x$, lub $2y$ — Blowfish,<br>
            •	$5$ — SHA256,<br>
            •	$6$ — SHA512.
        </p>
        <p>
            Aby zastosować w omawianym przykladzie algorytm SHA256 należy zatem wygenero-wać sól razem z przedrostkiem $5$. Realizacja generowania soli może wyglądać następu-jąco: 
        </p>
        <xmp class="prettyprint">
function generateSalt() {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 16; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    $salt = '$5$'.$randomString;  
    return $salt; 
}
        </xmp>
        <p>
            Funkcja ta generuje 16-literowy losowy ciąg znaków, a następnie dodaje do niego przego przedrostek. W naszym przykładzie przygotowaną sól wykorzystujemy podczas szyfro-wania hasła podczas rejestracji:
        </p>
        <xmp class="prettyprint">
$pass = crypt($pass, generateSalt());
        </xmp>
        <p>
            Logowanie do systemu należy lekko zmodyfikować, bowiem najpierw musimy pobrać z bazy hasło dla podanego użytkownika, a następnie dokonać weryfikacji skrótu hasła z bazy danych przypisanej do zmiennej $haslo wraz z hasłem wprowadzonym przez użyt-kownika z zmiennej $pass następującą instrukcją warunkową:
        </p>
        <xmp class="prettyprint">
if (crypt($pass, $haslo) == $haslo){
    $_SESSION['zalogowany'] = $nazwa; 
}
        </xmp>
        <p>
            Tak zabezpieczona aplikacja pozwala teraz na bezpieczne przechowywanie haseł. Po za-stosowaniu funkcji skrótu z użyciem soli, nawet jeśli atakujący odczyta zawartość ko-lumny hasło to nie będzie miał z tego zbyt wielkiego pożytku, a hasło użytkownika pozo-stanie bezpieczne. 
        </p>
</div>
<div data-button="a6-fix-5" class="workspace lesson center">
    <h2> Zaszyfrowane hasła</h2>
    <h3> Funkcja skrótu z wykorzystaniem soli </h3>
        <div class="lessonContent">
            <?php include('source/functions.php'); ?>
        </div>
</div>