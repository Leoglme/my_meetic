<?php
session_start();
if (!isset($_SESSION) || empty($_SESSION)) {
    header("Location: " . "Bienvenue");
}
include_once 'private/autoload.php';
Autoloader::push();
$db = dbConnect::connect();
$obj = new getInfo($db);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>MyMeetic</title>
    <link rel="icon" href="public/assets/images/logo-onglet.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/054fdad312.js"></script>
    <script src="public/js/profil.js"></script>
    <script src="public/js/signAjax.js"></script>
    <script src="public/js/scrollingMenu.js"></script>
    <link rel="stylesheet" href="public/CSS/profil.css">
    <link rel="stylesheet" href="public/CSS/profilCard.css">

<body>

<header>
    <div class="navbar__header">
        <a href="" class="logo_link"><img class="meetic__logo" src="public/assets/images/logo.png" alt="logo My meetic"></a>

        <!-- Overlay profil-->
        <div class="profil__overlay">
        <span class="rounded__overlay">
            <img class="rounded__img" alt="profil image"
                 src="https://demos.creative-tim.com/argon-dashboard/assets/img/theme/team-4.jpg">
        </span>
            <?php
            /* valeur => table users */
            foreach ($obj->sessionInfo() as $value) {
                echo '<span class="profil__overlay--name">' . $value["activeFirstname"] . " " . $value["activeLastname"] . '</span>';
            }
            ?>
            <div class="dropdown-menu show">
                <a href="Profil/?id=<?= $_SESSION["id"] ?>" class="dropdown-item">
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
                <a href="private/disconnect.php" class="dropdown-item">
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
                <a href="private/disableAccount.php" class="btn btn-info">Oui</a>
                <button type="button" class="btn btn-secondary close__modal">Non</button>
            </div>
        </div>
    </div>
</div>

<div id="left__menu">
    <input type="checkbox" name="\" id="side-menu-check">
    <div class="side-menu">
        <label id="arrow__label" for="side-menu-check">
            <i class="fas fa-chevron-right"></i>
        </label>
        <form id="filter_search" method="post" name="member_signup">
            <!-- Multiple select checkbox -->
            <div class="filter__container">
                <!-- FILTRE GENRE -->
                <div class="form-group col-md-3">
                    <div class="multiselect">
                        <div class="select__gender">
                            <label class="label__filter" for="gender">Genre :</label>
                            <select class="form-control customDropdown" id="gender">
                                <option value="" disabled selected hidden>Homme</option>
                            </select>
                            <div class="overSelect"></div>
                        </div>
                        <div id="checkboxes__gender">
                            <div class="form-check">
                                <input value="homme" class="switch__input" type="checkbox" name="gender[]"
                                       id="homme">
                                <label class="switch__label" for="homme"><span class="ball"></span></label>
                                <label class="form-check-label" for="check1">Homme</label>
                            </div>
                            <div class="form-check">
                                <input value="femme" class="switch__input" type="checkbox" name="gender[]"
                                       id="femme">
                                <label class="switch__label" for="femme"><span class="ball"></span></label>
                                <label class="form-check-label" for="check2">Femme</label>
                            </div>
                            <div class="form-check">
                                <input value="autre" class="switch__input" type="checkbox" name="gender[]"
                                       id="autre">
                                <label class="switch__label" for="autre"><span class="ball"></span></label>
                                <label class="form-check-label" for="check3">Autre</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FILTRE VILLE -->
                <div class="form-group col-md-3">
                    <div class="multiselect">
                        <div class="select__city">
                            <label class="label__filter" for="city">Ville :</label>
                            <select class="form-control customDropdown" id="city">
                                <option value="" disabled selected hidden>Rennes</option>
                            </select>
                            <div class="overSelect"></div>
                        </div>
                        <div id="checkboxes__city">
                            <?php
                            foreach ($obj->getCity() as $city) {
                                echo '<div class="form-check">
                                        <input value="' . ucfirst($city["ville"]) . '" type="checkbox" class="switch__input" name="city[]" id="'. $city["ville"] .'">
                                        <label class="switch__label" for="'. $city["ville"] .'"><div class="ball"></div></label>
                                         <label class="form-check-label" for="check1">' . ucfirst($city["ville"]) . '</label>
                            </div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <!-- FILTRE HOBBIES -->
                <div class="form-group col-md-3">
                    <div class="multiselect">
                        <div class="select__hobbies">
                            <label class="label__filter" for="hobbies">Loisirs :</label>
                            <select class="form-control customDropdown" id="hobbies">
                                <option value="" disabled selected hidden>Dance</option>
                            </select>
                            <div class="overSelect"></div>
                        </div>
                        <div id="checkboxes__hobbies">
                            <?php
                            foreach ($obj->getHobbies() as $hobbies) {
                                echo '<div class="form-check">
                                        <input value="' . $hobbies["id_hobbies"] . '" class="switch__input" type="checkbox" name="hobbies[]" id="'.$hobbies["nom"].'">
                                        <label class="switch__label" for="'. $hobbies["nom"] .'"><div class="ball"></div></label>
                                        <label class="form-check-label" for="check1">' . $hobbies["nom"] . '</label>
                                      </div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <button type="submit" class="register__button--submit">Commencer</button>
            </div>

        </form>
    </div>


</div>
<!--PROFIL CARD-->
<div class="welcome">
    <span class="mask__background"></span>
    <div class="container-fluid d-flex align-items-center">
        <div class="row">
            <div class="welcome__text col-lg-7 col-md-10">
            </div>
        </div>
    </div>
</div>
<div class="container-fluid card__container">
    <div class="card card__profil">
        <div class="row justify-content-center mb-3">
            <button type="button" class="btn btn-dark left rounded-circle mr-3"><i class="fas fa-arrow-left"></i>
            </button>
            <button type="button" class="btn btn-dark right rounded-circle"><i class="fas fa-arrow-right"></i></button>
        </div>
        <div class="card__footer">
            <div class="card__footer--name">
                <h5 class="result__name">Prenom nom</h5>
                <i class="fas fa-sort-up"></i>
            </div>
            <h5 class="age">24 Ans</h5>
            <div class="icon__disable">
                <i class="fas fa-map-marker-alt"></i>
                <p class="info result__city">Rennes</p>
            </div>
            <div class="icon__disable">
                <i class="fas fa-envelope"></i>
                <p class="info mail">toto@machin.com</p>
            </div>
            <div class="icon__disable">
                <i class="fas fa-venus-mars"></i>
                <p class="info result__gender">Femme</p>
            </div>
            <a href="" class="register__button--submit profil__btn" type="button">Voir son profil</a>
        </div>
    </div>
</div>

<footer>
    <div class="footer__container">
        <img class="meetic__logo" src="public/assets/images/logo.png" alt="logo Mymeetic">
    </div>
    <h5 class="copyright">© COPYRIGHT 2020 MYMEETIC</h5>
</footer>
<div class="switch__container">
    <input type="checkbox" name="city[]" id="bidule" class="switch__input" value="Rennes">
    <label for="bidule" class="switch__label"><div class="ball"></div></label>
</div>


</body>
</html>