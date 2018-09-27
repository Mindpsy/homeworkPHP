<?php
session_start();
require_once "functions.php";

// определяем что хочет сделать пользователь зарегаться или войти, одну форму для двух целей 
$loginOlaceholder = (empty($_GET['registration'])) ? "Введите логин" : "Придумайе логин";
$passwordplaceholder = (empty($_GET['registration'])) ? "Введите пароль" : "Придумайе пароль";
$loginName = (empty($_GET['registration'])) ? "loginAuth" : "loginReg";
$passName = (empty($_GET['registration'])) ? "passAuth" : "passReg";
$titleH2 = (empty($_GET['registration'])) ? "Авторизация" : "Регистрация";
$textButtonSubmit = (empty($_GET['registration'])) ? "Войти" : "Зарегистрироваться";
$nameButtonSubmit = (empty($_GET['registration'])) ? "authoriseSubmit" : "regSubmit";

// готовим шаблоны запросов для операций с базой 
$sqlLoginIsSet = "SELECT id FROM user WHERE login= ?";
$sqlAddUser = "INSERT INTO user( login, password) VALUES ( ?, ?)";
$sqlLogPassIssSet = "SELECT login FROM user WHERE login=? AND password=?";
$sqlIdForLogin = "SELECT id FROM user WHERE login=?";


// коннектимся к базе 
$pdo = new PDO("mysql:host=localhost;dbname=todoAplpication;charset=utf8", "admin", "123456");

// если отправили форму регистрации проверяем все ли заполнено, 
// если все ок, проверяем есть ли в базе логин, если нету то регаем, если есть возвращаем инфу 
if(isset($_GET['regSubmit'])) {
    echo "</br>нажата regSubmit";
    if(isset($_GET['loginReg']) && isset($_GET['passReg'])) {
        echo "</br>введены loginReg и passReg";
        $tmpLoginReg = $_GET['loginReg'];
        $result = makerSqlQuery($pdo, $sqlLoginIsSet, ["$tmpLoginReg"]);
        if ($result) {
            // -- 
            echo "</br>Такой логин уже существует! Выберите другой.</br>";
            // --
            echo dumper($result);
        } else {
            echo "</br>Такого логина нет Еее!";
            $tmpLoginReg = $_GET['loginReg'];
            $tempPassReg = $_GET['passReg'];
            $regResult = makerSqlQuery($pdo, $sqlAddUser, ["$tmpLoginReg", "$tempPassReg"]);
            echo "</br>Кажется регистрация прошла";
            echo dumper($regResult);

        }
    } else {
        echo "<li>заполните поля логина и пароля</li>";
    }

}

// проверяем отправлена ли форма, если да то проверяем заполненны ли поля
// если да то проверяем совпадают ли с базой, если совпадает то входим и сохраняем сессию
// отправляем на странцу со списком дел 
if (isset($_GET['authoriseSubmit'])) {
    if (isset($_GET['loginAuth']) && isset($_GET['passAuth'])) {
        $tmpLoginAuth = $_GET['loginAuth'];
        $tempPassAuth = $_GET['passAuth'];
        $resAuth = makerSqlQuery($pdo, $sqlLogPassIssSet, ["$tmpLoginAuth", "$tempPassAuth"]);
        if($resAuth) {
            header("location: /workSpace.php");
            $_SESSION['login'] = $resAuth[0]['login'];
            $_SESSION['authStatus'] = 1;
            $_SESSION['user_id'] = makerSqlQuery($pdo, $sqlIdForLogin, ["$tmpLoginAuth"])[0]['id'];
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <title>Document</title>
</head>
<body>
    <h1><a href="/">Войдите</a> или <a href="/?registration=true">зарегистрируйтесь</a> в приложении ToDo</h1>
    <h2><?=$titleH2;?><h2>
        <div class="">
            <form role="form">
            <div class="form-group">
                <label for="exampleInputLogin">Логин</label>
                <input type="text" name="<?=$loginName;?>" class="form-control" id="exampleInputLogin" placeholder="<?=$loginOlaceholder;?>">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Пароль</label>
                <input type="password" name="<?=$passName;?>" class="form-control" id="exampleInputPassword1" placeholder="<?=$passwordplaceholder;?>"">
            </div>
            <button type="submit" name="<?=$nameButtonSubmit;?>" class="btn btn-default"><?=$textButtonSubmit;?></button>
            </form>
        </div>
    </body>
</html>