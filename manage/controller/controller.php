<?php 
require_once "../dumper.php";

/*
создать новую базу 
вывести список таблиц текущей базы 
войти в таблицу и смотреть название и тип поля 
удалить поле 
изменить тип поля 
изменить название поля 
*/ 



class Config {
    public $host;
    public $dbname;
    public $login;
    public $password;

    public function __construct ($tmpHost, $tmpDbname, $tmpLogin, $tmpPassword) {
        $this->host = $tmpHost;
        $this->dbname = $tmpDbname;
        $this->login = $tmpLogin;
        $this->password = $tmpPassword;
    }
} 

$config = new Config("localhost", "todoAplpication", "root", "");

if (!isset($_GET['controller']) || !isset($_GET['action'])) {
    $controller = "base";
    $action = "listTable";

} else if (($_GET['controller'] === "base") && ($_GET['action'] === "listTable")) {
    $controller = $_GET['controller'];
    $action = $_GET['action'];
} else if (($_GET['controller'] === "base") && ($_GET['action'] === "getFields")) {
    $controller = $_GET['controller'];
    $action = $_GET['action'];
} else if (($_GET['controller'] === "base") && ($_GET['action'] === "changeType")) {
    $controller = $_GET['controller'];
    $action = $_GET['action'];
} else if (($_GET['controller'] === "base") && ($_GET['action'] === "delField")) {
    $controller = $_GET['controller'];
    $action = $_GET['action'];
} else if (($_GET['controller'] === "base") && ($_GET['action'] === "changeName")) {
    $controller = $_GET['controller'];
    $action = $_GET['action'];
    dumper($resChange);
}

if($controller === "base") {
    require_once "../model/model.php";
    $model = new Model();
    $model->connectDataBase($config);
    $model->createTable();
    if ($action === "listTable") {
        $resTables = $model->showTables();    
        require_once "../view/viewListTable.php";
    } else if ($action === "getFields") {
        $table = $_GET['theTableOpen'];
        $resTypeFields = $model->describeFeilds($table);
        $resFields = $model->getFieldsTable2($table);
        require_once "../view/viewListFields.php";

    } else if ($action === "changeType") {
        $resChange = $model->changeType($_GET['theTableOpen'], $_GET['oldField'], $_GET['newTypeField']);
        dumper($resChange);

    } else if ($action === "delField") {
        $resDel = $model->deleteField($_GET['nameDelTable'], $_GET['nameDeletedField']);
        dumper("controller del:");
        dumper($resDel);
    } else if ($action === "changeName") {
        $resChName = $model->changeNameField($_GET['theTableOpen'], $_GET['oldField'], $_GET['newNameField'], $_GET['TypeField']);
        dumper($resChName);

    }

}


?>