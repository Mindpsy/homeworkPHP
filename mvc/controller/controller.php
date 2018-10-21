<?php
session_start();
require_once "/model/model.php";

$config = new Config("localhost", "todoAplpication", "root", "");
$model = new Model();
$model->connectDataBase($config);

// если сессия жива 
if(isset($_SESSION['authStatus'])) {
    if (!isset($_GET['controller']) && !isset($_GET['action'])) {
        $controller = "accaunt";
        $action = "showCountTasks";
        
    } else if (($_GET['controller'] === "base") && ($_GET['action'] === "login")) {
        $controller = "accaunt";
        $action = "showCountTasks";

    } else if (($_GET['controller'] === "accaunt") && ($_GET['action'] === "showCountTasks")) {
        $controller = $_GET['controller'];
        $action = $_GET['action'];

    } else if (($_GET['controller'] === "accaunt") && ($_GET['action'] === "exitAcc")) {
        $controller = $_GET['controller'];
        $action = $_GET['action'];

    } else if (($_GET['controller'] === "accaunt") && ($_GET['action'] === "showDeligatedTasks")) {
        $controller = $_GET['controller'];
        $action = $_GET['action'];

    } else if (($_GET['controller'] === "accaunt") && ($_GET['action'] === "addNewTask")) {
        $controller = $_GET['controller'];
        $action = $_GET['action'];

    } else if (($_GET['controller'] === "accaunt") && ($_GET['action'] === "showSummTask")) {
        $controller = $_GET['controller'];
        $action = $_GET['action'];

    } else if (($_GET['controller'] === "accaunt") && ($_GET['action'] === "deleteTask")) {
        $controller = $_GET['controller'];
        $action = $_GET['action'];

    } else if (($_GET['controller'] === "accaunt") && ($_GET['action'] === "toDeligateTask")) {
        $controller = $_GET['controller'];
        $action = $_GET['action'];

    } else if (($_GET['controller'] === "accaunt") && ($_GET['action'] === "changeStatus")) {
        $controller = $_GET['controller'];
        $action = $_GET['action'];

    }

    if ($controller === "accaunt") {
        $resMyLogin = $model->getMyLogin();
        $assignedUserList = $model->getAssignedUserList();
        

        if ($action === "showCountTasks") {
            $resMyBussines = $model->showTasks();
            require_once "/view/tasks.php";

        } else if ($action === "showDeligatedTasks") {
            $assignedUserList = $model->getAssignedUserList();
            $resMyBussines = $model->showDeligated();
            require_once "/view/tasks.php";

        } else if ($action === "addNewTask") {
            $model->addTask();
            header("location: /");

        } else if ($action === "showSummTask") {
            $resSummTasks = $model->showSummTask();
            require_once "/view/tasks.php";

        } else if ($action === "deleteTask") {
            $model->delTask();
            header("location: /");

        }  else if ($action === "toDeligateTask") {
            $assignedUserList = $model->getAssignedUserList();
            $model->deligateTask();
            header("location: /");

        }  else if ($action === "changeStatus") {
            $model->changeStatusTask();
            header("location: /");

        } else if ($action === "exitAcc") {
            $model->exitFromAcc();
            header("location: ?controller=form&action=auth");

        }
    
    } 


    // если сессии нет
} else {
    if (!isset($_GET['controller']) && !isset($_GET['action'])) {
        $controller = "form";
        $action = "auth";

    } else if (($_GET['controller'] === "form") && ($_GET['action'] === "auth")) {
        $controller = $_GET['controller'];
        $action = $_GET['action'];
    
    } else if (($_GET['controller'] === "base") && ($_GET['action'] === "login")) {
        $controller = $_GET['controller'];
        $action = $_GET['action'];
    
    } else if (($_GET['controller'] === "form") && ($_GET['action'] === "reg")) {
        $controller = $_GET['controller'];
        $action = $_GET['action'];
    
    } else if (($_GET['controller'] === "base") && ($_GET['action'] === "registration")) {
        $controller = $_GET['controller'];
        $action = $_GET['action'];
    
    }

    if($controller === "form") {
        if (($action === "auth") || ($action === "reg")) {
            require_once "/view/signin.php";
    
        } 
    } else if ($controller === "base") {
        if ($action === "login") {
            $model->authorise();
            $resMyLogin = $model->getMyLogin();
            header("location: ?controller=accaunt&action=showCountTasks");

        } else if ($action === "registration") {
            $model->registration();
            header("location: ?controller=form&action=auth");
            echo "<li>Registration complite!</li>";

    
        }
        
    } else if ($controller === "accaunt") {
        if ($action === "exitAcc") {
            require_once "/view/signin.php";

        }
    }


}
?>