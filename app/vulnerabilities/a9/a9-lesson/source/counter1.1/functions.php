<?php

$action = '';
if(isset($_REQUEST['action'])){
  $action = $_REQUEST['action'];
}
switch($action){
    case 'getdaycounter' : daycounter($conn);
        counter($conn);
        return;
    default : counter($conn);
        return;
}

function daycounter($conn)
{ 
    $date = $conn->real_escape_string($_POST['date']);
    $query = "SELECT licznik FROM a9_licznik WHERE data='$date'";

    if(!$result = $conn->query($query)){
      sessionMsg('Błąd połączenia z bazą danych2.');
      return SERVER_ERROR;
    }

    //Sprawdzenie wyników zapytania.
    if($result->num_rows){
      $row = $result->fetch_row();
      echo "Liczba odwiedzin w dniu <b>".$date." </b> wyniosła: <b>".$row[0]."</b><br>";
      return $row[0];
    }
}
function counterall($conn)
{
    $query = "SELECT SUM(licznik) FROM a9_licznik";

    if(!$result = $conn->query($query)){
      sessionMsg('Błąd połączenia z bazą danych2.');
      return SERVER_ERROR;
    }

   //Sprawdzenie wyników zapytania.
    if($result->num_rows){
      $row = $result->fetch_row();
      return $row[0];
    }
} 
function counterlast($conn)
{
    $query = "SELECT data FROM a9_licznik ORDER BY data DESC LIMIT 0,1";

    if(!$result = $conn->query($query)){
      sessionMsg('Błąd połączenia z bazą danych3.');
      return SERVER_ERROR;
    }

    //Sprawdzenie wyników zapytania.
    if($result->num_rows){
      $row = $result->fetch_row();
      return $row[0];
    }
}
function setCount($conn){
    $data = date('Y-m-d');
    if (counterlast($conn)==$data)
    {
        $query = "UPDATE a9_licznik SET licznik=licznik+1 WHERE data = '$data';";
        if(!$result = $conn->query($query)){
          sessionMsg('Błąd połączenia z bazą danych.');
          return SERVER_ERROR;
        }
    }
    else
    {
        $query = "INSERT INTO a9_licznik (data, licznik) VALUES ('$data',1)";
        if(!$result = $conn->query($query)){
          sessionMsg('Błąd połączenia z bazą danych4.');
          return SERVER_ERROR;
        }
    }
}
function getDates($conn)
  {
    $query = "SELECT data FROM a9_licznik";

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
function counter($conn)
{
    setCount($conn);
    $dates = getDates($conn);

    include 'form.php';
    $all = counterall($conn);
    include 'counter.php';
}

?>