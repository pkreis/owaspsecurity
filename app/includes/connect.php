<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "owasptop10";

// Nawiązanie połączenia
$conn = new mysqli($servername, $username, $password, $dbname);

// Sprawdzenie połączenia
if ($conn->connect_error) {
    die("Błąd połączenia " . $conn->connect_error);
} 
?>

