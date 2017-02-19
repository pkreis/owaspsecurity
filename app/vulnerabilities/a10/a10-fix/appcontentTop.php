<header>
    <div class="wrapper">
        <h2> Brak walidacji przekierowań </h2>
        <div class="navbar">
            <img src="style/images/logo_polsl_aei.png">
        </div>
    </div>
    <div class="panel">
        <button data-button="a10-fix-1">Wstęp</button>
        <button data-button="a10-fix-2">Weryfikacja odsyłacza</button>
        <button data-button="a10-fix-3">Biała lista</button>
        <button data-button="a10-fix-4">Zabezpieczona aplikacja</button>
    </div>
</header>
<div class="blankspace" style="height:180px;"></div>
<div data-button="a10-fix-1" class="workspace">
    <h2>Przekierowanie z parametru</h2>
    <p>
        Najprostszym sposobem obrony przed próbami tego typu ataku jest zrezygnowa-nie z przekierowań pobieranych w z parametru GET. Jednakże chcąc zachować tą funk-cjonalność serwisu stosuje się kontrolę odsyłacza  (ang. referer) oraz białe listy. 
    </p>
    <p>
</div>
<div data-button="a10-fix-2" class="workspace">
    <h2>Weryfikacja odsyłacza</h2>
    <p>
        Odsyłacz jest to adres strony internetowej, z której użytkownik został przekiero-wany na serwis za pomocą danego odnośnika. Zostaje on przekazany serwerowi w na-główku żądania http. Można zatem zastosować weryfikacje, czy użytkownik, który znaj-duje się na podstronie, która wykorzystuje parametr redirect znalazł się na niej z ze-wnętrznego źródła, czy też klikając na odnośnik wewnątrz witryny. Sprawdzenie nagłów-ka można wykonać poleceniem:
    </p>
    <xmp class="prettyprint">
$host = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);    
    </xmp>
    <p>
        Następnie należy zastosować sprawdzenie czy odsyłacz pochodzi z zaufanego źródła:
    </p>
    <xmp class="prettyprint">
$allowed_host = 'localhost';
if(substr($host, 0 - strlen($allowed_host)) == $allowed_host) {
    </xmp>
    <p>
        W ten sposób zabezpieczymy stronę przed przygotowanymi przez atakującego żądaniami wysłanymi poprzez wiadomości e-mail, czat czy klikając w innym serwisie na spreparo-wany odnośnik. Jeśli jednak na serwisie użytkownicy mogą dodawać własne odnośniki zagrożenie nadal pozostanie, gdyż sam link będzie pochodził z zaufanego źródła.
    </p>
</div>
<div data-button="a10-fix-3" class="workspace">
    <h2>Biała lista</h2>
    <p>
        Aby całkowicie zapobiec możliwości wykorzystania przekierowań przez atakują-cego wykorzystuje się białą listę. Polega ona na zezwolenie użycia tylko określonych przekierowań w serwisie.  Uniemożliwia to wstrzyknięcia do parametru redirect ze-wnętrznego odnośnika. Tworzymy zatem tablicę zezwolonych odnośników:
    </p>
    <xmp class="prettyprint">
$allowed = array(
    "index" => "index.php",
    "article"  => "article.php",
);
    </xmp>
    <p>
        Następnie sprawdzamy czy wartość parametru zapisana w zmiennej $redirect znajduje się w powyższej tablicy:
    </p>
    <xmp class="prettyprint">
$url = isset($allowed[$redirect]) ? $allowed[$redirect] : "index.php";
    </xmp>
    <p>
        Dzięki temu dozwolone zostaną tylko te odnośniki, które rzeczywiście administrator pra-gnie by funkcjonowały. W przeciwnym wypadku użytkownik zostanie przeniesiony na stronę główną, a jego bezpieczeństwo zostanie zachowane.
    </p>
</div>
<div data-button="a10-fix-4" class="workspace lesson center">
    <h2> Zabezpieczona aplikacja</h2>
        <div class="lessonContent">
            