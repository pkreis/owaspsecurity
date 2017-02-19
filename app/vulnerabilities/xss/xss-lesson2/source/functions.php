<?php


define("ACTION_OK", 1);
define("ACTION_FAILED", 2);
define("SERVER_ERROR", 3);
 
clearMsg();
$action = '';
if(isset($_REQUEST['action'])){
  $action = $_REQUEST['action'];
}
switch($action){
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
  function getData($conn)
  {
    $searchQuery = '';
    if(isset($_REQUEST['search']) && $_REQUEST['search'] != ''){
        
      $search = $conn->real_escape_string($_REQUEST['search']);
      $searchQuery = "tytul LIKE '%$search%' AND ";
    }
    $query  = "SELECT * FROM a1_wiadomosci WHERE $searchQuery aktywna = 1";
    
    if(!$result = $conn->query($query)){
      sessionMsg('Lista wiadomości nie jest dostępna.');
      return array();
    }
    
    if(!$rows = $result->fetch_all(MYSQLI_ASSOC)){
      sessionMsg('Brak wiadomości.');
      return array();
    }  
    return $rows;
  }
  function content($conn)
  {
    $data = getData($conn);
    include 'source/code.php';
  }
?>