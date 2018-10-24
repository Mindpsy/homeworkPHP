<?php 

class Config {
    public $host;
    public $dbname;
    public $login;
    public $password;
    public $pdo;

    public function __construct ($tmpHost, $tmpDbname, $tmpLogin, $tmpPassword) {
        $this->host = $tmpHost;
        $this->dbname = $tmpDbname;
        $this->login = $tmpLogin;
        $this->password = $tmpPassword;
    }

    // метод соеденения с базой 
    public function connectDataBase ($config) {
        $this->pdo = new PDO("mysql:host={$config->host};dbname={$config->dbname};charset=utf8", $config->login, $config->password);
        return $this->pdo;
    }
} 

?>