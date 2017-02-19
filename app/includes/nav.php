<div id="mainMenu">
    <?php $active = 'class="active"';?>
    <?php ob_start(); ?>
    <header>
        <img src="style/images/owasp-logo.png" title="OWASP">
        <h1>Aplikacja wspomagająca naukę podatności bezpieczeństwa aplikacji internetowych na podstawie zestawienia OWASP TOP 10</h1>
    </header>
    <ul>
        
         <li <?php if ($menu == "intro") echo $active;?>>
            <p> Wprowadzenie</p>
            <ul>
                <li>
                    <a href=".">
                        O aplikacji
                    </a>
                </li>
            </ul>
        </li>
        <li <?php if ($menu == "A1") echo $active;?>>
            <p> A1. Injection</p>
            <ul>
                <li>
                    <a href="vulnerabilities/injection/sqli-lesson1/index.php">
                        SQL Injections: Lekcja 1
                    </a>
                </li>
                <li>
                    <a href="vulnerabilities/injection/sqli-lesson2/index.php">
                        SQL Injections: Lekcja 2
                    </a>
                </li>
                <li>
                    <a href="vulnerabilities/injection/sqli-lesson3/index.php">
                        SQL Injections: Lekcja 3
                    </a>
                </li>
                <li>
                    <a href="vulnerabilities/injection/sqli-fix/index.php">
                        SQL Injections: Obrona przed atakami
                    </a>
                </li>
            </ul>
        </li>
        <li <?php if ($menu == "A2") echo $active;?>>
            <p> A2. Broken Authentication and Session Management</p>
            <ul> 
                <li>
                    <a href="vulnerabilities/a2/a2-lesson/index.php">
                        Przechwytywanie sesji: Lekcja
                    </a>
                </li>
                <li>
                    <a href="vulnerabilities/a2/a2-fix/index.php">
                        Przechwytywanie sesji: Sposoby obrony
                    </a>
                </li>
            </ul>
        </li>
        <li <?php if ($menu == "A3") echo $active;?>>
            <p> A3. Cross Site Scripting (XSS): </p>
            <ul>
                <li>
                    <a href="vulnerabilities/xss/xss-lesson1/index.php">
                        XSS: Lekcja 1
                    </a>
                </li>
                <li>
                    <a href="vulnerabilities/xss/xss-lesson2/index.php">
                        XSS: Lekcja 2
                    </a>
                </li>
                <li>
                    <a href="vulnerabilities/xss/xss-fix/index.php">
                        XSS: Obrona przed atakami
                    </a>
                </li>
            </ul>
        </li>
        <li <?php if ($menu == "A4") echo $active;?>>
            <p> A4. Insecure Direct Object References</p>
            <ul>
                
                <li>
                    <a href="vulnerabilities/idor/idor-lesson1/index.php">
                        Lekcja
                    </a>
                </li>
                <li>
                    <a href="vulnerabilities/idor/idor-lesson1-fix/index.php">
                        Sposoby obrony
                    </a>
                </li>
            </ul>
        </li>
        <li <?php if ($menu == "A5") echo $active;?>>
            <p> A5. Security Misconfiguration</p>
            <ul>
                <li>
                    <a href="vulnerabilities/a5/a5-lesson/index.php">
                        Wysyłanie plików: Lekcja
                    </a>
                </li>
                <li>
                    <a href="vulnerabilities/a5/a5-fix/index.php">
                        Wysyłanie plików: Sposoby obrony
                    </a>
                </li>
            </ul>
        </li>
        <li <?php if ($menu == "A6") echo $active;?>>
            <p> A6. Sensitive Data Exposure </p>
            <ul>
                <li>
                    <a href="vulnerabilities/a6/a6-lesson/index.php">
                        Szyfrowanie hasła: Lekcja
                    </a>
                </li>
                <li>
                    <a href="vulnerabilities/a6/a6-fix/index.php">
                        Szyfrowanie hasła: Sposoby obrony
                    </a>
                </li>
            </ul>
        </li>
        <li <?php if ($menu == "A7") echo $active;?>>
            <p> A7. Missing Function Level Access Control </p>
            <ul>
                <li>
                    <a href="vulnerabilities/a7/a7-lesson1/index.php">
                        Lekcja
                    </a>
                </li>
                <li>
                    <a href="vulnerabilities/a7/a7-fix/index.php">
                        Sposoby obrony
                    </a>
                </li>
            </ul>
        </li>
        <li <?php if ($menu == "A8") echo $active;?>>
            <p> A8. Cross Site Request Forgery</p>
            <ul>
                <li>
                    <a href="vulnerabilities/csrf/csrf-lesson1/index.php">
                        Lekcja
                    </a>
                </li>
                <li>
                    <a href="vulnerabilities/csrf/csrf-fix/index.php">
                        Sposoby obrony
                    </a>
                </li>
            </ul>
        </li>
        <li <?php if ($menu == "A9") echo $active;?>>
            <p> A9. Using Components with Known Vulnerabilities </p>
            <ul>
                <li>
                    <a href="vulnerabilities/a9/a9-lesson/index.php">
                        Lekcja
                    </a>
                </li>
                <li>
                    <a href="vulnerabilities/a9/a9-fix/index.php">
                        Sposoby obrony
                    </a>
                </li>
            </ul>
        </li>
        <li <?php if ($menu == "A10") echo $active;?>>
            <p> A10. Unvalidated Redirects and Forwards</p>
            <ul>
                <li>
                    <a href="vulnerabilities/a10/a10-lesson/index.php">
                        Lekcja
                    </a>
                </li>
                <li>
                    <a href="vulnerabilities/a10/a10-fix/index.php">
                        Sposoby obrony
                    </a>
                </li>
            </ul>
        </li>
    </ul>
    <div id="author">
        Autor: Paweł Kreis
    </div>
</div>