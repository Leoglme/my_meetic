<?php
session_start();
include_once '../private/autoload.php';
Autoloader::push();
$db = dbConnect::connect();
$obj = new getInfo($db);
$obj->verifyGetId();


if (isset($obj->resultInfo()[0]["id"]) && $_SESSION['id'] === $obj->resultInfo()[0]["id"]) {
    include_once('profil_private.php');
}else{
    include_once('profil_public.php');
}
