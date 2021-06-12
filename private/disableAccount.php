<?php
session_start();
require_once 'autoload.php';
Autoloader::push();
$db = dbConnect::connect();

$userInfo = new getInfo($db);
$obj = new check_update();
$status = $userInfo->sessionInfo()[0]["not_active"];

// désactive le compte ou le réactive selon le status => change valeur column active dans la bd
if ($status === "0") {
   $obj->disableAccount("not_active = 1");
  header("Location: " . "../Bienvenue");
}else{
   $obj->disableAccount("not_active = 0");
    header("Location: " . "../Profil/?id=".$_SESSION['id']);
}
dbConnect::disconnect();
