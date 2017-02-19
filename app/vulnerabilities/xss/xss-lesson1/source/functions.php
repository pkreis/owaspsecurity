<?php


define("OK", 1);
define("FAILED", 2);
define("SERVER_ERROR", 3);
 
$action = '';
if(isset($_REQUEST['action'])){
  $action = $_REQUEST['action'];
}
switch($action){
    case 'addPost' : 
      switch(addPost($conn)){
       case(OK):
          header('Location:index.php?action=showPosts');
          break;
        default:
          header('Location:index.php?action=showPosts');
      }
      return;
    case 'showPosts' : showPosts($conn);
      break;
    default : content($conn);
        return;
}
clearMsg();


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
  function addPost($conn)
  {
    if(!(isset($_POST['autor']) && ($autor = $_POST['autor']) &&
       isset($_POST['tresc']) && ($tresc = $_POST['tresc']))){
      sessionMsg("Proszę podać poprawne dane.");
      return FAILED;
    }
    
    $message = $conn->real_escape_string( $_POST[ 'tresc' ] );
	$name    = $conn->real_escape_string( $_POST[ 'autor' ] );  
      
    $query  = "INSERT INTO a3_ksiega_gosci (autor,tresc) ";
    $query .= "VALUES ('$name', '$message' )";
    
    if($result = $conn->query($query)){
        sessionMsg("Wpis został dodany do księgi gości.");
    }
    else{
        sessionMsg('Błąd dodawania.');
    } 
    return OK;
  }
  function getPosts($conn)
  {
    $query  = "SELECT autor, tresc, data FROM a3_ksiega_gosci";
    if(!$result = $conn->query($query)){
      sessionMsg('Lista wiadomości nie jest dostępna1.');
      return array();
    }
    
    if(!$rows = $result->fetch_all(MYSQLI_ASSOC)){
      sessionMsg('Lista wiadomości nie jest dostępna2.');
      return array();
    }  
    return $rows;
  }
  function content($conn)
  {
    include 'source/code.php';
  }
  function showPosts($conn)
  {
    $gbdata = getPosts($conn);
    include 'source/guestbook.php';
  }

?>