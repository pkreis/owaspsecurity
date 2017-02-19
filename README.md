# Aplikacja wspomagająca naukę podatności bezpieczeństwa aplikacji internetowych na podstawie zestawienia OWASP Top 10

## Instalacja
Pliki źródłowe należy umieścić na dowolnym serwerze obsługujący interpreter PHP (np. Apache lub nginx). W przypadku jeśli ścieżka dostępu do aplikacji będzie inna niż http://locahost/owasp/ należy dokonać w nagłówku strony w pliku /includes/header.php zmiany bazowego adresu w linii:

`<base href="http://localhost/owasp/" />`    

Zawartość bazy należy zaimportować do nowo utworzonej bazy danych MySQL. Zostaną utworzone odpowiednie tabele wypełnione przykładowymi wartościami. Następ-nie należy dokonać konfiguracji połączenia w pliku źródłowym /includes/connect.php . Uzupełniamy adres serwera bazy danych, użytkownika, hasło oraz zastosowaną nazwę bazy da-nych. Po wykonaniu tych operacji aplikacja jest gotowa i użytkownik może rozpocząć naukę o podatnościach bezpieczeństwa.

