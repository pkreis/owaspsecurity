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
    default : content($conn);
        return;
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
    $catQuery = '';
    if(isset($_REQUEST['cat']) && $_REQUEST['cat'] != ''){
      $catQuery = "AND kategoria = {$_REQUEST['cat']}";
    }
    
    $query  = "SELECT * FROM a1_wiadomosci WHERE aktywna = 1 $catQuery";
    
    if(!$result = $conn->query($query)){
      sessionMsg('Lista wiadomości nie jest dostępna.');
      return array();
    }
    
    if(!$rows = $result->fetch_all(MYSQLI_ASSOC)){
      sessionMsg('Lista wiadomości nie jest dostępna.');
      return array();
    }  
    return $rows;
  }
  function content($conn)
  {
    $categories = array(1 => 'Kategoria pierwsza', 2 => 'Kategoria druga');
    $data = getData($conn);
    include 'source/code.php';
  }
?>