<?php 
// Подключаем полезную функцию dumper() 
require_once "dumper.php";
ini_set('error_reporting', E_ALL);

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
    private $pdo;

    // метод соеденения с базой 
    public function connectDataBase ($config) {
        $this->pdo = new PDO("mysql:host={$config->host};dbname={$config->dbname};charset=utf8", $config->login, $config->password);
        return $this->pdo;
    }
    // метды для получения параметров верстки в зависимости от того аутентификайия это или регистрация 
    public function getLoginOlaceholder () {
        $loginOlaceholder = (empty($_GET['registration'])) ? "Введите логин" : "Придумайе логин";
        return $loginOlaceholder;
    }

    public function getPasswordplaceholder () {
        $passwordplaceholder = (empty($_GET['registration'])) ? "Введите пароль" : "Придумайе пароль";
        return $passwordplaceholder;
    }

    public function getLoginName () {
        $loginName = (empty($_GET['registration'])) ? "loginAuth" : "loginReg";
        return $loginName;
    }
    
    public function getPassName () {
        $passName = (empty($_GET['registration'])) ? "passAuth" : "passReg";
        return $passName;
    }

    public function getTitleH2 () {
        $titleH2 = (empty($_GET['registration'])) ? "Авторизация" : "Регистрация";
        return $titleH2;
    }
    
    public function getTextButtonSubmit () {
        $textButtonSubmit = (empty($_GET['registration'])) ? "Войти" : "Зарегистрироваться";
        return $textButtonSubmit;
    }
    
    public function getNameButtonSubmit () {
        $nameButtonSubmit = (empty($_GET['registration'])) ? "authoriseSubmit" : "regSubmit";
        return $nameButtonSubmit;
    }

    public function getFormAction () {
        $action = (empty($_GET['registration'])) ? "login" : "registration";
        return $action;
    }

    public function getMyLogin () {
        $idUser = $this->getIdUser();
        $resMyLogin = $this->makerSqlQuery($this->sqlLoginForId, ["$idUser"]);
        return $resMyLogin;
    }

    public function getAssignedUserList () {
        $assignedUserList = $this->makerSqlQuery($this->sqlListAllUsers);
        return $assignedUserList;
    }

    // методы для запросов
    public function makerSqlQuery ($sql, $prePar=[""]) {
        // dumper("sql");
        // dumper($sql);
        // dumper("prePar");
        // dumper($prePar);
        try 
        {
            $sth = $this->pdo->prepare($sql);
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
    public function authorise () {
        if (isset($_GET['authoriseSubmit'])) {
            if (!empty($_GET['loginAuth']) && !empty($_GET['passAuth'])) {
                $tmpLoginAuth = $_GET['loginAuth'];
                $tempPassAuth = $_GET['passAuth'];
                $resAuth = $this->makerSqlQuery($this->sqlLogPassIssSet, ["$tmpLoginAuth", "$tempPassAuth"]);
                if($resAuth) {
                    $_SESSION['login'] = $resAuth[0]['login'];
                    $_SESSION['authStatus'] = 1;
                    $_SESSION['user_id'] = $this->makerSqlQuery($this->sqlIdForLogin, ["$tmpLoginAuth"])[0]['id'];
                }
            }
    
        }
    }
    // метод регистрации 
    public function registration () {
        if(isset($_GET['regSubmit'])) {
            if(!empty($_GET['loginReg']) && !empty($_GET['passReg'])) {
                $tmpLoginReg = $_GET['loginReg'];
                $result = $this->makerSqlQuery($this->sqlLoginIsSet, ["$tmpLoginReg"]);
                if ($result) {
                    echo "<li>Login already Set!</li> <li><a href='/?registration=true'>try againt</a></li>";

                } else {
                    $tmpLoginReg = $_GET['loginReg'];
                    $tempPassReg = $_GET['passReg'];
                    $regResult = $this->makerSqlQuery($this->sqlAddUser, ["$tmpLoginReg", "$tempPassReg"]);        
                }
            } else {
                echo "<li>Please edite fields</li> </br> <a href='/?registration=true'>try againt</a>";
            }
        
        }

    }
    // метод для получения списка задач 
    public function showTasks () {
        $idUser = $this->getIdUser();
        $resMyBussiness = $this->makerSqlQuery($this->sqlMyBussiess, ["$idUser"]);
        return $resMyBussiness;
    }
    // метод для добавления новой задачи в базу 
    public function addTask () {
        if (isset($_GET['addTaskBtn'])) {
            if(isset($_GET['newDescription'])) {
                $idUser = $this->getIdUser();
                $tmpDescr = $_GET['newDescription'];
                $tmpStatusTask = "false";
                $tmpDate = date("d.m.Y");
                $resNewTask = $this->makerSqlQuery($this->sqlAddNewTask, ["$idUser", 
                                                                    "$idUser", 
                                                                    "$tmpDescr", 
                                                                    "$tmpStatusTask", 
                                                                    "$tmpDate"]);
            } else {
                echo "<li>To Write the decscription task</li>";
            }
        }
    }
    // метод для делегирования задачи 
    public function deligateTask () {
        if (isset($_GET['toDeligateBtn'])) {
            $idUser = $this->getIdUser(); 
            $tmpAssignUserId = $_GET['assigned_user_id'];
            $tmpTaskId = $_GET['task_id'];
            $resDeligate = $this->makerSqlQuery($this->sqlUpdateAsigned, ["$tmpAssignUserId", "$tmpTaskId", "$idUser"]);
        }
    }
    // метод для удаления задачи 
    public function delTask () {
        if (isset($_GET['toDelBtn']) && isset($_GET['idTaskDel'])) {
            $idUser = $this->getIdUser();
            $tmpIdTaskDel = $_GET['idTaskDel'];
            $this->makerSqlQuery($this->sqlDeleteTask, ["$idUser", "$tmpIdTaskDel"]);
        }
    }
    // метод для загрузки делегированный дел 
    public function showDeligated () {
        if(isset($_GET['showDelegatedBtn'])) {
            $idUser = $this->getIdUser();
            $resMyBussines = $this->makerSqlQuery($this->sqlAllDelegated, ["$idUser", "$idUser"]);
            return $resMyBussines;
        }
    }

    public function changeStatusTask () {
        if (isset($_GET['idForTurn']) && isset($_GET['statusTask'])) {
            $idUser = $this->getIdUser();
            $tmpIdForDone = $_GET['idForTurn'];
            $tmpNewStatus = !$_GET['statusTask'];
            $this->makerSqlQuery($this->sqlUpdateStatusTask, ["$tmpNewStatus", "$idUser", "$tmpIdForDone"]);
        }
    }

    public function showSummTask () {
        $idUser = $this->getIdUser();
        $resSummTasks = $this->makerSqlQuery($this->sqlCountTasks, ["$idUser", "$idUser"])[0]['sum'];
        return $resSummTasks;
    }

    public function exitFromAcc () {
        if(isset($_GET['exitBtn'])) {
            session_destroy();
        }
    }

    public function getIdUser () {
        if(isset($_SESSION['user_id'])) {
            $idUser = $_SESSION['user_id'];
            return $idUser;
        }
    }

}


?>