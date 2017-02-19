<header>
    <div class="wrapper">
        <h2> Używanie komponentów ze znanymi podatnościami </h2>
        <div class="navbar">
            <img src="style/images/logo_polsl_aei.png">
        </div>
    </div>
    <div class="panel">
        <button data-button="a9-lesson-1">Opis zadania</button>
        <button data-button="a9-lesson-2">Lekcja</button>
        <button data-button="a9-lesson-3">Kod Źródłowy</button>
        <button data-button="a9-lesson-4">Analiza podatności</button>
    </div>
</header>
<div class="blankspace" style="height:180px;"></div>
<div data-button="a9lesson-1" class="workspace">
    <h2>Odpowiedni dobór komponentów</h2>
    <p>
        Administrator witryny często instaluje wtyczki do swojej aplikacji. W zaprezento-wanym przykładzie ma do wyboru licznik odwiedzin. Do uruchomienia są dwie wersje tego samego dodatku oznaczone numerem wersji 1.0 oraz 1.1. Wtyczka ma za zadanie zliczać ilość wyświetleń, a także wyświetlać statystyki odwiedzin wybranej z listy daty.
    </p>
    <p>
        Celem atakującego jest atak na serwis poprzez wykorzystanie luk bezpieczeństwa znajdujących się w nieaktualnej wersji 
    </p>
</div>
<div data-button="a9-lesson-2" class="workspace lesson center">
    <h2> Badanie podatności</h2>
        <div class="lessonContent">
            