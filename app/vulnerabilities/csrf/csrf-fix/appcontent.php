<header>
    <div class="wrapper">
        <h2> Fałszowanie żądań </h2>
        <h3> </h3>
        <div class="navbar">
            <img src="style/images/logo_polsl_aei.png">
        </div>
    </div>
    <div class="panel">
        <button data-button="csrf-fix-1">Wstęp</button>
        <button data-button="csrf-fix-2">Operacja w kilku krokach</button>
        <button data-button="csrf-fix-3">Zastosowanie żetonów</button>
        <button data-button="csrf-fix-4">Zabezpieczona aplikacja</button>
    </div>
</header>
<div class="blankspace" style="height:180px;"></div>
<div data-button="csrf-fix-1" class="workspace">
    <h2> Wstęp</h2>
    <p>
        Zabezpieczyć aplikacje przed atakami fałszowania żądań można na kilka sposobów. Jed-nym z pomysłów jest zastosowanie kilku kroków, by wykonać daną operacje. Tym sposo-bem nie ma możliwości wykonać transakcje jednym przygotowanym żądaniem. Innym rozwiązaniem jest zastosowanie odpowiedniego żetonu do danej transakcji. 
    </p>
</div>
<div data-button="csrf-fix-2" class="workspace">
    <h2>Operacja w kilku krokach</h2>
        <p>
            Wykonanie transferu w kilku krokach jest sposobem wspomagającym bezpieczeństwo serwisu.  Użytkownik jednak będzie musiał poświęcić więcej czasu na dokonanie prawi-dłowego przelewu punktów. Jednakże patrząc na aplikacje internetowe polskich banków i tak w każdym występuje potwierdzenie danej transakcji, chociażby w celu weryfikacji danych. Nie jest zatem wadą, poproszenie użytkownika o weryfikacje swojego żądania. Aby dokonać transfer punktów w omawianym programie lojalnościowym należało by rozgraniczyć operacje na dwa kroki. W pierwszym dokonano by wyboru użytkownika oraz liczbę punktów do przekazania, a w drugim potwierdzenie tej operacji.
        </p>
        <p>
            W szablonie formularza transferu punktów zostanie zamieniony wartość wysyłanego pa-rametru action z transfer na showTransferConfirm. Dzięki temu najpierw zostanie wywo-łana funkcja, w której dodany zostanie dodatkowy kod umożliwiający dalsze kroki zabez-pieczenia aplikacji.
        </p>
        <p>
            W funkcji po sprawdzeniu czy użytkownik jest zalogowany pobrane zostają wartości z pól formularza i przypisanie do zmiennych $userid oraz $points. Następnym ważnym puntem jest zapisanie tych danych w sesji. 
        </p>
        <xmp class="prettyprint">
$_SESSION['transfer'] = array('userid' => $userid, 'points' => $points);
        </xmp>
        <p>
            Po zapisaniu tych danych, funkcja wyświetla szablon strony zawierający formularz, po-twierdzenia wysłania.
        </p>
        <p>
            Zastosowanie sesji umożliwi nam ochronę, ponieważ gdybyśmy w kolejnym kroku nadal korzystali z parametrów pobieranych z żądań, atakujący nadal mógłby wykonać operacje transferu bez potwierdzenia. W funkcji pointsTransfer należy zatem odczytać dane z se-sji, a nie z żądania. Wystarczy zatem zmienić poprzednie przypisanie, które wyglądało następująco:
        </p>
        <xmp class="prettyprint">
$userid = intval($_REQUEST['userid']);
$points = intval($_REQUEST['points']);
        </xmp>
        <p>
            Przypisanie wartości z sesji do zmiennych można wykonać poniższą metodą:
        </p>
        <xmp class="prettyprint">
$userid = $_SESSION['transfer']['userid'];
$points = $_SESSION['transfer']['points'];
        </xmp>
        <p>
            W tak poprawionej aplikacji nie da się już w jednym kroku wysłać żądania transferu punktów. Jednakże takie rozwiązanie wcale całkowicie nie eliminuje tej podatności. Jest tylko ona metodą zmniejszająco ryzyko ataku. Atakujący może skłonić użytkownika  do wykonania dwóch kliknięć, przez co nadal borykamy się z problemem dziury bezpieczeń-stwa. Zalecanym zatem rozwiązaniem jest zastosowanie żetonów.
        </p>
