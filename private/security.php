<?php
require_once 'autoload.php';
Autoloader::push();
$db = dbConnect::connect();

$fetchClass = new fetch($db);
$hshClass = new HashedPass();
$compare = [];

$toto = "totobidule@machin.com";

// select password from login where email = mail@machin.com
$SQL = "SELECT password FROM login WHERE email = '$toto'";
$fetchClass->query($SQL, $compare);

$pwd = "totobidudddle";

if (count($compare) > 1 || $hshClass->samePwd($pwd, $compare[0]["password"])) {
    echo "Adresse email ou mot de passe incorrect !";
}else{
    echo "c bon";
}