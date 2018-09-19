<?php 

$pdo = new PDO("mysql:host=localhost;dbname=netology;charset=utf8", "admin", "123456");

$name = !empty($_GET['name']) ? $_GET['name'] : '';
$author = !empty($_GET['author']) ? $_GET['author'] : '';
$isbn = !empty($_GET['isbn']) ? $_GET['isbn'] : '';

$sqlSearch = "select name, author, year, isbn, genre, id
                from books
                where name like ? and author like ? and isbn like ?";

$sth = $pdo->prepare($sqlSearch);
$sth->execute(["%$name%","%$author%", "%$isbn%"]);
$result = $sth->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<form method="GET">
    <input type="text" name="isbn" placeholder="ISBN" value="" />
    <input type="text" name="name" placeholder="Название книги" value="" />
    <input type="text" name="author" placeholder="Автор книги" value="" />
    <input type="submit" value="Поиск" />
</form>

    <table>
        <tr>
            <th>Номер</th>
            <th>Название книги</th>
            <th>Автор</th>
            <th>Год выпуска</th>
            <th>Жанр</th>
            <th>ISBN</th>
        </tr>
        <?php         
        foreach($result as $key => $value): ?>
        <tr>
            <td><?=$value['id']; ?></td>
            <td><?=$value['name']; ?></td>
            <td><?=$value['author']; ?></td>
            <td><?=$value['year']; ?></td>
            <td><?=$value['genre']; ?></td>
            <td><?=$value['isbn']; ?></td>
        </tr>
        <?php 
        endforeach;?>
    </table>
</body>
</html>

