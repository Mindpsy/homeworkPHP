<?php 
session_start();
if ($_SESSION['adminStatus']) {
    header('location: list.php');
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <title>Авторизация пользователя</title>
</head>
<body>
<h1><a href="/">Авторизуйтесь</a> или зайдите как <a href="/?guest=true">Гость</a></h1>
    
    <?php
    if(!isset($_GET['guest'])): ?>

    <form action="list.php" method="post">
        <input type="text" name="nameUser" class="form-control">
        <input type="password" name="pass" class="form-control">
        <input type="submit" value="войти" class="btn btn-default btn-xs">
    </form>

    <?php else: ?>

    <form action="/list.php" method="post">
        <input type="text" name="nameGuest" class="form-control">
        <input type="submit" name="enterGuest" value="Ждите гостей!" class="btn btn-default btn-xs">
    </form>

    <?php endif;
    ?>
</body>
</html>
