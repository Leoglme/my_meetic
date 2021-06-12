<?php
session_start();
/* Class filtre de recherche */
class filter
{
    public $db;
    public $params;
    public $inputCity;
    public $inputGender;
    public $inputHobbies;
    public $postArray = [];
    public $ClassFetch;

    function __construct($input)
    {
        include_once 'autoload.php';
        Autoloader::push();
        $this->db = dbConnect::connect();
        $this->ClassFetch = new fetch($this->db);
        $this->inputCity = $input[0];
        $this->inputGender = $input[1];
        $this->inputHobbies = $input[2];
    }

    public function filterResult()
    {
        if (isset($_POST) && !empty($_POST)) {
            $this->params = "";
            $this->countParams($this->inputCity, $this->inputGender, $this->inputHobbies);
            $this->params = substr($this->params, 0, -4);
            $sth = $this->db->prepare("SELECT * FROM users INNER JOIN login ON users.id = login.id_users WHERE " .$this->params);
            $sth->execute($this->postArray);
            $sth = $sth->fetchAll();
            if (empty($sth)) {
                return $this->showAll();
            }
            return $sth;
        }else{
            return $this->showAll();
        }
    }

    public function countParams($val1, $val2, $val3){
        if (isset($_POST[$val1])) {
            $val1 = $_POST[$val1];
            $this->countFilter($val1, "ville = ?");
            $this->push($val1, $this->postArray);
        }
        if (isset($_POST[$val2])) {
            $val2 = $_POST[$val2];
            $this->countFilter($val2, "genre = ?");
            $this->push($val2, $this->postArray);
        }
        if (isset($_POST[$val3])) {
            $val3 = $_POST[$val3];
            $this->countFilter($val3, "id_hobbies = ?");
            $this->push($val3, $this->postArray);
        }
    }

    public function push($var, &$array){
        for ($i = 0; $i < count($var); $i++) {
            array_push($array, $var[$i]);
        }
    }

    public function countFilter($input, $param){
        for ($i = 0; $i < count($input); $i++) {
            if ($i === count($input) - 1) {
                $this->params .= "$param AND ";
            }else{
                $this->params .= "$param OR ";
            }
        }
    }

    public function showAll(){
        $userInfo = [];
        $SQL = "SELECT * FROM users INNER JOIN login ON users.id = login.id_users";
        $this->ClassFetch->query($SQL, $userInfo);
        array_push($userInfo, $this->currentGender());
        return $userInfo;
    }

    public function currentGender(){
        $userInfo = [];
        $SQL = "SELECT * FROM users WHERE id = " . $_SESSION['id'];
        $this->ClassFetch->query($SQL, $userInfo);
        return $userInfo;
    }
}

$bidule = new filter(array("city", "gender", "hobbies"));
echo json_encode($bidule->filterResult());


