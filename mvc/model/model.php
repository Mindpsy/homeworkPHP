<?php 
require_once "config.php";
// Подключаем полезную для отладки функцию dumper() 
require_once "dumper.php";
ini_set('error_reporting', E_ALL);

class Model {

    // шаблоны запросов для операций с базой 
    public $sqlLoginIsSet = "SELECT id FROM user WHERE login= ?";
    public $sqlAddUser = "INSERT INTO user( login, password) VALUES ( ?, ?)";
    public $sqlLogPassIssSet = "SELECT login FROM user WHERE login=? AND password=?";
    public $sqlIdForLogin = "SELECT id FROM user WHERE login=?";
    public $sqlUpdateAsigned = "UPDATE task SET assigned_user_id=? WHERE id=? AND user_id=?";
    public $sqlMyBussiess = "SELECT id, user_id, assigned_user_id, description, is_done, date_added FROM task WHERE user_id=? ORDER BY date_added";
    public $sqlLoginForId = "SELECT id, login FROM user WHERE id=?"; 
    public $sqlAddNewTask = "INSERT INTO task (user_id, assigned_user_id, description, is_done, date_added) VALUES (?, ?, ?, ?, ?)";
    public $sqlListAllUsers = "SELECT id, login FROM user";
    public $sqlDeleteTask = "DELETE FROM task WHERE user_id=? AND id=? LIMIT 1";
    public $sqlAllDelegated = "SELECT user_id as id, assigned_user_id, description, is_done, date_added 
                        FROM task as t INNER JOIN user as u ON u.id=t.assigned_user_id 
                            WHERE t.user_id = ? OR t.assigned_user_id = ?";
    public $sqlUpdateStatusTask = "UPDATE task SET is_done=? WHERE user_id=? AND id=? LIMIT 1";
    public $sqlCountTasks = "SELECT count(*) as sum FROM task as t WHERE t.user_id = ? OR t.assigned_user_id = ?";
    // здесь храним обьект pdo 
    public $pdo;

    // метод соеденения с базой 
    public function connectDataBase ($config) {
        $this->pdo = new PDO("mysql:host={$config->host};dbname={$config->dbname};charset=utf8", $config->login, $config->password);
        return $this->pdo;
    }

    public function getFormAction ($isRegistration) {
        $action = (empty($isRegistration)) ? "login" : "registration";
        return $action;
    }

    public function getMyLogin ($pdo) {
        $idUser = $this->getIdUser();
        $resMyLogin = $this->makerSqlQuery($pdo, $this->sqlLoginForId, ["$idUser"]);
        return $resMyLogin;
    }

    public function getAssignedUserList ($pdo) {
        $assignedUserList = $this->makerSqlQuery($pdo, $this->sqlListAllUsers);
        return $assignedUserList;
    }

    // методы для запросов
    public function makerSqlQuery ($pdo, $sql, $prePar=[""]) {
        // dumper("sql");
        // dumper($sql);
        // dumper("prePar");
        // dumper($prePar);
        try 
        {
            $sth = $pdo->prepare($sql);
            $rres = $sth->execute($prePar);
            if (!$rres) {
                echo "\nPDO::errorInfo():\n";
                dumper($sth->errorInfo());
            }
            // dumper("resexecute");
            // dumper($rres);
            $res = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        } catch (PDOException $e) {
            echo "Ошибка запроса: </br>";
            dumper($e);
        }
        
    }
    
    // метод авторизации 
    public function authorise ($loginAuth, $passAuth, $pdo) {
        $tmpLoginAuth = $loginAuth;
        $tempPassAuth = $passAuth;
        $resAuth = $this->makerSqlQuery($pdo, $this->sqlLogPassIssSet, ["$tmpLoginAuth", "$tempPassAuth"]);
        if($resAuth) {
            $_SESSION['login'] = $resAuth[0]['login'];
            $_SESSION['authStatus'] = 1;
            $_SESSION['user_id'] = $this->makerSqlQuery($pdo, $this->sqlIdForLogin, ["$tmpLoginAuth"])[0]['id'];
            return true;
        } else {
            echo "<li>Wrong password or login! Please edite fields again or <a href='/?registration=true'>register</a></li> </br> <a href='/'>try againt</a>";
        }
    }

    // метод регистрации 
    public function registration ($loginReg, $passReg, $pdo) {
        $result = $this->makerSqlQuery($pdo, $this->sqlLoginIsSet, ["$loginReg"]);
        if ($result) {
            echo "<li>Login already Set!</li> <li><a href='/?registration=true'>try againt</a></li>";

        } else {
            return $this->makerSqlQuery($pdo, $this->sqlAddUser, ["$loginReg", "$passReg"]);

        }
    }

    // метод для получения списка задач 
    public function showTasks ($pdo) {
        $idUser = $this->getIdUser();
        $resMyBussiness = $this->makerSqlQuery($pdo, $this->sqlMyBussiess, ["$idUser"]);
        return $resMyBussiness;
    }

    // метод для добавления новой задачи в базу 
    public function addTask ($newDescription, $pdo) {
        $idUser = $this->getIdUser();
        $tmpStatusTask = "false";
        $tmpDate = date("d.m.Y");
        $resNewTask = $this->makerSqlQuery($pdo, $this->sqlAddNewTask, ["$idUser", 
                                                            "$idUser", 
                                                            "$newDescription", 
                                                            "$tmpStatusTask", 
                                                            "$tmpDate"]);
    }

    // метод для делегирования задачи 
    public function deligateTask ($assigned_user_id, $task_id, $pdo) {
        $idUser = $this->getIdUser(); 
        $resDeligate = $this->makerSqlQuery($pdo, $this->sqlUpdateAsigned, ["$assigned_user_id", "$task_id", "$idUser"]);
    }

    // метод для удаления задачи 
    public function delTask ($idTaskDel, $pdo) {
            $idUser = $this->getIdUser();
            $this->makerSqlQuery($pdo, $this->sqlDeleteTask, ["$idUser", "$idTaskDel"]);
    }

    // метод для загрузки делегированный дел 
    public function showDeligated ($pdo) {
        $idUser = $this->getIdUser();
        $resMyBussines = $this->makerSqlQuery($pdo, $this->sqlAllDelegated, ["$idUser", "$idUser"]);
        return $resMyBussines;

    }

    public function changeStatusTask ($idForTurn, $statusTask, $pdo) {
        $idUser = $this->getIdUser();
        $tmpNewStatus = !$statusTask;
        $this->makerSqlQuery($pdo, $this->sqlUpdateStatusTask, ["$tmpNewStatus", "$idUser", "$idForTurn"]);

    }

    public function showSummTask ($pdo) {
        $idUser = $this->getIdUser();
        $resSummTasks = $this->makerSqlQuery($pdo, $this->sqlCountTasks, ["$idUser", "$idUser"])[0]['sum'];
        return $resSummTasks;
    }

    public function exitFromAcc () {
        session_destroy();
    }

    public function getIdUser () {
        if(isset($_SESSION['user_id'])) {
            $idUser = $_SESSION['user_id'];
            return $idUser;

        }
    }

}


?>