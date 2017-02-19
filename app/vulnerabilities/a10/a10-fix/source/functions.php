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
        return;
    case 'logout': logout();
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
    $query .= "FROM a1_uzytkownicy WHERE Nazwa=? AND Haslo=?";

    if(!$result = $conn->prepare($query)){
        sessionMsg('Błąd połączenia z bazą danych.');
        return SERVER_ERROR;
    }
    
    if(!$result->bind_param("ss", $user, $pass) || !$result->execute() ||
       !$result->store_result()){
        sessionMsg('Błąd połączenia z bazą danych.');
        return SERVER_ERROR;
    }

    //Sprawdzenie wyników zapytania.
    if($result->num_rows){
      $result->bind_result($haslo, $nazwa, $id);
      $result->fetch();
      sessionMsg("Zalogwany jako $nazwa.");
      $_SESSION['zalogowany'] = $nazwa;
      
      
      $redirect = $_POST["redirect"];
      if ($redirect == '0') { 
          
          header('Location: index.php'); 
      }
      else{
            $allowed = array(
                "index" => "index.php",
                "article"  => "article.php",
            );
            $url = isset($allowed[$redirect]) ? $allowed[$redirect] : "index.php";
            header('Location: '.$url);
      }
        

        
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
}
function checkReferer()
{
    if(isset($_SERVER['HTTP_REFERER']) && isset($_GET["redirect"])) {
        $allowed_host = 'localhost';
        $host = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);

        if(substr($host, 0 - strlen($allowed_host)) == $allowed_host) {
          return $_GET["redirect"];
        } else {
          return ;
        }  
    }
    else
    {
        return 0;
    }
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
?>