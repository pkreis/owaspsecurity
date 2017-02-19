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
    case 'login' : 
        login($conn);
        return;
    case 'logout': 
        logout();
        return;
}



function login($conn)
{

    $user = $_POST["user"];
    $pass = $_POST["pass"];
    

    sessionMsg('Twoje dane logowania zostały ukradzione!');


}
function logout()
{
    unset($_SESSION['zalogowany']);
}
function sessionMsg($msg)
{
    $_SESSION['hacked'] = $msg;
}
function clearMsg()
{
    if(isset($_SESSION['hacked'])){
      unset($_SESSION['hacked']);
    }
}
?>