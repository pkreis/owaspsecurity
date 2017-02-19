function pointsAmmount($id,$conn)
  {
    $query = "SELECT punkty FROM a7_uzytkownicy WHERE id=$id";

    if(!($result = $conn->query($query)) || !($row = $result->fetch_row())){
      return false;
    }
    return $row[0];
  }
  function getTransferForm($conn)
  {
    $query = "SELECT id, nazwa FROM a7_uzytkownicy WHERE id != {$_SESSION['zalogowany']['Id']}";

    if(!($result = $conn->query($query)) || !($users  = $result->fetch_all(MYSQLI_ASSOC))){
      $users = array();
    }
    
    $ammount = pointsAmmount($_SESSION['zalogowany']['Id'], $conn);
    $user = $_SESSION['zalogowany']['Nazwa'];
    
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
