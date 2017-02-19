<header>
    <div class="wrapper">
        <h2> Porywanie sesji </h2>
        <div class="navbar">
            <img src="style/images/logo_polsl_aei.png">
        </div>
    </div>
    <div class="panel">
        <button data-button="a1-sqli-lesson1-1">Sposoby obrony</button>
    </div>
</header>
<div class="blankspace" style="height:180px;"></div>
<div data-button="a1-sqli-lesson1-1" class="workspace">
    <h2>Sposoby obrony</h2>
    <p>
        Atakujący, któremu uda się podsłuchać ruch sieciowy jest w stanie odczytać wszystkie dane, gdyż są one wysyłane niezaszyfrowanym tekstem. Z łatwością zatem może prze-chwycić i wykorzystać identyfikator danej sesji. Jedynym skutecznym rozwiązaniem jest zastosowanie bezpiecznego protokołu HTTPS. Dzięki niemu komunikacja klient – serwer jest w pełni szyfrowana. Należy jednak zwrócić uwagę, iż wdrożenie protokołu SSL lub TLS wiąże się z dodatkowymi kosztami, dlatego szczególnie w niskobudżetowych apli-kacjach pomija się stosowanie szyfrowanej wersji HTTP.
    </p>
    <p>
        Nie korzystając z HTTPS możemy jedynie zmniejszyć ryzyko ataku, ale nie zabezpieczy to całkowicie aplikacji. Jednym z elementów, który warto zastosować jest kontrola czasu trwania sesji. Sesje, które nie wygasają w odpowiednio krótkim czasie, dają większe możliwości włamywaczowi na atak. Sesja powinna być przerwana, gdy przez pewien okres czasu nie wykryto żadnej aktywności ze strony użytkownika. W pierwszej kolejno-ści należałoby zapisać czas ostatniej aktywności użytkownika podczas wywołania akcji. Dokonać tego można za pomocą funkcji time() zwracający aktualny czas:
    </p>
    <xmp class="prettyprint">
$_SESSION['timeout'] = time();
    </xmp>
    <p>
        Przy kolejnym wywołaniu należy zatem sprawdzić instrukcją warunkową w jakim czasie zostało wywołane ostatnie żądanie:
    </p>
    <xmp class="prettyprint">
if ($_SESSION['timeout'] + 300 < time()) {
  session_destroy();
  sessionMsg('Sesja wyhgasła.');
  return LOGIN_FAILED;
}
    </xmp>
    <p>
        Dzięki temu atakujący będzie miał tylko 5 minut od ostatniego żądania na dokonanie włamania, co nieco zmniejszy ryzyko ataku. 
    </p>
    <p>
        Dodatkową metodą, która można zastosować w celu uzyskania większego bezpieczeństwa jest wprowadzenie do kluczowych operacji (np. zmiana hasła)  konieczność ponownego uwierzytelnienia użytkownika danymi logowania. W ten sposób ograniczymy możliwość operacji atakującego po włamaniu na konto użytkownika.
    </p>
</div>