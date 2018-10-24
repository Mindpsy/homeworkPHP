<?php
require_once "model/model.php";

class Controller {
    public $pdo;

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

    public function authorise () {
        if (isset($_GET['authoriseSubmit'])) {
            if (!empty($_GET['loginAuth']) && !empty($_GET['passAuth'])) {
                $model = new Model();
                $resAuth = $model->authorise($_GET['loginAuth'], $_GET['passAuth'], $this->pdo);
                if($resAuth) {
                    header("location: ?controller=accaunt&action=showCountTasks");
                }
            } else {
                echo "<li>Please edite fields</li> </br> <a href='/'>try againt</a>";
            }
        }
    }

    public function showTasks () {
        $model = new Model();
        $resMyLogin = $model->getMyLogin($this->pdo);
        $resMyBussines = $model->showTasks($this->pdo);
        $assignedUserList = $model->getAssignedUserList($this->pdo);
        require_once "view/tasks.php";

    }

    public function exitAcc () {
        if(isset($_GET['exitBtn'])) {
            $model = new Model();
            $model->exitFromAcc();
            header("location: ?controller=form&action=auth");
        }
    }
    
    public function showDeligated () {
        if(isset($_GET['showDelegatedBtn'])) {
            $model = new Model();
            $resMyLogin = $model->getMyLogin($this->pdo);
            $resMyBussines = $model->showDeligated($this->pdo);
            $assignedUserList = $model->getAssignedUserList($this->pdo);
            require_once "/view/tasks.php";

        }
    }

    
    
    public function addNewTask () {
        if (isset($_GET['addTaskBtn'])) {
            if(isset($_GET['newDescription'])) {
                $model = new Model();
                $model->addTask($_GET['newDescription'], $this->pdo);
                header("location: /");

            }
        } else {
            echo "<li>To Write the decscription task</li>";
        }
    }

    public function showSummTasks () {
        $model = new Model();
        $resMyLogin = $model->getMyLogin($this->pdo);
        $resSummTasks = $model->showSummTask($this->pdo);
        require_once "/view/tasks.php";

    }

    public function deleteTask () {
        if (isset($_GET['toDelBtn']) && isset($_GET['idTaskDel'])) {
            $model = new Model();
            $model->delTask($_GET['idTaskDel'], $this->pdo);
            header("location: /");
        }
    }

    public function toDeligateTask () {
        if (isset($_GET['toDeligateBtn'])) {
            $model = new Model();
            $model->deligateTask($_GET['assigned_user_id'], $_GET['task_id'], $this->pdo);
            header("location: /");
        }

    }
    
    public function changeStatusTask () {
        if (isset($_GET['idForTurn']) && isset($_GET['statusTask'])) {
            $model = new Model();
            $model->changeStatusTask($_GET['idForTurn'], $_GET['statusTask'], $this->pdo);
            header("location: /");
        }

    }

    public function showAuthForm () {
        $model = new Model();
        $titleH2 = $this->getTitleH2();
        $FormAction =$this->getFormAction();
        $LoginName = $this->getLoginName();
        $LoginOlaceholder = $this->getLoginOlaceholder();
        $PassName = $this->getPassName();
        $Passwordplaceholder = $this->getPasswordplaceholder();
        $NameButtonSubmit = $this->getNameButtonSubmit();
        $TextButtonSubmit = $this->getTextButtonSubmit();
        require_once "/view/signin.php";

    }

    public function registration () {
        if(isset($_GET['regSubmit'])) {
            if(!empty($_GET['loginReg']) && !empty($_GET['passReg'])) {
                $model = new Model();
                $model->registration($_GET['loginReg'], $_GET['passReg'], $this->pdo);
                header("location: ?controller=form&action=auth");
                echo "<li>Registration complite!</li>";

            } else {
                echo "<li>Please edite fields</li> </br> <a href='/?registration=true'>try againt</a>";
            }
        
        }

    }

    public function connectDataBase ($config) {
        $model = new Model();
        $this->pdo = $model->connectDataBase($config);
        return $this->pdo;
    }

    public function getMyLogin () {
        $model = new Model();
        $resMyLogin = $model->getMyLogin($this->pdo);
        return $resMyLogin;

    }
}

?>