</div>
<div data-button="csrf-fix-3" class="workspace">
    <h2>Zastosowanie żetonów</h2>
        <p>
            Dokonanie ataku CSRF jest możliwe, gdy atakujący zna schemat żądania i wszystkie war-tości tych parametrów. Wprowadzenie do aplikacji pewnej niewiadomej, czyli parametru, którego atakujący nie będzie w stanie poznać i dzięki temu nie będzie w stanie przygoto-wać żądania. Powszechnie zatem używanym rozwiązaniem są żetony (ang. token). Jest to losowa wartość dołączana do żądania powiązana bezpośrednio z daną sesją użytkownika i nikt inny nie będzie tej wartości znał. 
        </p>
        <p>
            W przypadku opisywanego przykładu transferu punktów pierwszym krokiem jest utwo-rzenie żetonu. Następnie jest on dołączany go do ukrytego pola i zapisywany do sesji. Przy wykonywaniu transferu należy sprawdzić czy żeton sesyjny zgadza się z wysyłanym w żądaniu żetonem. Taki schemat działania umożliwi zabezpieczenie aplikacji przed tego typu atakami.
        </p>
        <p>
            Do utworzenia żetonu możemy zastosować funkcję mt_rand. Domyślnie zwraca ona lo-sową dodatnią wartość liczbową typu integer. Uzyskaną wartość możemy poddać działa-niu funkcji skrótu hash aby żeton zawsze miał jednolitą postać. Kod źródłowy funkcji generującej żeton wygląda następująco:
        </p>
        <xmp class="prettyprint">
function getToken()
{
  $random = mt_rand();
  $token = hash('md5', $random);
  return $token;
}
        </xmp>
        <p>
            Utworzony żeton zapisujemy do zmiennej $token po czym przypisujemy go do zmiennej sesji:
        </p>
        <xmp class="prettyprint">
$token = getToken();
$_SESSION['tokenCheck'] = $token;
        </xmp>
        <p>
            Kolejnym krokiem jest dołączenie go do formularza transferu punktów. Należy zatem dodać ukryte znacznik input zawierający wartość naszego żetonu:
        </p>
        <xmp class="prettyprint">
<input type="hidden" name="token" value="< ?php echo $token ;?>">
        </xmp>
        <p>
            W funkcji wykonującej transfer punktów pomiędzy użytkownikami należy odczytać wysłaną przez formularz wartość pola token i dodać instrukcję warunkową:
        </p>
        <xmp class="prettyprint">
$token = $_REQUEST['token'];
//sprawdzenie poprawności tokena
if(!isset($_SESSION['tokenCheck']) || $token != $_SESSION['tokenCheck']){
  sessionMsg('Nieprawidłowy token.');
  return ACTION_FAILED;
}
        </xmp>
        <p>
            Badamy czy istnieje zmienna sesji tokenCheck oraz sprawdzamy czy żeton wysłany for-mularzem jest równy temu zapisanemu w tej sesji. Jeśli jedno z tych warunków nie zo-stanie spełniony przerywane jest działanie funkcji i zapisany komunikat o nieprawidło-wym żetonie. Tak wprowadzone zabezpieczanie całkowicie uniemożliwi ataki CRSF. Atakujący nie będzie znał żetonu, zatem w związku z tym nie będzie mógł dokonać nieautoryzowanej akcji.
        </p>
</div>
<div data-button="csrf-fix-4" class="workspace lesson center">
    <h2> Zabezpieczona aplikacja</h2>
    <h3> Zastosowanie żetonu</h3>
        <a href="vulnerabilities/csrf/csrf-fix/index.php?action=transfer&userid=3&points=10" class="button">Wygrałeś 1000zł! Wejdź i odbierz nagrodę!</a>

        <div class="lessonContent">
            <?php include('source/functions.php'); ?>
        </div>
</div>