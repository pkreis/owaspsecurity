<header>
    <div class="wrapper">
        <h2> Kontrola dostępu do danych i funkcji </h2>
        <h3> (Modyfikacje elementów interfejsu)</h3>
        <div class="navbar">
            <img src="style/images/logo_polsl_aei.png">
        </div>
    </div>
        <div class="panel">
        <button data-button="a4-fix-1">Zabezpieczenie</button>
        <button data-button="a4-fix-2">Zabezpieczona aplikacja</button>
    </div>
</header>
<div class="blankspace" style="height:180px;"></div>
<div data-button="a4-fix-1" class="workspace">
    <h2> Wstęp</h2>
    <p>
        W analizowanym powyższym przykładzie znajduje się kilka błędów, które należy wyeliminować. Pierwszym jest przedstawienie w interfejsie strony zbyt wielu informacji stosując tylko ograniczenie wizualne. Na zewnątrz aplikacji przekazywane powinno być tylko tyle informacji ile jest faktycznie niezbędne. W przykładzie niezalogowany użytkownik nie powinien mieć możliwości podejrzenia identyfikatorów wiadomości, dla których nie ma uprawnień podglądu. Można zatem tutaj pominąć dla tych wiadomości zawartość atrybutu value lub ustawić go na określoną wartość np. 0.
    </p>
    <xmp class="prettyprint">
<?php echo file_get_contents( "listings/1.php" ); ?>
    </xmp>
    <p>
        Efektem tego będzie lista, w której znaczniki option z niedostępnymi wiadomościami przyjmą w atrybucie value wartość 0. Póki co nie zabezpiecza to jeszcze naszej aplikacji, jednakże dobrze jest zastosować takie rozwiązanie, gdyż nie ujawnia się zbyt wielu informacji. Nadal można zgadywać identyfikatory wiadomości, a w tym przypadku nie jest to trudne, gdyż są to po prostu kolejne liczby.
    </p>
    <p>
        Najbardziej widocznym tutaj błędem jest brak weryfikacji uprawnień przy wyświetlaniu wiadomości. Należy zatem poprawić kod szablonu wyświetlania treści w ten sposób aby wiadomość oznaczona jako tylko dla zalogowanych przed wyświetleniem była sprawdzana czy ustawiona jest zmienna sesji zalogowany. Poprawka kodu źródłowego jest następująca:
    </p>
    <xmp class="prettyprint">
<?php echo file_get_contents( "listings/2.php" ); ?>
    </xmp>    
    <p>
        Tym sposobem, jeżeli wiadomość ze zmiennej $message  jest wyświetlana jeśli nie ma flagi registered lub gdy posiada ją ale użytkownik jest zalogowany w sesji. W przeciwnym wypadku zwrócony zostanie komunikat o braku wiadomości.
    </p>
    <p>
        Dodatkową rzeczą, którą należy zwrócić uwagę jest to, że wartość parametru id jest odczytywana bezpośrednio z tablicy $_GET i przekazywana bezpośrednio do funkcji pobierającej wskazaną wiadomość. Jak już wcześniej było wspominane, wszystkie dane z zewnątrz powinny być traktowane jako potencjalne zagrożenie i należy zweryfikować ich poprawność. 
    </p>
    <p>
        Wykorzystać tutaj można zatem wcześniej omawianą w rozdziale obrony przed atakami SQL Injections funkcję filter_input. Dodatkowo zastosować warto ograniczenie zakresu akceptowanych identyfikatorów. Wiadomo, iż wszystkie wiadomości posiadaja dodatnie id, a wartość 0 została wykorzystana jako sztuczny identyfikator na liście wiadomości. Warto zatem sprawdzić od razu czy przesyłany identyfikator jest większy od 0:
    </p>
    <xmp class="prettyprint">
<?php echo file_get_contents( "listings/3.php" ); ?>
    </xmp>
    <p>
        Po otrzymaniu za pomocą metody GET parametru id sprawdzane jest czy wartość jest typem liczby całkowitej i zapisywana do zmiennej $id . Metoda getMessage jest wywoływana tylko wtedy, gdy wartość identyfikatora po sprawdzeniu będzie większa od 0. W przeciwnym wypadku zmienna $message pozostanie pusta.
    </p>
</div>
<div data-button="a4-fix-2" class="workspace lesson center">
    <h2> Zabezpieczona aplikacja</h2>
        <div class="lessonContent">
            <?php include('source/functions.php'); ?>
        </div>
</div>