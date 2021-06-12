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
        <form class="bd-search" id="register-form" method="post" action="" role="form">
            <div class="form__header">
                <h3 class="form__header--title">S'inscrire</h3>
                <img src="../public/assets/images/sign-up.png" alt="" class="sign-up-icon">
            </div>


            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="firstname">Prénom :</label>
                    <input name="firstname" type="text" class="form-control" id="firstname" autocomplete="off">
                    <p class="input__error-msg"></p>
                </div>


                <div class="form-group col-md-6">
                    <label for="lastname">Nom :</label>
                    <input type="text" name="lastname" class="form-control" id="lastname" autocomplete="off">
                    <p class="input__error-msg"></p>
                </div>
            </div>

            <div class="form-group">
                <label for="email">Email :</label>
                <input type="text" name="email" class="form-control" id="email">
                <p class="input__error-msg"></p>
            </div>
            <div class="form-group">
                <label for="Password">Mot de passe :</label>
                <input type="password" name="password" class="form-control" id="password">
                <p class="input__error-msg"></p>
            </div>
            <div class="form-group">
                <label for="Birth">Date de naissance :</label>
                <input class="form-control" name="birth" type="date" value="2020/01/19" id="Birth">
                <p class="input__error-msg"></p>
            </div>


            <div class="form-row">

                <div class="form-group col-md-6">
                    <label for="gender">Genre :</label>
                    <select class="form-control customDropdown" name="gender" id="gender" data-toggle="dropdown">
                        <option class="" value="homme" selected>Homme</option>
                        <option value="femme">Femme</option>
                        <option value="autre">Autre</option>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="Hobbies">Loisirs :</label>
                    <select class="form-control customDropdown" name="hobbies" id="Hobbies" data-toggle="dropdown">
                        <?php
                        foreach($getInfo->getHobbies() as $hobbies){
                          echo '<option value="'.$hobbies["id_hobbies"].'">'.$hobbies["nom"].'</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="city">Ville :</label>
                <input type="text" name="city" class="form-control" id="city" autocomplete="off">
                <p class="input__error-msg"></p>
            </div>

            <button type="submit" class="register__button--submit">Commencer</button>
        </form>
    </div>

</div>
</body>
</html>
