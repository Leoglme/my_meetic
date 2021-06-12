<?php
session_start();
/*class verification formulaire de connexion*/
class loginFormVerify
{
    public $db;
    public $info = [];
    public $compare = [];
    public $securePwd;
    public $fetchClass;
    public $get;

    function __construct()
    {
        $this->info = array("email" => "", "password" => "", "emailError" => "", "passwordError" => "",
                            "errorStatus" => true, "disableAccount" => false, "sameLogin" => false, "userID" => "");
        include_once 'autoload.php';
        Autoloader::push();
        $this->db = dbConnect::connect();
        $this->securePwd = new hashedPass();
        $this->fetchClass = new fetch($this->db);
        $this->get = new getInfo($this->db);
        $this->verify();
    }

    public function verify()
    {
        $this->info["email"] = $this->verifyInput($_GET["email"]);
        $this->info["password"] = $this->verifyInput($_GET["password"]);
        $this->info["errorStatus"] = false;


        if (!isset($this->info["email"]) || empty($this->info["email"])) {
            $this->info["emailError"] = "Ce champ est vide !";
            $this->info["errorStatus"] = true;
        } elseif (!$this->isEmail($this->info["email"])) {
            $this->info["emailError"] = "email invalide !";
            $this->info["errorStatus"] = true;
        }
        if (!isset($this->info["password"]) || empty($this->info["password"])) {
            $this->info["passwordError"] = "Ce champ est vide !";
            $this->info["errorStatus"] = true;
        }

        //verification isset email et combinaison mdp/mail correct
        if ($this->info["errorStatus"] === false) {
            $email = $this->info["email"];
            $SQL = "SELECT password FROM login WHERE email = '$email'";
            $this->fetchClass->query($SQL, $this->compare);
            if (count($this->compare) !== 1 || $this->securePwd->samePwd($this->info["password"], $this->compare[0]["password"])) {
                $this->info["sameLogin"] = true;
                $this->info["errorStatus"] = true;
            }else{
                $this->isActiveAccount();
            }
        }

        //redirection et stockage session id users
        if ($this->info["errorStatus"] === false && $this->info["sameLogin"] === false) {
            $userinfo = $this->get->userInfo($this->info["email"]);
            $_SESSION['id'] = $userinfo[0]['id'];
            $this->info["userID"] = $userinfo[0]['id'];
        }

        $this->info["password"] = $this->securePwd->hash($this->info["password"]);
        echo json_encode($this->info);
    }

    public function isEmail($var)
    {
        return filter_var($var, FILTER_VALIDATE_EMAIL);
    }

    public function verifyInput($var)
    {
        $var = trim($var);
        $var = stripslashes($var);
        $var = htmlspecialchars($var);
        return $var;
    }

    public function isActiveAccount()
    {
        if (empty($this->info["emailError"])) {
            $isActive = $this->get->userInfo($this->info["email"])[0]["not_active"];

            if ($isActive === "1") {
                $this->info["disableAccount"] = true;
                $this->info["errorStatus"] = true;
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }


    }
}

$obj = new loginFormVerify();
dbConnect::disconnect();