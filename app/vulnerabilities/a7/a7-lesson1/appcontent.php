<header>
    <div class="wrapper">
        <h2> Nieodpowiednia kontrola uprawnień użytkowników </h2>
        <h3> </h3>
        <div class="navbar">
            <img src="style/images/logo_polsl_aei.png">
        </div>
    </div>
    <div class="panel">
        <button data-button="a1-sqli-lesson1-1">Opis zadania</button>
        <button data-button="a1-sqli-lesson1-2">Lekcja</button>
        <button data-button="a1-sqli-lesson1-3">Kod Źródłowy</button>
        <button data-button="a1-sqli-lesson1-4">Analiza podatności</button>
    </div>
</header>
<div class="blankspace" style="height:180px;"></div>
<div data-button="a1-sqli-lesson1-1" class="workspace">
    <h2> Kontrola dostępu do funkcji</h2>
    <p>
        Równie ważnym problemem jak kontrola dostępu do danych jest kontrola dostępu do funkcji. Lista wiadomości jest wyświetla analogicznie jak w powyższym przykładzie. Nie znajduje się tu jednak podział na informacje dostępne dla zalogowanych i niezalogowanych. Dodatkową funkcjonalnością zatem jest możliwość usuwania wiadomości tylko dla użytkowników zalogowanych.
    </p>
    <p>
       Użytkownik z listy wybiera tytuł wiadomości i za pomocą przycisku Sprawdź wiadomość sprawdza jej zawartość. Znajduje się tu także formularz logowania, by uzyskać dostęp do dodatkowej opcji usuwania wiadomości. Dane testowe logowania to login1/haslo1.
    </p>
    <p>
       Po wyświetleniu danej wiadomości, jeśli użytkownik posiada dodatkowy przycisk służący do usuwania wiadomości. Dodatkowo u spodu znajduje się odnośnik powracający do widoku listy.
    </p>
    <p>
       Celem atakującego jest usunięcie danej wiadomości bez konieczności logowania się do serwisu. 
    </p>
</div>
<div data-button="a1-sqli-lesson1-2" class="workspace lesson center">
    <h2> Badanie podatności</h2>
        <div class="lessonContent">
            <?php include('source/functions.php'); ?>
        </div>
</div>
<div data-button="a1-sqli-lesson1-3" class="workspace">
    <h2> Kod źródłowy</h2>
    <h3> Formularz logowania i wyboru wiadomości</h3>
    <xmp class="prettyprint">
<?php echo file_get_contents( "source/list.php" ); ?>
    </xmp>
    <p>
        Pętlą foreach pobierane są wszystkie wiadomości z tablicy $mossages, i zapisywane do listy znajdującego się w znaczniku select. Wyświetlany jest tytuł, a wartością pola opcji jest identyfikator wiadomości. Formularz posiada ukryte pole o nazwie action, w celu przekazania tego parametru o wartości showMessage. Wybierając odpowiedni tytuł i wysłąjąc żądanie formularz wysyła identyfikator wiadomości, której treść zostanie wyświetlona.  
    </p>
    <p>
        Logowanie odbywa się tutaj w ten sam sposób jak w przykładzie o kontroli dostępu do danych. Jeśli użytkownik nie jest zalogowany wyświetlany jest formularz wysyłający paramatry user i pass. Użytkownik niezalogowany posiada przycisk, który spowoduje jego wylogowanie.
    </p>
    <h3> Zawartość danej wiadomośći</h3>
    <xmp class="prettyprint">
<?php echo file_get_contents( "source/message.php" ); ?>
    </xmp>
    <p>
        W pierwszej kolejności sprawdzane jest czy wiadomość istnieje, po czym zostaje wyświetlona. Następuje instrukcja warunkowa weryfikująca czy użytkownik jest zalogowany. Jeśli warunek ten jest prawdą to wyświetlany jest formularz wysyłający żądanie usunięcia wiadomości. W ukrytych dla przeglądarki polach przekazane są parametry action wywołujący funkcję oraz id wysyłający identyfikator wiadomości do usunięcia. U dołu strony znajduję się przycisk powrotu do listy wiadomości.
    </p>
    <h3>Funkcje pobierania danych</h3>
    <xmp class="prettyprint">
