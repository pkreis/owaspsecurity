<?php
define("LOGIN_OK", 1);
define("LOGIN_FAILED", 2);
define("SERVER_ERROR", 3);
 

$action = 'main';
if(isset($_REQUEST['action'])){
  $action = $_REQUEST['action'];
}
switch($action){
    case 'login' : login();
        break;
    case 'logout' : logout();
        break;
    case 'showMessage' : 
        showMessage();
        break;
    default : content();
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
    return $data;
  }
  function getMessage($id)
  {
    include 'source/data.php';
    if(array_key_exists($id, $data)){
      return $data[$id];
    }
    else{
      return null;
    }
  }
  function content()
  {
    $messages = getList();
    include 'source/list.php';
  }
  function showMessage()
  {
    $message = null;
    if(isset($_GET['id'])){
      $message = getMessage($_GET['id']);
    }
    include 'source/message.php';
  }
?>