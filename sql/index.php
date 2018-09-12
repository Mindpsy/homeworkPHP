<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
    table { 
        border-spacing: 0;
        border-collapse: collapse;
    }

    table td, table th {
        border: 1px solid #ccc;
        padding: 5px;
    }
    
    table th {
        background: #eee;
    }
</style>
</head>
<body>
<!--
<form method="GET">
    <input type="text" name="isbn" placeholder="ISBN" value="" />
    <input type="text" name="name" placeholder="Название книги" value="" />
    <input type="text" name="author" placeholder="Автор книги" value="" />
    <input type="submit" value="Поиск" />
</form>
-->
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
        $pdo = new PDO("mysql:host=localhost;dbname=netology", "admin", "123456");
        $sql = "select * from books";
        $sth = $pdo->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
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

