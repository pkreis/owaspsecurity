  function showMessage()
  {
    $message = null;
    if(isset($_GET['id'])){
      $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
      if($id > 0){
        $message = getMessage($id);
      }  
    }
    include 'source/message.php';
  }
