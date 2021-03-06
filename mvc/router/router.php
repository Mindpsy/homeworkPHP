<?php
session_start();
require_once 'controller/controller.php';
$config = new Config('localhost', 'todoAplpication', 'root', '');
$controllerMod = new Controller();
$controllerMod->connectDataBase($config);
$commonActions = ['showCountTasks', 'exitAcc', 'showDeligatedTasks', 'addNewTask', 
                                                                    'showSummTask', 
                                                                    'deleteTask', 
                                                                    'toDeligateTask', 
                                                                    'changeStatus', 
                                                                    'auth', 
                                                                    'login', 
                                                                    'reg', 
                                                                    'registration'];






// если сессия жива 
if(isset($_SESSION['authStatus'])) {
    if (!isset($_GET['controller']) && !isset($_GET['action'])) {
        $controller = 'accaunt';
        $action = 'showCountTasks';
        
    } else if (($_GET['controller'] === 'base') && ($_GET['action'] === 'login')) {
        $controller = 'accaunt';
        $action = 'showCountTasks';

    } else if (($_GET['controller'] === 'accaunt') && in_arrAY($_GET['action'], $commonActions)) {
        $controller = $_GET['controller'];
        $action = $_GET['action'];
    }

    if ($controller === 'accaunt') {
        $resMyLogin = $controllerMod->getMyLogin();
        
        if ($action === 'showCountTasks') {
            $controllerMod->showTasks();

        } else if ($action === 'showDeligatedTasks') {
            $controllerMod->showDeligated();

        } else if ($action === 'addNewTask') {
            $controllerMod->addNewTask();

        } else if ($action === 'showSummTask') {
            $controllerMod->showSummTasks();

        } else if ($action === 'deleteTask') {
            $controllerMod->deleteTask();
            
        }  else if ($action === 'toDeligateTask') {
            $controllerMod->toDeligateTask();

        }  else if ($action === 'changeStatus') {
            $controllerMod->changeStatusTask();

        } else if ($action === 'exitAcc') {
            $controllerMod->exitAcc();

        }
    
    } 


    // если сессии нет
} else {
    if (!isset($_GET['controller']) && !isset($_GET['action'])) {
        $controller = 'form';
        $action = 'auth';

    } else if (($_GET['controller'] === 'form') && in_arrAY($_GET['action'], $commonActions)) {
        $controller = $_GET['controller'];
        $action = $_GET['action'];
    
    } else if (($_GET['controller'] === 'base') && in_arrAY($_GET['action'], $commonActions)) {
        $controller = $_GET['controller'];
        $action = $_GET['action'];
    
    } else {
        $controller = 'form';
        $action = 'auth';
    }


    if($controller === 'form') {
        if (($action === 'auth') || ($action === 'reg')) {
            $controllerMod->showAuthForm();
        } 

    } else if ($controller === 'base') {
        if ($action === 'login') {
            $controllerMod->authorise();

        } else if ($action === 'registration') {
            $controllerMod->registration();
        }
        
    } else if ($controller === 'accaunt') {
        if ($action === 'exitAcc') {
            $controllerMod->render ('/view/signin.php');
        }
    }


}



?>