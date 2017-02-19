        </div>
</div>
<div data-button="a10-lesson-2" class="workspace center">
    <div class="attacker">
      <h4>Zaloguj się w ciągu 24h, a otrzymasz darmowe 100zł!</h4>
      <a href="vulnerabilities/a10/a10-lesson/login.php?redirect=%2E%2E%2Fa10-ext%2Findex%2Ephp" class="button">http://localhost/owasp/vulnerabilities/a10/a10-fix/login.php?redirect=%2E%2E%2Fa10-ext%2Findex%2Ephp</a>
    </div>
</div>
<div data-button="a10-lesson-3" class="workspace">
    <h2> Kod źródłowy</h2>
    <h3> Strona główna</h3>
    <xmp class="prettyprint">
<?php echo file_get_contents( "source/index.php" ); ?>
    </xmp>
    <h3> Formularz logowania</h3>
    <xmp class="prettyprint">
<?php echo file_get_contents( "source/login.php" ); ?>
    </xmp>
    <h3>Funkcje aplikacji</h3>
    <xmp class="prettyprint">
<?php echo file_get_contents( "source/functions.php" ); ?>
    </xmp>
</div>
<div data-button="a10-lesson-4" class="workspace">
    <h2> Analiza podatności</h2>
    <p>
        Stosowanie bezpośrednich przekierowań na stronie jest poważnym błędem bez-pieczeństwa, który może zostać wykorzystany w celu wyłudzenia danych osobowych czy innych danych poufnych takich jak loginy i hasła. Atakujący może na swoim serwisie utworzyć kopię podatnego serwisu tak, aby użytkownik po przekierowaniu nie spostrzegł się, że znalazł się na innej stronie internetowej. Nieświadomie zatem wpisuje swoje dane logowania, sądząc iż nadal działa w obrębie zaufanej aplikacji internetowej. Atakujący wystarczy że przygotuje odpowiednie żądanie, i wyśle je ofierze, która na pierwszy rzut oka nie zauważy niebezpieczeństwa, bowiem odnośnik będzie kierował do znanego mu serwisu:
    </p>
    <xmp class="prettyprint">
http://localhost/owasp/vulnerabilities/a10/a10-lesson/login.php?redirect=%2E%2E%2Fa10-ext%2Findex%2Ephp    
    </xmp>
    <p>
        Stosując kodowanie procentowe znaków ukrył on ścieżkę, tak że rozszyfrowanie jest kło-potliwe i niezauważalne dla typowego użytkownika Internetu. Po odkodowaniu ścieżka przekierowania będzie miała wartość ../a10-ext/index.php czyli adres, który w tym przy-kładzie symuluje zewnętrzny serwis.
    </p>
    <p>
        Efektem wywołania będzie w pierwszej kolejności przekierowanie do prawdziwe-go formularza logowania. Jednakże po pomyślnym zalogowaniu aplikacja przekieruje użytkownika na serwis atakującego, wyświetlając ten sam formularz z komunikatem o błędnie wpisanym haśle. Ofiara sądząc, iż źle wpisał swoje dane uwierzytelniające próbu-je ponownie, jednakże wpisane teraz dane trafiają już w ręce atakującego. W ten sposób często są wyłudzane poufne dane, zatem serwis należy poddać walidacji przekierowań z serwisu. 
    </p>
</div>