<?php
$name = 'Виктор';
$age = 25;
$email = 'kalashnikov.marketing@gmail.com';
$city = 'Белгород';
$about = 'FULL стэк разработчик';
?>
<!DOCTYPE>
<html lang="ru">
    <head>
        <title><?= $name . ' – ' . $about ?></title>
        <meta charset="utf-8">
        <style>
            body {
                font-family: sans-serif;  
            }
        </style>
    </head>
    <body>
        <h1>Страница пользователя <?= $name ?></h1>
        <dl>
            <dt>Имя</dt>
            <dd><?= $name ?></dd>
            <dt>Возраст</dt>
            <dd><?= $age ?></dd>
            <dt>Адрес электронной почты</dt>
            <dd><a href="mailto:<?= $email ?>"><?= $email ?></a></dd>
            <dt>Город</dt>
            <dd><?= $city ?></dd>
            <dt>О себе</dt>
            <dd><?= $about ?></dd>
        </dl>
        <hr>
        <p>Дополнительное задание</p>

        <p>Число пользователя: <?php echo $_GET['x'];?> </p>
        <p>
            <?php 
            //доп задание 
            
            
            if(isset($_GET['x'])) {
                $userData = $_GET['x'];
                $number1 = 1;
                $number2 = 1;
                $value3;

                while ($number1 > $userData) {
                    if ($number1 < $userData) {
                        echo "<p>Задуманное число НЕ входит в часловой ряд</p>";
                        die;
                    } elseif ($number1 == $userData) {
                        echo "Задуманное число входит в числовой ряд";
                        die;
                    } else {
                        $value3 = $number1;
                        $number1 += $number2;
                        $number2 = $value3;
                    }
                }
            }   
            ?>
        </p>
    </body>
</html>