<?php
include_once '../private/autoload.php';
Autoloader::push();
$db = dbConnect::connect();
$obj = new getInfo($db);
$obj->verifyGetId();
/* page profil qui existe pas */
if ($obj->resultInfo()[0]["id"] === NULL) {
    header("Location: " . "../Profil/?id=" . $_SESSION['id']);
}
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
</head>
<body>
<header>
    <div class="navbar__header">
        <a href="../" class="logo_link"><img class="meetic__logo" src="../public/assets/images/logo.png" alt="logo My meetic"></a>

        <!-- Overlay profil-->
        <div class="profil__overlay">
        <span class="rounded__overlay">
            <img class="rounded__img" alt="profil image"
                 src="https://demos.creative-tim.com/argon-dashboard/assets/img/theme/team-4.jpg">
        </span>
            <?php
            $obj->verifyGetId();
            /* page profil qui existe pas */
            if ($_GET['id'] !== NULL && !empty($_SESSION)){
            /* valeur => table users */
            foreach ($obj->sessionInfo() as $value){
                echo '<span class="profil__overlay--name">' . $value["activeFirstname"] . " " . $value["activeLastname"] . '</span>';
            }
            foreach ($obj->ClassFetch->result as $value) {
            ?>
            <div class="dropdown-menu show">
                <a href= "../Profil/?id=<?= $_SESSION["id"] ?>" class="dropdown-item">
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
                <h1 class="welcome__titre">Profil de <?= $value["firstname"] ?></h1>
                <p class="text-white mt-0 mb-5">Bienvenue sur le profil Mymeetic de <?= ucfirst($value["firstname"]) ?>, ici tu peux retrouver ses
                    informations et avoir un aperçu sur le reste de son profil, bonne et agréable expérience sur le site</p>
            </div>
        </div>
    </div>
</div>

<!--Partie profil -->
<div class="container-fluid">
    <div class="row justify-content-center">
        <!--Partie apercu profil-->
        <div class="col-xl-5 order-xl-2 mb-5 mb-xl-0">
            <div class="card">
                <div class="row justify-content-center">
                    <div class="col-lg-3 order-lg-2">
                        <div class="card-profile-image">
                            <a href="#">
                                <img src="https://demos.creative-tim.com/argon-dashboard/assets/img/theme/team-4.jpg"
                                     class="rounded-circle" alt="profil image">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-header border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                </div>


                <div class="card-body pt-0 pt-md-4">
                    <div class="text-center">
                        <h3 class="user__name"><?= $value["firstname"] . " " . $value["lastname"] ?></h3>
                        <span class="font-weight-light"><?= $obj->calculAge($value["date_naissance"]) ?> ans</span>

                        <div class="user__location">
                            <i class="fas fa-map-marker-alt"></i><?= " " . $value["ville"] ?>
                        </div>
                        <div class="user__gender mt-3 mb-1">
                            <i class="fas fa-venus-mars"></i><?= "  Genre : " . $value["genre"] ?>
                        </div>
                        <div class="user__hobbies">
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
    </div>
</div>


<footer>
    <div class="footer__container">
        <img class="meetic__logo" src="../public/assets/images/logo.png" alt="logo Mymeetic">
    </div>
    <h5 class="copyright">© COPYRIGHT 2020 LÉO MYMEETIC - PROJET</h5>
</footer>
<?php
}
}else {
    header("Location: " . "../Bienvenue");
}
?>
</body>
</html>