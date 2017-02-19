<header>
    <div class="wrapper">
        <h2> Nieodpowiednia kontrola uprawnień użytkowników </h2>
        <h3> </h3>
        <div class="navbar">
            <img src="style/images/logo_polsl_aei.png">
        </div>
    </div>
    <div class="panel">
        <button data-button="a7-fix-1">Zabezpieczenie</button>
        <button data-button="a7-fix-2">Zabezpieczona aplikacja</button>
    </div>
</header>
<div class="blankspace" style="height:180px;"></div>
<div data-button="a7-fix-1" class="workspace">
    <h2> Kontrola dostępu do funkcji</h2>
    <p>
        W analizowanym przykładzie aby zabezpieczyć aplikacje, przed wywoływaniem funkcji przez nieautoryzowanych użytkownika należy zastosować kontrole uprawnień. Należy zatem dodać instrukcje warunkową w funkcji odpowiedzialnej za usuwanie wia-domości:
    </p>
    <xmp class="prettyprint">
if(!isset($_SESSION['zalogowany'])){
	$alert = 'Brak uprawnień. Nie można usunąć wiadomości.';
}
    </xmp>
    <p>
       Po zastosowaniu powyższych instrukcji w funkcji deleteMessage najpierw badane jest czy do czynienia mamy z zalogowanym użytkownikiem poprzez sprawdzenie zmiennej sesji zalogowany. Jeśli użytkownik nie jest zalogowany otrzymuje komunikat o braku uprawnień i nie przechodzi do dalszej części kodu funkcji. Dodatkowo jeśli jest zalogo-wany warto sprawdzić jest czy został przekazany parametr z identyfikatorem wiadomości do usunięcia. Gdy nie zostanie przekazany wyświetlany będzie komunikat o nieprawi-dłowych danych.
    </p>
    <p>
       W ten sposób atakujący podczas próby ataku otrzyma komunikat o braku uprawnień, za-tem nie będzie możliwe usuwanie treści przez nieautoryzowanych użytkowników. Wery-fikacja uprawnień dla funkcji w aplikacji jest kluczową techniką, o której nie należy za-pominać podczas implementacji kodu źródłowego.
    </p>
</div>
<div data-button="a7-fix-2" class="workspace lesson center">
    <h2> Zabezpieczona aplikacja</h2>
        <div class="lessonContent">
            <?php include('source/functions.php'); ?>
        </div>
</div>