<header>
    <div class="wrapper">
        <h2> Porywanie sesji </h2>
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
    <h2> Atak na logowanie</h2>
    <p>
        Porwanie sesji (ang. session hijacking) polega na przejęciu identyfikatora sesji, a następ-nie użycie go przez włamywacza podszywając się pod użytkownika. 
    </p>
    <p>
        Przeanalizowany zostanie przykład logowania do serwisu użytkownika. Wykorzystany zostanie kod źródłowy zastosowany w poprawionej wersji logowania z poprzedniego roz-działu. Dane logowania uzupełnione zostały w tabeli następującym zapytaniem: 
    </p>
    <xmp class="prettyprint">
INSERT INTO `a1_uzytkownicy` (`Id`, `Nazwa`, `Haslo`) VALUES
(1, 'login1', 'haslo1'),
(2, 'login2', 'haslo2'),
(3, 'login3', 'haslo3');
    </xmp>
    <p>
        Użytkownik poprzez formularz logowania uzyskuje uwierzytelnienie w serwisie. Po po-myślnym procesie wyświetlany zostaje komunikat o pomyślnym zalogowaniu oraz wy-świetlony jest identyfikator sesji. Celem atakującego jest wykorzystanie poznanego iden-tyfikatora sesji i zalogowanie się do serwisu bez potrzeby znajomości loginu oraz hasła.
    </p>
</div>
<div data-button="a1-sqli-lesson1-2" class="workspace lesson center">
    <h2> Badanie podatności</h2>
        <div class="lessonContent">
            