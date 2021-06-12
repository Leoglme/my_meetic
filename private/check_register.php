<?php
/*class verification formulaire d'inscription*/
class registerFormVerify
{
    public $info = [];
    public $securePwd;
    public $duplicateMail;
    public $db;

    function __construct()
    {
        $this->info = array("firstname" => "", "lastname" => "", "email" => "", "password" => "", "birth" => "", "gender" => "",
            "city" => "", "hobbies" => "", "firstnameError" => "", "lastnameError" => "", "emailError" => "", "passwordError" => "",
            "birthError" => "", "genderError" => "", "cityError" => "", "hobbiesError" => "", "errorStatus" => true);
        include_once 'autoload.php';
        Autoloader::push();
        $this->securePwd = new hashedPass();
        $this->duplicateMail = new duplicateEmail();
        $this->db = dbConnect::connect();
        $this->verify();
    }

    public function verify()
    {
        $i = 0;
        foreach ($this->info as $key => $value) {
            if ($i <= 7) {
                $this->info[$key] = $this->verifyInput($_POST[$key]);
            }
            $i++;
        }
        $this->info["errorStatus"] = false;
        $this->info["password"] = $this->securePwd->hash($this->info["password"]);
        if ($this->duplicateMail->email($this->info["email"]) === true) {
            $this->info["emailError"] = "Un compte existe déjà pour cette adresse email !";
            $this->info["errorStatus"] = true;
        }


        $this->isEmpty();
        echo json_encode($this->info);
        if($this->info["errorStatus"] === false){
            $this->insertDb();
        }
    }

    public function isEmpty()
    {

        $i = 0;
        $postValue = [];
        $error = [];
        $values = [];
        foreach ($this->info as $key => $value) {
            if ($i <= 7) {
                array_push($postValue, $key);
                array_push($values, $value);
            } elseif ($i > 7 && $i < 16) {
                array_push($error, $key);
            }
            $i++;
        }

        for ($i = 0; $i < count($postValue); $i++) {

            if (!isset($_POST[$postValue[$i]]) || empty($_POST[$postValue[$i]])) {
                $this->info[$error[$i]] = "Ce champ est vide !";
                $this->info["errorStatus"] = true;
            } else if ($postValue[$i] === "birth" && $this->isMajor($this->info["birth"]) === true) {
                $this->info["birthError"] = "Vous devez avoir 18 ans !";
                $this->info["errorStatus"] = true;
            }else if($postValue[$i] === "email" && !$this->isEmail($this->info["email"])){
                $this->info["emailError"] = "Email invalide !";
                $this->info["errorStatus"] = true;
            }else if (strlen($values[$i]) > 100) {
                $this->info[$error[$i]] = "Nombre de caractères trop élevés !";
                $this->info["errorStatus"] = true;
            }

        }

    }

    public function isMajor($inputDate)
    {
        $inputDate = date("Ymd", strtotime($inputDate));
        $inputDate = intval($inputDate, 10);
        $today = intval(date("Ymd"), 10);
        $majorDate = $today - 180000;
        if ($inputDate > $majorDate) {
            return true;
        } else {
            return false;
        }
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

    private function insertDb(){
        $addUser = 'INSERT INTO users (firstname, lastname, date_naissance, ville, genre, id_hobbies, date_inscription)
                VALUES (?, ?, ?, ?, ?, ?, ?)';
        $addLogin = 'INSERT INTO login (email, password) VALUES (?, ?)';
        $pdo = $this->db ->prepare($addUser);
        $pdo->execute(array($this->info["firstname"], $this->info["lastname"], $this->info["birth"], $this->info["city"],
            $this->info["gender"], $this->info["hobbies"], date('Y/m/d h:i:s a')));
        $pdo = $this->db ->prepare($addLogin);
        $pdo->execute(array($this->info["email"], $this->info["password"]));
    }

}

$obj = new registerFormVerify();
dbConnect::disconnect();

