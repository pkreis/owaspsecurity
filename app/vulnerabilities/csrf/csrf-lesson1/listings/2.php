function pointsTransfer($conn)
  {
    if(!isset($_SESSION['zalogowany'])){
      sessionMsg('Najpierw musisz się zalogować.');
      return ACTION_FAILED;
    }
   
    if(!isset($_REQUEST['userid']) || !isset($_REQUEST['points'])){
      sessionMsg('Błędne dane.');
      return ACTION_FAILED;
    }
    
    $userid = intval($_REQUEST['userid']);
    $points = intval($_REQUEST['points']);
    
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
