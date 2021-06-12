<!DOCTYPE html>
<html lang="en">
<head>
    <title>MyMeetic</title>
    <link rel="icon" href="../public/assets/images/logo-onglet.png">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/CSS/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/054fdad312.js"></script>
    <script src="../public/js/signAjax.js"></script>
</head>
<body>
<?php
require_once "../private/autoload.php";
Autoloader::push();
$db = dbConnect::connect();
$getInfo = new getInfo($db);
?>
<div class="container__page">
    <div class="container__image--left">
        <img class="image__left--img" src="../public/assets/images/login-bg.png" alt="dating picture">
    </div>
    <div class="container__register">
        <form class="bd-search" id="connect-form" method="get" role="form">
            <div class="form__header">
                <h3 class="form__header--title">Connexion</h3>
                <img src="../public/assets/images/sign-up.png" alt="" class="sign-up-icon">
            </div>

            <div class="form-group">
                <label for="email">Email :</label>
                <input type="text" name="email" class="form-control" id="email">
                <p class="input__error-msg"></p>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" name="password" class="form-control" id="password">
                <p class="input__error-msg"></p>
            </div>
            <div class="form-group">
                <button type="submit" class="register__button--submit">Se connecter</button>
            </div>
            <div class="link_forms">
                <a href="../Inscription" class="alert-link input__error-msg">Vous pouvez créer un compte ici.</a>
            </div>
            <div class="alert alert-danger same" role="alert">
                <p class="alert__error-msg">Adresse email ou mot de passe incorrect !</p>
                <a href="../Inscription" class="alert-link">Vous pouvez créer un compte ici.</a>
            </div>

            <div class="alert alert-danger disable__account" role="alert">
                <p class="alert__error-msg">Votre compte est désactiver temporairement !</p>
                <a href="../private/disableAccount.php" class="alert-link">Vous pouvez réactiver votre compte ici.</a>
            </div>
        </form>
    </div>

</div>
</body>
</html>

