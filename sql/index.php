<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table>
        <tr>
            <td>id</td>
            <td>name</td>
            <td>author</td>
            <td>year</td>
            <td>isbn</td>
            <td>genre</td>
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
            <td><?=$value['isbn']; ?></td>
            <td><?=$value['genre']; ?></td>
        </tr>
        <?php 
        endforeach;?>
    </table>
</body>
</html>

