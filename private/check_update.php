<?php
session_start();
/*class verification formulaire modification de profil*/
class check_update
{
    public $db;
    public $info = [];
    public $duplicateMail;
    public $securePwd;
    public $ClassFetch;

    function __construct()
    {
        $this->info = array("firstname" => "", "lastname" => "", "city" => "", "email" => "", "password" => "",
                            "emailError" => "", "errorStatus" => true);
        include_once 'autoload.php';
        Autoloader::push();
        $this->db = dbConnect::connect();
        $this->ClassFetch = new fetch($this->db);
        $this->securePwd = new hashedPass();
        $this->duplicateMail = new duplicateEmail();
        $this->verify();
    }

    public function verify()
    {
        $this->info["errorStatus"] = false;
        $params = '';

        //si $_POST["valeur"] es remplis par l'user => update
        if (isset($_POST) && !empty($_POST)) {
            foreach ($_POST as $key => $result) {
                if (!empty($result)) {
                    if ($key === "password") {
                        $result = $this->securePwd->hash($result);
                    }
                    $this->info[$key] = $this->verifyInput($_POST[$key]);
                    $params .= " $key = '$result' , ";
                }
            }

            //verification isset email et validité du email
            if (isset($this->info["email"]) && !$this->isEmail($this->info["email"])) {
                $this->info["emailError"] = "email invalide !";
                $this->info["errorStatus"] = true;
            } else if ($this->duplicateMail->email($this->info["email"]) === true && $this->info["email"] !== $this->getEmail()) {
                $this->info["emailError"] = "Désolé cette adresse email est déjà utilisée !";
                $this->info["errorStatus"] = true;
            }

            $params = substr($params, 0, -2);
            if ($this->info["errorStatus"] === false) {
                $this->update($params);
            }

        }
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

    public function update($var)
    {
        //updates des infos users en fonction des valeur existante
        $SQL = "UPDATE users INNER JOIN login ON users.id = login.id_users SET $var WHERE id = " . $_SESSION['id'];
        $stmt = $this->db->prepare($SQL);
        $stmt->execute();
    }

    public function disableAccount($var){
        $this->update($var);
    }

    public function getEmail()
    {
        $array = [];
        $SQL = "SELECT email FROM login INNER JOIN users ON users.id = login.id_users WHERE users.id =". $_SESSION["id"];
        $this->ClassFetch->query($SQL, $array);
        return $array[0]["email"];

    }
}

$obj = new check_update();

dbConnect::disconnect();