<?php echo file_get_contents( "source/functions.php" ); ?>
    </xmp>

    <p>
        Dane wyświetlane w liście są przygotowywane przez funkcję getList. Treści wiadomości pobierane są z tablicy $data znajdującej się pliku data.php. Dane w pętli są zapisywane w tablicy $dataExpmple po sprawdzeniu czy któraś z wiadomości nie została usunięta podczas tej sesji. Dane w tym przykładzie usuwane są tylko wirtualnie w celach instruktażowych.
    </p>
    <p>
        Pobranie pojedynczej wiadomości przetwarza funkcja getMessage, która jako parametr otrzymała identyfikator wiadomości. Sprawdzane jest czy dana wiadomość znajduje się w tablicy $data, a następnie sprawdza czy nie została już wcześniej usunięta sprawdzając czy wiersz nie znajduje się w sesji deleted. Funkcja zwraca wiersz wynikowy o wskazanym identyfikatorze. 
    </p>
    <p>
        Funkcja odpowiedzialna za usuwanie wiadomości pobiera z wysłanego formularza parametr id. Jeśli nie istniała wcześniej sesja deleted to zostaje ona utworzona. Kolejnym krokiem jest sprawdzenie czy wiadomość nie została już wcześniej usunięta, i gdy nie jest jej identyfikator zostaje przypisany do sesji deleted, przez co nie będzie już wyświetlana na liście wiadomości.  
    </p>
</div>
<div data-button="a1-sqli-lesson1-4" class="workspace">
    <h2> Analiza podatności</h2>
    <p>
        Przy takiej realizacji aplikacji internetowej występują błędy kontroli dostępu do funkcji. Niezalogowany użytkownik po analizie kodu źródłowego może spróbować dokonać ataku na stronę. Wyświetlając zawartość danej wiadomości adres url żądania wygląda następująco:
    </p>
    <xmp class="prettyprint">
index.php?id=5&action=showMessage
    </xmp>
    <p>
        Widać wyraźnie, iż wiadomość wyświetlana jest dzięki parametrowi action o wartości showMessage. Posiadając ten informację atakujący może w dowolny sposób zmienić wartość tego parametru. Spróbuje on zatem fraz, które mogą się wiązać z usuwaniem danej informacji np. delMessage, rmMessage, deleteMessage, removeMessage. Jak już wiadomo w naszym skrypcie znajduje się właśnie funkcja o nazwie deleteMessage, odpowiadająca za usuwanie wiadomości. Analizując kod źródłowy funkcji widzimy, że nie znajduje się w nim żadna weryfikacja odnośnie autoryzacji użytkownika. Zmieniając jednak żądanie w adresie URL atakujący nie usunie wiadomości, gdyż funkcja oczekuje parametru id otrzymanego metodą POST, a nie metodą GET. W tym wypadku atakujący musi zmodyfikować formularz wyboru listy, bądź użyć specjalistycznego oprogramowania do wysyłania zapytań. Najprostszym jednak sposobem jest wykorzystanie narzędzi developerskich przeglądarki. Formularz można zmodyfikować następująco:
    </p>
        <xmp class="prettyprint">
<form action="vulnerabilities/idor/idor-lesson2/index.php" method="post">
  <select size="6" name="id">
          <option value="1">Wiadomość ABC </option>
          <option value="3">Wiadomość RST</option>
          <option value="3">Wiadomość FGH</option>
          <option value="4">Wiadomość STU</option>
          <option value="5">Wiadomość KLM</option>
      </select>
  <input type="hidden" name="action" value="deleteMessage">
  <input type="submit" value="Sprawdź wiadomość">
</form>      
    </xmp>
    <p>
        Jak widzimy została zmieniona metoda wysyłania formularza z GET na POST oraz zmiana wartości w ukrytym polu o nazwie action wartości showMessage na deleteMessage. Po tych zmianach klikając w przycisk Sprawdź wiadomość zamiast wyświetlenia wiadomości zostanie ona usunięta.
    </p>
    <xmp class="prettyprint">
if(!isset($_SESSION['zalogowany'])){
	$alert = 'Brak uprawnień. Nie można usunąć wiadomości.';
}
else if(isset($_POST['id'])){
//kod usunięcia wiadomości
}
else{
	$alert = 'Błędne dane. Nie można usunąć wiadomości.';
}
sessionMsg($alert); 
   
    </xmp>
</div>