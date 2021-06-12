<?php
include_once '../private/autoload.php';
Autoloader::push();
$db = dbConnect::connect();
$obj = new getInfo($db);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MyMeetic</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../public/assets/images/logo-onglet.png">
    <link rel="stylesheet" href="../public/CSS/profil.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/054fdad312.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="../public/js/scrollingMenu.js"></script>
    <script src="../public/js/signAjax.js"></script>
</head>
<body>
<header>
    <div class="navbar__header">
        <a href="../" class="logo_link"><img class="meetic__logo" src="../public/assets/images/logo.png"
                                             alt="logo My meetic"></a>
        <!-- Overlay profil-->
        <div class="profil__overlay">
        <span class="rounded__overlay">
            <img class="rounded__img" alt="profil image"
                 src="https://demos.creative-tim.com/argon-dashboard/assets/img/theme/team-4.jpg">
        </span>
            <?php
            $obj->verifyGetId();
            /* page profil qui existe pas */
            if ($obj->resultInfo()[0]["id"] === NULL) {
                header("Location: " . "../Profil/?id=" . $_SESSION['id']);
            }
            /* valeur => table users */
            if ($_GET['id'] !== NULL && !empty($_SESSION)){
            foreach ($obj->ClassFetch->result as $value) {
            echo '<span class="profil__overlay--name">' . $value["firstname"] . " " . $value["lastname"] . '</span>';
            ?>
            <div class="dropdown-menu show">
                <a href="../Profil/?id=<?= $_SESSION["id"] ?>" class="dropdown-item">
                    <i class="fas fa-user"></i>
                    <span class="ml-1">Mon profil</span>
                </a>
                <a href="../" class="dropdown-item">
                    <i class="fas fa-search"></i>
                    <span class="ml-1">Trouver du monde</span>
                </a>
                <a class="dropdown-item disable__account">
                    <i class="fas fa-trash-alt"></i>
                    <span class="ml-1">Désactiver mon compte</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="../private/disconnect.php" class="dropdown-item">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="ml-1">Se déconnecter</span>
                </a>
            </div>
        </div>

    </div>


</header>

<div class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title" id="mod_lab_2">
                    <i class="fas fa-sad-cry" style="color: #ffffff"></i>
                    <span style="color: #ffffff; font-family: 'Roboto', sans-serif;">Désactiver votre compte ?</span>
                </span>
            </div>
            <div class="modal-body">
                <p>Voulez vous vraiment désactiver votre compte my Meetic ?</p>
            </div>
            <div class="modal-footer">
                <a href="../private/disableAccount.php" class="btn btn-info">Oui</a>
                <button type="button" class="btn btn-secondary close__modal">Non</button>
            </div>
        </div>
    </div>
</div>

<div class="welcome">
    <span class="mask__background"></span>
    <div class="container-fluid d-flex align-items-center">
        <div class="row">
            <div class="welcome__text col-lg-7 col-md-10">
                <h1 class="welcome__titre">Hello <?= $value["firstname"] ?></h1>
                <p class="text-white mt-0 mb-5">Voici la page de gestion ton compte, ici tu peux modifier et avoir un
                    aperçu de ton profil sur Mymeetic, bonne et agréable expérience sur le site </p>
                <form id="update-form" method="post" action="" role="form">
                    <button type="submit" class="btn btn-info">Valider le profil</button>
            </div>
        </div>
    </div>
</div>

<!--Partie profil -->
<div class="container-fluid">
    <div class="row">
        <!--Partie apercu profil-->
        <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
            <div class="card">
                <div class="row justify-content-center">
                    <div class="col-lg-3 order-lg-2">
                        <div class="card-profile-image">
                            <a href="#">
                                <img src="../public/assets/images/no-user.png"
                                     class="rounded-circle" alt="profil image">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-header border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                </div>


                <div class="card-body pt-0 pt-md-4">
                    <div class="text-center">
                        <h3 class="user__name apercu"><?= $value["firstname"] . " " . $value["lastname"] ?></h3>
                        <span class="font-weight-light"><?= $obj->calculAge($value["date_naissance"]) ?> ans</span>

                        <div class="user__location">
                            <i class="fas fa-map-marker-alt"></i><?= " " . $value["ville"] ?>
                        </div>
                        <div class="user__gender mt-3 mb-1">
                            <i class="fas fa-venus-mars"></i><?= "  Genre : " . $value["genre"] ?>
                        </div>
                        <div class="user__hobbies user__mail">
                            <i class="fas fa-envelope"></i><?= " Mon email : " . $value["email"] ?>
                        </div>
                        <div class="user__hobbies">
                            <i class="fas fa-walking"></i><?= " Activité préférée : " . $value["nom"] ?>
                        </div>
                        <hr class="my-4">
                        <p class="user__description"><?= $value["description"] ?></p>
                        <a href="#" class="btn btn-sm btn-default"><i class="fas fa-envelope"></i> Message</a>
                    </div>
                </div>
            </div>
        </div>

        <!--Partie edition profil-->

        <div class="col-xl-8 order-xl-1">
            <div class="card card__compte">
                <div class="card-header border-0 header__compte">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <h3 class="user__name">Mon compte</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <!-- FORMULAIRE MODIF -->

                    <h6 class="heading-small text-muted mb-4">Informations profil</h6>
                    <div class="pl-lg-4">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="firstname">Prenom</label>
                                    <input name="firstname" type="text" class="form-control" id="firstname"
                                           autocomplete="off" value="<?= $value["firstname"] ?>">
                                    <p class="input__error-msg"></p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="lastname">Nom</label>
                                    <input type="text" name="lastname" class="form-control" id="lastname"
                                           autocomplete="off" value="<?= $value["lastname"] ?>">
                                    <p class="input__error-msg"></p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="city">Ville</label>
                                    <input type="text" name="ville" class="form-control" id="city"
                                           autocomplete="off" value="<?= $value["ville"] ?>">
                                    <p class="input__error-msg"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-4 line__info--profil">
                    <h6 class="heading-small text-muted mb-4">Informations utilisateur</h6>
                    <div class="pl-lg-4">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="email">Email</label>
                                    <input type="text" name="email" class="form-control" id="email"
                                           value="<?= $value["email"] ?>">
                                    <p class="input__error-msg"></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="password">Mot de passe</label>
                                    <input type="password" name="password" class="form-control" id="password"
                                           autocomplete="off" placeholder="Nouveau mot de passe">
                                    <p class="input__error-msg"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-4">
                    <!-- Description -->
                    <h6 class="heading-small text-muted mb-4">Un peu plus sur toi</h6>
                    <div class="pl-lg-4">
                        <div class="form-group focused">
                            <label for="description">Description</label>
                            <textarea rows="4" name="description" id="description" class="form-control h-100"
                                      placeholder="Quelques mots sur toi  ..."></textarea>
                            <p class="input__error-msg"></p>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<footer>
    <div class="footer__container">
        <img class="meetic__logo" src="../public/assets/images/logo.png" alt="logo Mymeetic">
    </div>
    <h5 class="copyright">© COPYRIGHT 2020 MYMEETIC</h5>
</footer>
<?php
}
} else {
    header("Location: " . "../Bienvenue");
}
?>
</body>
</html>