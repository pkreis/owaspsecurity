<?php
define("LOGIN_OK", 1);
define("LOGIN_FAILED", 2);
define("SERVER_ERROR", 3);
 

$action = 'main';
if(isset($_REQUEST['action'])){
  $action = $_REQUEST['action'];
}
switch($action){
    case 'login' : 
      switch(login($conn)){
        case LOGIN_OK:
        default:
          header('Location: index.php');
      }
      return;
    case 'logout':
      clearMsg();
      logout();
      header('Location:index.php');
      break;
    case 'transfer' : 
        clearMsg();
        pointsTransfer($conn);
        header('Location:index.php');
        break;
    case 'showtransfer' : 
        clearMsg();
        getTransferForm($conn);
      break;
    default : content($conn);
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
  function login($conn)
  {
    
    unset($_SESSION['zalogowany']);

    if ($conn->connect_error) {
        sessionMsg('Błąd połączenia z bazą danych');
      return SERVER_ERROR;
    } 

    if(!isset($_POST["user"]) || !isset($_POST["pass"])){
      echo ('Błędne dane logowania.');
      return LOGIN_FAILED;
    }

    $user = $_POST["user"];
    $pass = $_POST["pass"];
    
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

    if($result->num_rows){
      $result->bind_result($haslo, $nazwa, $id);
      $result->fetch();
      $array = array(
        "Nazwa" => $nazwa,
        "Id" => $id,
      );
      sessionMsg("Zalogwano pomyślnie");
      $_SESSION['zalogowany'] = $array  ;
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
  function pointsTransfer($conn)
  {
    if(!isset($_SESSION['zalogowany'])){
      sessionMsg('Najpierw musisz się zalogować.');
      return ACTION_FAILED;
    }
   
    //sprawdzenie czy zostały przekazane parametry
    if(!isset($_REQUEST['userid']) || !isset($_REQUEST['points'])){
      sessionMsg('Błędne dane.');
      return ACTION_FAILED;
    }
    
    $userid = intval($_REQUEST['userid']);
    $points = intval($_REQUEST['points']);
    $token = $_REQUEST['token'];
    
    //sprawdzenie poprawności tokena
    if(!isset($_SESSION['tokenCheck']) || 
      $token != $_SESSION['tokenCheck']){
      sessionMsg('Nieprawidłowy token.');
      return ACTION_FAILED;
    }
    
    if($userid < 1 || $points < 0){
      sessionMsg('Błędne dane.');
      return ACTION_FAILED;
    }
    
    $conn->autocommit(false);
    
    $query1 = "UPDATE a7_uzytkownicy SET Punkty = Punkty - $points "
            . "WHERE id = {$_SESSION['zalogowany']['Id']}";
           
    if(!$conn->query($query1)){
      sessionMsg('Błąd serwera bazy danych. Punkty nie zostały przekazane. ');
      return ACTION_FAILED;
    }
    
    $query2 = "UPDATE a7_uzytkownicy SET Punkty = Punkty + $points "
            . "WHERE id = $userid";
    
    if(!$conn->query($query2)){
      sessionMsg('Błąd serwera bazy danych. Punkty nie zostały przekazane. ');
      return ACTION_FAILED;
    }
    
    $conn->commit();
    
    sessionMsg('Punkty zostały przekazane.');
    return LOGIN_OK;
  }
  function pointsAmmount($id,$conn)
  {
    $query = "SELECT punkty FROM a7_uzytkownicy WHERE id=$id";

    if(!($result = $conn->query($query)) || !($row = $result->fetch_row())){
      return false;
    }
    return $row[0];
  }
  function getToken()
  {
    $random = mt_rand();
    $token = hash('md5', $random);
    return $token;
  }
  function getTransferForm($conn)
  {
    $query = "SELECT id, nazwa FROM a7_uzytkownicy WHERE id != {$_SESSION['zalogowany']['Id']}";

    if(!($result = $conn->query($query)) || !($users  = $result->fetch_all(MYSQLI_ASSOC))){
      $users = array();
    }
    
    $ammount = pointsAmmount($_SESSION['zalogowany']['Id'], $conn);
    $user = $_SESSION['zalogowany']['Nazwa'];
    
    $token = getToken();
    $_SESSION['tokenCheck'] = $token;  
      
    include 'source/transfer.php';
  }
  
  function content($conn)
  {
    if(isset($_SESSION['zalogowany'])){
      $ammount = pointsAmmount($_SESSION['zalogowany']['Id'], $conn);
      $user = $_SESSION['zalogowany']['Nazwa'];
    }
    include 'source/home.php';
  }
?>