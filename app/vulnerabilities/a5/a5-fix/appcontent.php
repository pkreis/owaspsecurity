<header>
    <div class="wrapper">
        <h2> Wysyłanie plików na serwer </h2>
        <div class="navbar">
            <img src="style/images/logo_polsl_aei.png">
        </div>
    </div>
    <div class="panel">
        <button data-button="a5-fix-1">Zabezpiecznie</button>
        <button data-button="a5-fix-2">Zabezpieczona aplikacja</button>
    </div>
</header>
<div class="blankspace" style="height:180px;"></div>
<div data-button="a5-fix-1" class="workspace">
    <h2> Zabezpiecznie</h2>
    <p>
        Pierwszym poważnym błędem jest zapis obrazu pod oryginalną nazwą bez spraw-dzenia czy już taki plik nie istnieje. Aby zabezpieczyć przed taką możliwością, można sprawdzać w bazie czy dany plik już istnieje lub zmienić nazwę wysyłanego pliku, tak aby była unikalna. Wykorzystać do tego można funkcję skrótu wraz z funkcją uniqueid oraz random. Dzięki temu uzyskany ciąg znaku będzie unikalny, i wystarczy dopisać do niej rozszerzenie i zapisać w bazie danych:
    </p>
    <xmp class="prettyprint">
$path_parts = pathinfo($_FILES['file']['name']);
$extension = $path_parts['extension'];
$filename = md5(uniqid(rand(), true)).'.'.$extension;
    </xmp>
    <p>
        Stosując losową nazwę pliku unikniemy w tym przypadku ataków typu SQL Injection oraz Cross Site Scripting. Warto jednak mimo tego zastosować dodatkowo zapytania pa-rametryzowane oraz podczas wyświetlania użyć tzw. ścieżkę ucieczki czyli zamianę zna-ków specjalnych na encje. 
    </p>
    <p>
        Badanie typu pliku ograniczając się tylko do nagłówka Content-Type jest niebezpieczne, gdyż może być on zmanipulowany. Zwiększyć poziom bezpieczeństwa możemy sprawda-jąc, czy dany plik jest obrazem, a nie tylko ma rozszerzenie typu graficznego. Sprawdzić to można metodą getimagesize:
    </p>
    <xmp class="prettyprint">
$imagesize = getimagesize($tmp_name);
    </xmp>
    <p>
        Jeśli zmienna $imagesize przyjmie wartość FALSE, oznacza to iż zawartością pliku nie jest poprawny obraz. Atakujący są jednak w stanie również w tym znaleźć lukę. Wstrzy-kują oni bowiem szkodliwy kod do pliku graficznego, nie zmieniając struktury danego obrazka. Aby zapobiec takiej sytuacji należałoby zastosować zewnętrzną bibliotekę gra-ficzną GD. Korzystając z niej należało by przerobić obraz bezpośrednio z pliku wgrywa-nego na nowy co spowoduje usunięcie szkodliwego kodu i po konwersji zapisze bez-pieczny plik. 
    </p>
    <p>
        Aby zapobiec uruchamianiu niepożądanych skryptów w wysyłanych plikach należałoby utworzyć plik konfiguracyjny .htaccess w danym katalogu by wyłączyć ich obsługę. Przykładowa konfiguracją blokująca skrypty wykonywalne wygląda  następująco: 
    </p>
    <xmp class="prettyprint">
Options -Indexes
Options -ExecCGI
AddHandler cgi-script .php .php3 .php4 .phtml .pl .py .jsp .asp .htm .shtml .sh .cgi
    </xmp>
    <p>
        Dzięki temu nawet jeśli w wysyłanym pliku na serwer znajdował się wykonywalny skrypt to zastosowanie tej konfiguracji uniemożliwi jego uruchomienie.
    </p>
</div>
<div data-button="a5-fix-3" class="workspace">
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
<div data-button="a5-fix-2" class="workspace lesson center">
    <h2> Zabezpieczona aplikacja</h2>
        <div class="lessonContent">
            <?php include('source/functions.php'); ?>
        </div>
</div>