        </div>
</div>
<div data-button="a1-sqli-lesson1-3" class="workspace">
    <h2> Kod źródłowy</h2>
        <h3> Formularz logowania</h3>
        <xmp class="prettyprint">
<?php echo file_get_contents( "source/code.php" ); ?>
        </xmp>
        <p>
            Formularz logowania metodą POST wysyła parametry przekazane z pól nazwy użytkow-nika i hasła. Za pomocą parametru action o wartości login wywoływana zostaje funkcja odpowiedzialna za weryfikacje danych i autoryzowanie użytkownika. 
        </p>
        <h3> Funcje aplikacji</h3>
        <xmp class="prettyprint">
<?php echo file_get_contents( "source/functions.php" ); ?>
        </xmp>
        <p>
            Analiza kodu źródłowego weryfikacji danych logowania przedstawiona została w roz-dziale „Atak na logowanie”. Zastosowana wersja w tym przykładzie jest już zabezpieczo-na przed atakami SQL Injection omawiane w rozdziale sposobu obrony przed tą podatno-ścią bezpieczeństwa.
        </p>
        <p>
            W funkcji odpowiadającej za wyświetlenie zawartości strony została dodatkowo do zmiennej $session przypisana wartość identyfikatora sesji korzystając z poniższej meto-dy:
        </p>
        <xmp class="prettyprint">
$session = session_id();
        </xmp>
        <p>
            W szablonie strony dostępnej po zalogowaniu została więc dodana linia odpowiadająca za wyświetlenie tej zawartości:
        </p>
        <xmp class="prettyprint">
<p>Idenytifkator sesji zapisany w ciasteczu: <b>< ?php echo $session; ?></b></p>
        </xmp>
</div>
<div data-button="a1-sqli-lesson1-4" class="workspace">
    <h2> Analiza podatności</h2>
    <p>
        Jeśli serwis działa na nieszyfrowanym protokole HTTP, identyfikator można podsłuchać odpowiednim programem analizującym ruch sieciowy (np. WireShark). Podłączając się do publicznej sieci bezprzewodowej lub nawet w sieci lokalnej atakujący może podejrzeć transmisje i wychwycić poszukiwane dane. W tym przypadku było by to ciasteczko z od-powiednią wartością identyfikatora sesji. 
    </p>
    <p>
        <img src="vulnerabilities/a2/a2-lesson/images/1.png" style="max-width:60%; display:table; margin:auto auto auto auto;">
    </p>
    <p>
        W celu symulacji dwóch odrębnych sesji możemy wykorzystać dwie różne przeglądarki bądź uruchomić drugie okno jednej przeglądarki w trybie gościa. Zalogujmy się zatem w jednym oknie do serwisu poprzez przygotowany formularz. Wyświetlony identyfikator sesji kopiujemy do schowka.
    </p>
    <p>
         W drugim kliencie trzeba zatem podmienić wartość sesji zapisaną w ciasteczku PHPSESSID. W różnych przeglądarkach możemy zastosować gotowe wtyczki umożliwia-jące podmianę tej wartości. W przypadku Google Chrome jedną z nich jest wtyczka Edit-ThisCookie.  Uruchamiamy wtyczkę, która nam wyświetli listę ciasteczek. Jedyne co po-zostało to podmiana wartości ciasteczka. Po wprowadzeniu wartości zapisanej w schowku uzyskamy dostęp do serwisu bez konieczności posiadania danych logowania.
    </p>
    <p>
        <img src="vulnerabilities/a2/a2-lesson/images/2.jpg" style="max-width:30%; display:table; margin:auto auto auto auto;">
    </p>
</div>