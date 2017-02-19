<?php
define("LOGIN_OK", 1);
define("LOGIN_FAILED", 2);
define("SERVER_ERROR", 3);
 

$action = '';
if(isset($_REQUEST['action'])){
  $action = $_REQUEST['action'];
}
switch($action){
    case 'counter1.0' : counterOld($conn);
        return;
    case 'counter1.1': counterNew();
        return;
    default : content();
        return;
}

function counterOld($conn)
{
     header('Location: counter1.0.php');
}
function counterNew($conn)
{
     header('Location: counter1.1.php');

}
function content()
{
      include 'home.php';

}
?>