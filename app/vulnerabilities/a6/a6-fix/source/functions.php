<?php
define("LOGIN_OK", 1);
define("LOGIN_FAILED", 2);
define("SERVER_ERROR", 3);
 
clearMsg();
$action = '';
if(isset($_REQUEST['action'])){
  $action = $_REQUEST['action'];
}
switch($action){
    case 'login' : login($conn);
        content($conn);
        return;
    case 'logout': logout();
        content($conn);
        return;
    case 'getId': getId($conn);
        content($conn);
        return;
    case 'register' : register($conn);
        content($conn);
        return;
    case 'registerForm': logout();
        registerForm();
        return;
    default : content($conn);
        return;
}



function login($conn)
{
    
    unset($_SESSION['zalogowany']);

    if ($conn->connect_error) {
        sessionMsg('Błąd połączenia z bazą danych');
      return SERVER_ERROR;
    } 

    //Sprawdzenie czy zostały przekazane parametry.
    if(!isset($_POST["user"]) || !isset($_POST["pass"])){
      echo ('Błędne dane logowania.');
      return LOGIN_FAILED;
    }

    $user = $_POST["user"];
    $pass = $_POST["pass"];
    
    //Wykonanie zapytania sprawdzającego poprawność danych.
    $query = "SELECT Haslo, Nazwa, Id ";
    $query .= "FROM a6_uzytkownicy_fix WHERE Nazwa=?";

    if(!$result = $conn->prepare($query)){
        sessionMsg('Błąd połączenia z bazą danych.');
        return SERVER_ERROR;
    }
    
    if(!$result->bind_param("s", $user) || !$result->execute() ||
       !$result->store_result()){
        sessionMsg('Błąd połączenia z bazą danych.');
        return SERVER_ERROR;
    }

    //Sprawdzenie wyników zapytania.
    if($result->num_rows){
      $result->bind_result($haslo, $nazwa, $id);
      $result->fetch();
      if (crypt($pass, $haslo) == $haslo){
        sessionMsg("Zalogwany jako $nazwa.");
        $_SESSION['zalogowany'] = $nazwa; 
        return LOGIN_OK;
      }
      else{
      sessionMsg('Błędne hasło.');
      return LOGIN_FAILED; 
      }
    }
    else{
      sessionMsg('Błędny login.');
      return LOGIN_FAILED;
        
    }
}
function generateSalt() {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 16; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    $salt = '$5$'.$randomString;  
    return $salt; 
}
function register($conn)
{
    
    unset($_SESSION['zalogowany']);

    if ($conn->connect_error) {
        sessionMsg('Błąd połączenia z bazą danych');
      return SERVER_ERROR;
    } 

    //Sprawdzenie czy zostały przekazane parametry.
    if(!isset($_POST["user"]) || !isset($_POST["pass"])){
      echo ('Błędne dane logowania.');
      return LOGIN_FAILED;
    }

    $user = $_POST["user"];
    $pass = $_POST["pass"];
    
    $pass = crypt($pass, generateSalt());
    
    //Wykonanie zapytania sprawdzającego poprawność danych.
    $query = "INSERT INTO a6_uzytkownicy_fix (Nazwa, Haslo)";
    $query .= "VALUES (?,?)";

    if(!$result = $conn->prepare($query)){
        sessionMsg('Błąd połączenia z bazą danych.');
        return SERVER_ERROR;
    }
    
    if(!$result->bind_param("ss", $user, $pass) || !$result->execute()){
        sessionMsg('Błąd połączenia z bazą danych.');
        return SERVER_ERROR;
    }
       
    sessionMsg('Dodano użytkownika');   
    return LOGIN_OK;

}
function logout()
{
    unset($_SESSION['zalogowany']);
}
function sessionMsg($msg)
{
    $_SESSION['info'] = $msg;
}
function clearMsg()
{
    if(isset($_SESSION['info'])){
      unset($_SESSION['info']);
    }
}
function getId($conn)
{
    $user  = $_POST[ "username" ];  
    $query = "SELECT Id FROM a6_uzytkownicy_fix WHERE Nazwa='$user'";

    if(!$result = $conn->query($query)){
      sessionMsg('Błąd połączenia z bazą danych.');
      return SERVER_ERROR;
    }

    //Sprawdzenie wyników zapytania.
    if($result->num_rows){
      $row = $result->fetch_row();
      sessionMsg("Identyfikator użytkownika '$user' to {$row[0]}.");
      return LOGIN_OK;
    }
}
function getUsernames($conn)
{
    $query = "SELECT Nazwa FROM a6_uzytkownicy_fix";

    if(!($result = $conn->query($query)) || !($users  = $result->fetch_all(MYSQLI_ASSOC))){
      $users = array();
    }
    return $users;
}
function registerForm()
{
    if(!isset($_SESSION['zalogowany'])){
      include 'register.php';
    }
    else{
      sessionMsg('Musisz się najpierw wylogować.');
    }
}
function content($conn)
{
    if(isset($_SESSION['zalogowany'])){
      include 'logged.php';
    }
    else{
      $users = getUsernames($conn);
      include 'code.php';
    }
}
?>