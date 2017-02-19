<?php
define("LOGIN_OK", 1);
define("LOGIN_FAILED", 2);
define("SERVER_ERROR", 3);
 


$action = '';
if(isset($_REQUEST['action'])){
  $action = $_REQUEST['action'];
}
switch($action){
    case 'getuploadform' : 
      clearMsg();
      getUploadForm();
      break;
    case 'upload' : 
      clearMsg();
      upload($conn);
      header('Location: index.php?action=showuploadform');
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
  function upload($conn)
  {
    $uploadDir = './images/';
    if(!isset($_FILES['file']) || !isset($_REQUEST['desc'])){
      sessionMsg('Proszę używać fomularza ze strony.');
    }
    else if($_FILES['file']['error'] == UPLOAD_ERR_OK){
    
      $tmp_name = $_FILES['file']['tmp_name'];
      $type = $_FILES['file']['type'];
      $path_parts = pathinfo($_FILES['file']['name']);
      $extension = $path_parts['extension'];
      $filename = md5(uniqid(rand(), true)).'.'.$extension;
      $name = $uploadDir.$filename; 
      $imagesize = getimagesize($tmp_name);
        
      if($type != 'image/jpeg' && $type != 'image/gif' && $type != 'image/png' && $imagesize == FALSE){
        sessionMsg('Akceptujemy tylko pliki typów JPEG, GIF i PNG.');
      }   
      else if(move_uploaded_file($tmp_name, $name)){
        $desc = $conn->real_escape_string($_REQUEST['desc']);
          
        $query = "INSERT INTO a5_pliki_fix (nazwa, opis) VALUES(?, ?)";
        
        if(!$result = $conn->prepare($query)){
          sessionMsg('Błąd połączenia z bazą danych.');
        }  
        if(!$result->bind_param("ss", $filename, $desc) || !$result->execute() || !$result->store_result() ){
          sessionMsg('Błąd połączenia z bazą danych.');
        }  

        else{
          sessionMsg('Plik został załadowany.');
        }
      }
      else{
        sessionMsg('Wystąpił błąd. Plik nie został załadowany.');
      }
    }
    else{
      sessionMsg('Wystąpił błąd. Plik nie został załadowany.');
    }
  }
  
  function getList($conn)
  {
    $query = "SELECT * FROM a5_pliki_fix";

    if($result = $conn->query($query)){
      if($rows = $result->fetch_all(MYSQLI_ASSOC)){
        return $rows;
      }
      else{
        return array();
      }
    }
    else{
      return array();
    }
  }
  
  function getUploadForm()
  {
    include 'source/upload.php';
  }
  
  function content($conn)
  {
    $images = getList($conn);
    include 'source/list.php';
  }
?>