<header>
    <div class="wrapper">
        <h2> Używanie komponentów ze znanymi podatnościami </h2>
        <div class="navbar">
            <img src="style/images/logo_polsl_aei.png">
        </div>
    </div>
    <div class="panel">
        <button data-button="a9-fix-1">Zabezpieczenie</button>
    </div>
</header>
<div class="blankspace" style="height:180px;"></div>
<div data-button="a9-fix-1" class="workspace">
    <h2> Wstęp</h2>
    <p>
        Najważniejszym sposobem obrony przeciwko błędom zawartych w komponentach ze znanymi podatnościami jest stosowanie zawsze najnowszej wersji wtyczki czy biblio-teki i sprawdzanie systematycznie czy nie została wydana nowsza wersja. Ważne też jest, by dana wtyczka posiadała ciągłe wsparcie, gdyż autor może już nie kontynuować pracy nad nią, co wiąże się z tym, iż nie zostaną wydane nowe poprawki.
    </p>
    <p>
        Jeśli dany dodatek nie jest już wspierany, a jest programiście potrzebny do swojej aplikacji internetowej, powinien przeanalizować kod źródłowy, by znaleźć możliwe luki bezpieczeństwa. W przypadku zaprezentowanej podatnej wtyczki był to brak filtrowania danych wprowadzanych z formularza wyboru daty. Wystarczy poddać filtracji zmienną $date:
    </p>
    <xmp class="prettyprint">
$date = $conn->real_escape_string($_POST['date']);
    </xmp>
    <p>
        Często do weryfikacji danych komponentów używa się zewnętrznego oprogramo-wania sprawdzającego bezpieczeństwo aplikacji. Jednym z przykładów jest oprogramo-wanie przygotowane przez tytułową organizację OWASP o nazwie ZedAttackProxy (ZAP).  Jego zadaniem próba dokonania penetracji aplikacji w celu wyszukania luk bez-pieczeństwa. Po przeprowadzonym teście, w raporcie znajdziemy takie informacje jak typ podatności oraz miejsce na stronie w którym możliwe jest dokonanie ataku. Dzięki temu programista zostaje uświadomiony, gdzie powinien poprawić komponent, aby zapewnić bezpieczeństwo całego swojego serwisu. 
    </p>
    <p>
        Często do weryfikacji danych komponentów używa się zewnętrznego oprogramo-wania sprawdzającego bezpieczeństwo aplikacji. Jednym z przykładów jest oprogramo-wanie przygotowane przez tytułową organizację OWASP o nazwie ZedAttackProxy (ZAP).  Jego zadaniem próba dokonania penetracji aplikacji w celu wyszukania luk bez-pieczeństwa. Po przeprowadzonym teście, w raporcie znajdziemy takie informacje jak typ podatności oraz miejsce na stronie w którym możliwe jest dokonanie ataku. Dzięki temu programista zostaje uświadomiony, gdzie powinien poprawić komponent, aby zapewnić bezpieczeństwo całego swojego serwisu. 
    </p>
    <p>
        <img src="vulnerabilities/a9/a9-fix/zap.jpg" style="max-width:60%; display:table; margin:auto auto auto auto;">
    </p>
</div>
