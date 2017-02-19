<header>
    <div class="wrapper">
        <h2> SQL Injections </h2>
        <h3> (Wstrzyknięcia do baz SQL)</h3>
        <div class="navbar">
            <img src="style/images/logo_polsl_aei.png">
        </div>
    </div>
    <div class="panel">
        <button data-button="a1-intro-1">Opis podatności</button>
    </div>
</header>
<div class="blankspace" style="height:180px;"></div>
<div data-button="a1-intro-1" class="workspace">
    <h2> SQL Injection</h2>
    <p>
        SQL Injection to atak na aplikację polegający na nieuprawnionym wstrzyknięciu (ang. injection) i wykonaniu kodu SQL. Jest możliwy wszędzie tam, gdzie serwer przyjmuje dane zewnętrzne, które są następnie używane w zapytaniach bez odpowiedniego przefiltrowania lub też z niewystarczającym filtrowaniem. Jest to jeden z najczęstszych kończących się sukcesem ataków na aplikacje webowe, i to mimo bardzo dużej obecnie świadomości deweloperów. Podatność na ataki typu SQL Injection wciąż jest bardzo powszechna.
    </p>
    <p>
        Skutki mogą być bardzo poważne, począwszy od nieautoryzowanego zalogowania się do serwisu, poprzez wykradzenie danych, a skończywszy na skasowaniu lub uszkodzeniu bazy. Wszystko zależy od tego, jakie zapytanie uda się przemycić atakującemu oraz czy będzie możliwe wykonanie tego zapytania w bazie (w całości lub w części), a więc od tego, jak skonfigurowany jest serwer i jakie są dostępne uprawnienia przy wykonywaniu zapytań z aplikacji webowej. W skrajnym przypadku błąd SQL Injection może wręcz umożliwić wykonanie poleceń systemu operacyjnego.
    </p>
</div>
