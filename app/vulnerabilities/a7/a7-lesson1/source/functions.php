<?php
define("LOGIN_OK", 1);
define("LOGIN_FAILED", 2);
define("SERVER_ERROR", 3);
 

$action = '';
if(isset($_REQUEST['action'])){
  $action = $_REQUEST['action'];
}
 switch($action){
    case 'login' : 
         login();
         break;
    case 'logout' : 
         logout();
         break;
    case 'showMessage' : 
         showMessage();
         break;
    case 'deleteMessage' : 
         deleteMessage();
         header('Location: index.php');
         return;
    default :content();
  }
  clearSessionMsg();


  function sessionMsg($message)
  {
    $_SESSION['info'] = $message;
  }
  function clearSessionMsg()
  {
    if(isset($_SESSION['info'])){
      unset($_SESSION['info']);
    }
  }
  function login()
  {
    unset($_SESSION['zalogowany']);
    if(isset($_REQUEST['user']) && isset($_REQUEST['pass'])){
      if($_REQUEST['user'] == 'login1' && $_REQUEST['pass'] == 'haslo1'){
        $_SESSION['zalogowany'] = 'Użytkownik 1';
      }
    }
    header('Location:index.php');
  }
  function logout()
  {
    unset($_SESSION['zalogowany']);
    header('Location:index.php');
  }
  function getList()
  {
    include 'source/data.php';
    
    //wyrzucenie "usuniętych" wiadomości
    $dataExample = array();
    foreach($data as $k => $message){
      if(isset($_SESSION['deleted']) && in_array($k, $_SESSION['deleted'])){
        continue;
      }
      $dataExample[] = $message;
    }
    return $dataExample;
  }
  function getMessage($id)
  {
    include 'source/data.php';
    if(array_key_exists($id, $data)){
      //symulacja usuniętej wiadomości
      if(isset($_SESSION['deleted']) && in_array($id, $_SESSION['deleted'])){
        return null;
      }
      return $data[$id];
    }
    else{
      return null;
    }
  }
  function deleteMessage()
  {
    $alert = $_POST['id'];
    if(isset($_POST['id'])){
      $id = intval($_POST['id']);
      if($id > 0){
        //symulacja usunięcia wiadomości
        include 'source/data.php';
        if(!isset($_SESSION['deleted'])){
          $_SESSION['deleted'] = array();
        }
        if(!in_array($id, $_SESSION['deleted']) && in_array($id, array_keys($data))){
          $_SESSION['deleted'][] = $id;
        }
        $alert = 'Wiadomość została usunięta.';
      }
    }
    sessionMsg($alert);
  }
  function content()
  {
    $messages = getList(isset($_SESSION['zalogowany']));
    include 'source/list.php';
  }
  function showMessage()
  {
    $message = null;
    if(isset($_GET['id'])){
      $id = intval($_GET['id']);
      if($id > 0){
        $message = getMessage($id);
      }
    }
    include 'source/message.php';
  }
?>