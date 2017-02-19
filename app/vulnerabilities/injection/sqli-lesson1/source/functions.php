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
        content();
        return;
    case 'logout': logout();
        content();
        return;
    default : content();
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
    $query .= "FROM a1_uzytkownicy WHERE Nazwa='$user' AND Haslo='$pass'";

    if(!$result = $conn->query($query)){
      sessionMsg('Błąd połączenia z bazą danych.');
      return SERVER_ERROR;
    }

    //Sprawdzenie wyników zapytania.
    if($result->num_rows){
      $row = $result->fetch_row();
      sessionMsg("Zalogwany jako {$row[1]}.");
      $_SESSION['zalogowany'] = $row[1];
      return LOGIN_OK;
    }
    else{
      sessionMsg('Błędny login lub hasło.');
      return LOGIN_FAILED;
        
    }
}
function logout()
{
    unset($_SESSION['zalogowany']);
    sessionMsg('Zostałeś wylogowany.');
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
function content()
  {
    if(isset($_SESSION['zalogowany'])){
      include 'logged.php';
    }
    else{
      include 'code.php';
    }
  }
?>