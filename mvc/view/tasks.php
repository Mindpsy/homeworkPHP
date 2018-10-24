<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/styles/styles.css">
</head>
<body>
<h3>Добро пожаловать <?=$resMyLogin[0]['login']; ?></h3>
    <form action="" method="get" class="control-buttons">
        <input name="controller" value="accaunt" type="hidden"/>
        <input name="action" value="showCountTasks" type="hidden"/>
        <button type="submit" class="btn btn-primary" name="myBussinesBtn" value="true">Показать мои задачи</button>
    </form>
    <form action="" method="get" class="control-buttons">
        <input name="controller" value="accaunt" type="hidden"/>
        <input name="action" value="showDeligatedTasks" type="hidden"/>
        <button type="submit" class="btn btn-info" name="showDelegatedBtn" value="true">Показать делегированные</button>
    </form>
    <form action="" method="get" class="control-buttons">
        <input name="controller" value="accaunt" type="hidden"/>
        <input name="action" value="showSummTask" type="hidden"/>
        <button type="submit" class="btn btn-info" name="showCountBtn" value="true">Показать количество дел</button>
    </form>    
    <form action="" method="get" class="control-buttons">
        <input name="controller" value="accaunt" type="hidden"/>
        <input name="action" value="exitAcc" type="hidden"/>
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
                $tmpDirect = $value['is_done'] ? "<a href='?idForTurn={$tmpIdtas}&statusTask={$tmpNowStatus}&controller=accaunt&action=changeStatus'>Выполнено</a>" : "<a href='?idForTurn={$tmpIdtas}&statusTask={$tmpNowStatus}&controller=accaunt&action=changeStatus'>Не ыполнено</a>";
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
                            <input name="controller" value="accaunt" type="hidden"/>
                            <input name="action" value="toDeligateTask" type="hidden"/>
                            <button type="submit" name="toDeligateBtn" value="true">Делегировать</button>
                        </form>
                    </td>
                    <td>
                        <form action="" method="get">
                            <input name="controller" value="accaunt" type="hidden"/>
                            <input name="action" value="deleteTask" type="hidden"/>
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
                <?=$resSummTasks; ?>
            </div>
        </div> 
    <?php endif; ?>
    <form action="" method="GET">
        <input name="controller" value="accaunt" type="hidden"/>
        <input name="action" value="addNewTask" type="hidden"/>
        <input type="text" name="newDescription" placeholder="Введите описание задачи">
        <button type="submit" class="btn btn-success" name="addTaskBtn">Добавить задачу!</button>
    </form>
</body>
</html>