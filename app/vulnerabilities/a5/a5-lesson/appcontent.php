<header>
    <div class="wrapper">
        <h2> Wysyłanie plików na serwer </h2>
        <div class="navbar">
            <img src="style/images/logo_polsl_aei.png">
        </div>
    </div>
    <div class="panel">
        <button data-button="a5-lesson1">Opis zadania</button>
        <button data-button="a5-lesson2">Lekcja</button>
        <button data-button="a5-lesson3">Kod Źródłowy</button>
        <button data-button="a5-lesson4">Analiza podatności</button>
    </div>
</header>
<div class="blankspace" style="height:180px;"></div>
<div data-button="a5-lesson1" class="workspace">
    <h2> Atak na logowanie</h2>
    <p>
        Aplikacja obsługująca galerię zdjęć jest odpowiednim przykładem ukazania braku weryfikacji wysyłanych plików. Użytkownik może wysłać obraz w formatach *.jpg , *.png oraz *.gif. Użytkownik dodatkowo będzie mógł dodać opis do zdjęcia. Na stronie głównej prezentowane zostaną wszystkie obrazy, wysłane przez użytkowników na serwer. 
    </p>
    <p>
        Celem atakującego jest wywołanie szkodliwych skryptów poprzez użycie formula-rza umożliwiającego przesłanie obrazu na serwer.
    </p>
</div>
<div data-button="a5-lesson2" class="workspace lesson center">
    <h2> Badanie podatności</h2>
        <div class="lessonContent">
            <?php include('source/functions.php'); ?>
        </div>
</div>
<div data-button="a5-lesson3" class="workspace">
    <h2> Kod źródłowy</h2>
        <h3> Lista obrazów</h3>
        <xmp class="prettyprint">
<?php echo file_get_contents( "source/list.php" ); ?>
        </xmp>
        <h3> Formularz wysyłania</h3>
        <xmp class="prettyprint">
<?php echo file_get_contents( "source/upload.php" ); ?>
        </xmp>
        <h3> Funkcje obsługujące wysyłanie plików</h3>
        <xmp class="prettyprint">
<?php echo file_get_contents( "source/functions.php" ); ?>
        </xmp>
</div>
<div data-button="a5-lesson4" class="workspace">
    <h2> Analiza podatności</h2>
    <p>
        Zaprezentowana aplikacja posiada kilka luk bezpieczeństwa, które atakujący może wykorzystać na różne sposoby. Pierwszym elementem, który jest do zauważenia, jest brak weryfikacji czy plik o danej nazwie już istnieje. Atakujący, a często nieświadomie również i użytkownik wgrywając plik o nazwie pliku, która już wcześniej istniała w sys-temie  nadpisze poprzedni plik. W ten sposób można usunąć całą zawartość strony, pod-mieniając ją własnymi plikami graficznymi.
    </p>
    <p>
        Drugim błędem jest podatność na atak SQL Injection. Pomimo, iż pole opisu zdję-cia jest odpowiednio zabezpieczone, to pobierana jest również do zapytania nazwa pliku wysyłana z formularza. We współczesnych systemach operacyjnych nie ma ograniczeń by zastosować poniższą nazwę pliku:
    </p>
    <xmp class="prettyprint">
a','',null);delete from images -- .jpg
    </xmp>
    <p>
        Ciąg ten zatem zostanie wstawiony do treści zapytania zawartego w kodzie aplikacji. Ca-łe zapytanie SQL będzie wyglądać następująco:
    </p>
    <xmp class="prettyprint">
INSERT INTO a5_pliki (nazwa, opis) 
VALUES('./images/a','',null);delete from a5_pliki -- .jpg', '')
    </xmp>
    <p>
        Efektem wykonania tego zapytania będzie usunięcie całej zawartości tabeli a5_pliki. Identycznym sposobem można dokonać ataku XSS. Nazwę pliku możemy określić nastę-pująco: 
    </p>
    <xmp class="prettyprint">
a'' onerror=alert(''XSS'') .jpg
    </xmp>
    <p>
        Tym sposobem atakujący wpisze do bazy skrypt, pobrany z wysyłanej nazwy pliku. W szablonie odpowiedzialnym za wyświetlenie obrazu, znacznik obrazu przyjąłby postać:
    </p>
    <xmp class="prettyprint">
<img src='./images/a' onerror=alert('XSS') .jpg'>
    </xmp>
    <p>
        Wynikiem tego jest nieprawidłowy znacznik &lt;img> z dopisanym atrybutem onerror, który zostanie właśnie wywołany i uruchomi skrypt napisany przez atakującego.
    </p>
    <p>
        Najgroźniejszym atakiem, a jednocześnie najmniej zabezpieczanym przez pro-gramistów problemem jest jednak zaufanie wbudowanej funkcji weryfikacji typu Con-tent-Type wysyłanych plików. Korzystając z narzędzia, w którym jesteśmy w stanie ma-nipulować wysyłanymi żądania (np. Fiddler), możliwe jest wysłanie pliku ze skryptem o innym rozszerzeniu modyfikując w nagłówku wartość Content-Type na image/jpeg.
    </p>
    <p>
        <img src="vulnerabilities/a5/a5-lesson/screen.png" style="max-width:60%; display:table; margin:auto auto auto auto;">
    </p>
    <p>
        Po modyfikacji żądania, plik zostanie umieszczony na serwerze, i wystarczy go wywołać poprzez adres url. Przy typowej konfiguracji serwera włamywacz będzie mógł tym spo-sobem wykonywać różne nieautoryzowane operacje.	
    </p>
</div>