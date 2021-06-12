<?php
class getInfo
{
    public $db;
    public $ClassFetch;
    public $ClassFetch2;
    public $arrayHobbies = [];
    public $userInfo = [];
    public $resultInfo = [];
    public $sessionInfo = [];

    function __construct($db)
    {
        $this->db = $db;
        include_once 'fetch.php';
        $this->ClassFetch = new fetch($db);
        $this->ClassFetch2 = new fetch($db);
    }

    public function getHobbies()
    {
        $SQL = "SELECT * FROM hobbies";
        $this->ClassFetch->query($SQL, $this->arrayHobbies);
        return $this->arrayHobbies;

    }

    public function getCity()
    {
        $city = [];
        $SQL = "SELECT DISTINCT ville FROM users";
        $this->ClassFetch->query($SQL, $city);
        return $city;

    }

    public function userInfo($email)
    {
        $SQL = "SELECT * FROM users INNER JOIN login ON users.id = login.id_users WHERE email = '$email'";
        $this->ClassFetch->query($SQL, $this->userInfo);
        return $this->userInfo;
    }

    public function verifyGetId()
    {
        if (isset($_GET['id']) and !empty($_GET['id']) and $_GET['id'] > 0) {
            $_GET['id'] = intval($_GET['id']);
            return $_GET['id'];
        } else {
            return $_GET['id'] = NULL;
        }
    }

    public function resultInfo()
    {
        $usersId = $_GET['id'];
        $SQL = "SELECT * FROM users INNER JOIN login ON users.id = login.id_users 
                                    INNER JOIN hobbies ON users.id_hobbies = hobbies.id_hobbies
                                    WHERE users.id = '$usersId'";
        $this->ClassFetch->query($SQL, $this->resultInfo);
        return $this->resultInfo;
    }
    public function sessionInfo()
    {
        $usersId = $_SESSION['id'];
        $SQL = "SELECT firstname as activeFirstname, lastname as activeLastname, not_active FROM users WHERE id = '$usersId'";
        $this->ClassFetch2->query($SQL, $this->sessionInfo);
        return $this->sessionInfo;
    }

    public function calculAge($dateNaissance)
    {
        $today = date("Y-m-d");
        $diff = date_diff(date_create($dateNaissance), date_create($today));
        return $diff->format('%y');
    }

}