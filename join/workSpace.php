<?php
session_start();
require_once "functions.php";
require_once "dumper.php";

$pdo = new PDO("mysql:host=localhost;dbname=todoAplpication;charset=utf8", "admin", "123456");

$idUser = $_SESSION['user_id'];

$sqlLoginIsSet = "SELECT id FROM user WHERE login= ?";
$sqlAddUser = "INSERT INTO user( login, password) VALUES ( ?, ?)";
$sqlLogPassIssSet = "SELECT login FROM user WHERE login=? AND password=?";
$sqlUpdateAsigned = "UPDATE task SET assigned_user_id=? WHERE id=? AND user_id=?";
$sqlMyBussiess = "SELECT id, user_id, assigned_user_id, description, is_done, date_added FROM task WHERE user_id=? ORDER BY date_added";
$sqlLoginForId = "SELECT id, login FROM user WHERE id=?"; 
$sqlAddNewTask = "INSERT INTO task (user_id, assigned_user_id, description, is_done, date_added) VALUES (?, ?, ?, ?, ?)";
$sqlListAllUsers = "SELECT id, login FROM user";
$sqlDeleteTask = "DELETE FROM task WHERE user_id=? AND id=? LIMIT 1";
$sqlAllDelegated = "SELECT user_id as id, assigned_user_id, description, is_done, date_added 
                        FROM task as t INNER JOIN user as u ON u.id=t.assigned_user_id 
                            WHERE t.user_id = ? OR t.assigned_user_id = ?";
$sqlUpdateStatusTask = "UPDATE task SET is_done=? WHERE user_id=? AND id=? LIMIT 1";
$sqlCountTasks = "SELECT count(*) as sum FROM task as t WHERE t.user_id = ? OR t.assigned_user_id = ?";

$resMyLogin = makerSqlQuery($pdo, $sqlLoginForId, ["$idUser"]);
$assignedUserList = makerSqlQuery($pdo, $sqlListAllUsers);


if (!$_SESSION['authStatus']) {
    die ("<a href='/'>To enter in app</a>");
} elseif(!isset($_GET['showDelegatedBtn'])) {
    $resMyBussines = makerSqlQuery($pdo, $sqlMyBussiess, ["$idUser"]);
} elseif(isset($_GET['showDelegatedBtn'])) {
    $resMyBussines = makerSqlQuery($pdo, $sqlAllDelegated, ["$idUser", "$idUser"]);
}

if (isset($_GET['addTaskBtn'])) {
    if(isset($_GET['newDescription'])) {
        $tmpDescr = $_GET['newDescription'];
        $tmpStatusTask = "false";
        $tmpDate = date("d.m.Y");
        $resNewTask = makerSqlQuery($pdo, $sqlAddNewTask, ["$idUser", 
                                                            "$idUser", 
                                                            "$tmpDescr", 
                                                            "$tmpStatusTask", 
                                                            "$tmpDate"]);
    } else {
        echo "To Write the decscription task";
    }
}

if (isset($_GET['toDeligateBtn'])) {
    $tmpAssignUserId = $_GET['assigned_user_id'];
    $tmpTaskId = $_GET['task_id'];
    $resDeligate = makerSqlQuery($pdo, $sqlUpdateAsigned, ["$tmpAssignUserId", "$tmpTaskId", "$idUser"]);
}

if (isset($_GET['toDelBtn'])) {
    $tmpIdTaskDel = $_GET['idTaskDel'];
    makerSqlQuery($pdo, $sqlDeleteTask, ["$idUser", "$tmpIdTaskDel"]);
}

if (isset($_GET['idForTurn']) && isset($_GET['statusTask'])) {
    $tmpIdForDone = $_GET['idForTurn'];
    $tmpNewStatus = !$_GET['statusTask'];
    makerSqlQuery($pdo, $sqlUpdateStatusTask, ["$tmpNewStatus", "$idUser", "$tmpIdForDone"]);
}

if(isset($_GET['exitBtn'])) {
    session_destroy();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
</head>
<body>
<h3>Добро пожаловать <?=$resMyLogin[0]['login']; ?></h3>
    <form action="" method="get">
        <button type="submit" class="btn btn-primary" name="myBussinesBtn" value="true">Показать мои задачи</button>
        <button type="submit" class="btn btn-info" name="showDelegatedBtn" value="true">Показать делегированные</button>
        <button type="submit" class="btn btn-info" name="showCountBtn" value="true">Показать количество дел</button>
        <button type="submit" class="btn btn-warning" name="exitBtn" value="true">Выйти</button>
    </form>
    <?php if (!isset($_GET['showCountBtn'])): ?>
    <table class="table table-striped table-hover">
        <tr>
            <td>Дела</td>
            <td>Когда</td>
            <td>Выполнено/Невыполнено</td>
            <td>Исполнитель</td>
            <td></td>
        </tr>
        <?php
            foreach($resMyBussines as $key => $value):
                $tmpIdtas = $value['id'];
                $tmpNowStatus = $value['is_done'];
                $tmpDirect = $value['is_done'] ? "<a href='/workSpace.php?idForTurn={$tmpIdtas}&statusTask={$tmpNowStatus}'>Выполнено</a>" : "<a href='/workSpace.php?idForTurn={$tmpIdtas}&statusTask={$tmpNowStatus}'>Не ыполнено</a>";
            ?>
                <tr>
                    <td><?=$value['description']; ?></td>
                    <td><?=$value['date_added']; ?></td>
                    <td><?=$tmpDirect ;?></td>
                    <td>
                        <form action="" method="GET">
                            <input name="task_id" type="hidden" value="<?=$value['id']; ?>"> 
                            <select name="assigned_user_id">
                            <?php foreach ($assignedUserList as $assignedUser): ?>
                                <option <?php if ($value['assigned_user_id'] == $assignedUser['id']):?>
                                    selected<?php endif; ?> value="<?=$assignedUser['id']; ?>">
                                    <?= $assignedUser['login'] ?>
                                </option>
                            <?php endforeach; ?>
                            </select>
                            <button type="submit" name="toDeligateBtn">Делегировать</button>
                        </form>
                    </td>
                    <td>
                        <form action="" method="get">
                            <input type="hidden" name="idTaskDel" value="<?=$value['id']; ?>">
                            <button type="submit" name="toDelBtn" class="btn btn-danger" value="true">Удалить</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
    </table>
    <?php elseif (isset($_GET['showCountBtn'])): ?>
        <div>
            <div>
                Всего задач:
            </div>
            <div>
                <?=makerSqlQuery($pdo, $sqlCountTasks, ["$idUser", "$idUser"])[0]['sum']; ?>
            </div>
        </div> 
    <?php endif; ?>
    <form action="" method="GET">
        <input type="text" name="newDescription" placeholder="Введите описание задачи">
        <button type="submit" class="btn btn-success" name="addTaskBtn">Добавить задачу!</button>
    </form>
</body>
</html>