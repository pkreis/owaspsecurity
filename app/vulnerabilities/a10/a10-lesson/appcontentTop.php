<header>
    <div class="wrapper">
        <h2> Brak walidacji przekierowań </h2>
        <div class="navbar">
            <img src="style/images/logo_polsl_aei.png">
        </div>
    </div>
    <div class="panel">
        <button data-button="a10-lesson-1">Opis zadania</button>
        <button data-button="a10-lesson-2">Lekcja</button>
        <button data-button="a10-lesson-3">Kod Źródłowy</button>
        <button data-button="a10-lesson-4">Analiza podatności</button>
    </div>
</header>
<div class="blankspace" style="height:180px;"></div>
<div data-button="a10-lesson-1" class="workspace">
    <h2>Przekierowanie z parametru</h2>
    <p>
        Logowanie do serwisu przekierowujące na daną podstronę może być przykładem aplikacji podatnej na ten typ ataku. Użytkownik niezalogowany posiada dostęp tylko do wstępu danego artykułu. Po zalogowaniu uzyska dostęp do pełnej zawartości. Na stronie artykułu znajduje się przycisk przekierowujący do logowania, które w przypadku powo-dzenia przeniesie użytkownika na docelową stronę z kompletną publikacją. 
    </p>
    <p>
        Celem atakującego jest przygotowanie odpowiedniego żądania, które najpierw zo-stanie wywołane na prawdziwym serwisie, po czym przekieruje użytkownika na stronę wyłudzającą dane.
    </p>
    <p>
        Dane logowania zostały uzupełnione w tabeli a1_uzytkownicy
    </p>
    <xmp class="prettyprint">
INSERT INTO `a1_uzytkownicy` (`Id`, `Nazwa`, `Haslo`) VALUES
(1, 'login1', 'haslo1'),
(2, 'login2', 'haslo2'),
(3, 'login3', 'haslo3');
    </xmp>
</div>
<div data-button="a10-lesson-2" class="workspace lesson center">
    <h2> Badanie podatności</h2>
        <div class="lessonContent">
            