<header>
    <div class="wrapper">
        <h2> Niezabezpieczone bezpośrednie odwołanie do obiektu </h2>
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
    <h2>Modyfikacje elementów interfejsu</h2>
    <p>
        Najbardziej ewidentnym przykładem braku kontroli dostępu do danych jest sytuacja, w której na serwisie ukrywanie danych odbywa się za pomocą wyłączenia części elementów interfejsu graficznego. 
    </p>
    <p>
        Przygotowany przykład serwisu wyświetla listę wiadomości, z czego część z nich dostępna jest tylko po zalogowaniu, jednakże wszystkie tytuły są wyświetlane zawsze. Wiadomości są wyświetlone jako elementy listy. Elementy dostępne dla wszystkich użytkowników są aktywne, a ty tylko dla zalogowanych są domyślnie wyłączone. Struktura tablicy z danymi jest następująca:
    </p>
    <xmp class="prettyprint">
<?php echo file_get_contents( "source/data.php" ); ?>
    </xmp>
    <p>
        Użytkownik wybierając aktywny tytuł z listy może za pomocą przycisku Sprawdź wiadomość zobaczyć zawartość danej informacji. Pod listą znajduje się formularz logowania, dzięki któremu po autoryzacji zalogowany użytkownik posiada wszystkie aktywne wiadomości.
    </p>
    <p>
        Celem atakującego jest wyświetlenie zawartości danej wiadomości bez konieczności logowania się.
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
        U samej góry szablonu widzimy listę wiadomości pobraną z tablicy $messages. W pętli foreach pobierane są wszystkie wiadomości, które w środku posiadają instrukcje warunkową sprawdzającą czy użytkownik jest zalogowany oraz czy wiadomość jest tylko dla zalogowanych. Jeśli wiadomość jest ukryta, a użytkownik niezalogowany do zmiennej $dis jest wstawiany ciąg disabled="disabled" , który jest następnie wstawiany jako parametr do danej wartości option w polu select z listą wiadomości, mając za zadanie wyłączyć dany wiersz. Po wybraniu odpowiedniego tytułu i wysłaniu żądania formularz za pomocą metody GET wysyła identyfikator wiadomości, która ma zostać wyświetlona.
    </p>
    <p>
        Poniżej sprawdzamy, czy użytkownik jest zalogowany, jeśli tak wyświetlany jest przycisk Wylogowanie, który w adresie URL posiada parametr action o wartości logout, dzięki któremu uruchomiana jest odpowiednia funkcja w serwisie, która wyloguje użytkownika. Jeśli użytkownik nie jest zalogowany widoczny jest formularz logowania z polami user oraz password , które metodą POST zostają przekazane funkcji logowania po wysłaniu formularza. 
    </p>
    <h3> Zawartość danej wiadomośći</h3>
    <xmp class="prettyprint">
<?php echo file_get_contents( "source/message.php" ); ?>
    </xmp>
    <p>
        Szablon strony wyświetlającej daną wiadomość posiada instrukcję warunkową, czy otrzymana tablica nie jest pusta, a następnie wyświetla zawartość kolumny title oraz content. Pod treścią wiadomości znajduje się przycisk powracający do listy wszystkich wiadomości.
    </p>
    <h3> Funkcje logowania i pobierania danych</h3>
    <xmp class="prettyprint">
<?php echo file_get_contents( "source/functions.php" ); ?>
    </xmp>
    <p>
        Za przygotowanie wiadomości do wyświetlenia odpowiada funkcja showMessage. Weryfikuje czy za pomocą formularza został przekazany parametr id , a następnie do zmiennej $message trafia rezultat wywołania funkcji $getMessage wraz z wartością pobraną z wcześniej wspomnianego parametru id. Sprawdzane jest za pomocą metody array_key_exists($id, $data) czy w tablicy wiadomości znajduje się element o określonym identyfikatorze i jeśli jest to zwraca ten wiersz wynikowy. W przeciwnym razie zwraca wartość null zatem zmienna $message pozostanie pusta.
    </p>
    <p>
        Znajduje się tu również prosta funkcja logująca użytkownika stworzona tylko w celu uwidocznia, iż niektóre wiadomości są dostępne tylko po logowaniu i nie powinno stosować się w aplikacjach takiego rozwiązania. Funkcja sprawdza czy za pomocą formularza logującego otrzymano parametry user oraz password, a następnie sprawdza je z sztywno zapisanymi w kodzie danymi logowania. Jeśli się zgadzają, użytkownik zostaje zalogowany. 
    </p>
</div>
<div data-button="a1-sqli-lesson1-4" class="workspace">
    <h2> Analiza podatności</h2>
    <p>
        Powyższy kod portalu posiada podstawowy błąd jakim jest zabezpieczenie zawartości tylko za pomocą graficznego wyłączenia danego elementu. Aby uzyskać dostęp do ukrytej treści wystarczy samodzielnie wywołać odnośnik strony głównej index.php z parametrami, które przekazuje formularz. Identyfikatory można podejrzeć w źródle strony w kodzie HTML:
    </p>
    <xmp class="prettyprint">
<select size="6" name="id">
    <option value="1">Wiadomość ABC </option>
    <option value="2" disabled="disabled">Wiadomość RST (widoczna po zalogowaniu)</option>
    <option value="3">Wiadomość FGH</option>
    <option value="4">Wiadomość STU</option>
    <option value="5" disabled="disabled">Wiadomość KLM  (widoczna po zalogowaniu)</option>
</select>
    </xmp>
    <p>
        Wiedząc, iż parametr action o wartości showMessage wyświetla wiadomość o danym identyfikatorze wystarczy wywołać stroną następującym adresem url:
    </p>
    <xmp class="prettyprint">
index.php?id=5&action=showMessage
    </xmp>
    <p>
        W ten sposób wywołana jest funkcja wyświetlająca zawartość o identyfikatorze 5 i wyświetlona na ekran. Innym sposobem wyświetlenia tej informacji jest zastosowanie narzędzi developerskich przeglądarki. W tym przypadku wystarczyłoby usunąć atrybut disabled=”disabled” , aby dana wiadomość stała się aktywna. Można wtedy wyświetlić jej zawartość w taki sam sposób jak inne klikając w przycisk Sprawdź wiadomość.
    </p>
</div>