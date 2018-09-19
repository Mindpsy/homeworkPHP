<?php 
session_start();

if(empty($_SESSION['adminStatus'])) {
    header("HTTP/1.0 404 Not Found");
    die ("You must be authorised before using this page!");
}

if(!empty($_FILES)) {
    if(array_key_exists("test", $_FILES)) {
        $name = $_FILES['test']['name'];
        $dest = "./tests/$name";
        $tmpName = $_FILES['test']['tmp_name'];
        if(move_uploaded_file($_FILES['test']['tmp_name'], $dest)){
            header("Location: /list.php");
            echo "Тест успешно загружен</br>";
        }
    }    
}
?>
<!DOCTYPE>
<html>
    <head>
        <title>Форма для загрузки тестов</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    
    </head>
    <body>
        <form enctype="multipart/form-data" action="./admin.php" method="post" class="form-group">
            <input name="test" type="file" class="form-control">
            <input type="submit" value="Добавить тест" class="form-control">
        </form>

    </body>
</html>