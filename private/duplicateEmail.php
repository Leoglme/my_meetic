<?php
class duplicateEmail
{
    public $db;
    public $classFetch;
    public $arrayEmail = [];

    function __construct()
  {
      require_once 'autoload.php';
      Autoloader::push();
      $this->db = dbConnect::connect();
      $this->classFetch = new fetch($this->db);

  }

    public function email($mail)
    {
        $SQL = "SELECT email FROM login WHERE email = '$mail'";
        $this->classFetch->query($SQL, $this->arrayEmail);
        if(empty($this->arrayEmail)){
            return false;
        }else{
            return true;
        }
    }

}
dbConnect::disconnect();