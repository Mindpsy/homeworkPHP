<!DOCTYPE>
<html>
    <head>
        <title>Форма для загрузки тестов</title>
        <meta charset="UTF-8">
    </head>
    <body>
        <form enctype="multipart/form-data" action="./admin.php" method="post">
            <input name="test" type="file"/>
            <input type="submit">
        </form>

    </body>
</html>

<?php
if(!empty($_FILES)) {
    if(array_key_exists("test", $_FILES)) {
        $name = $_FILES['test']['name'];
        $dest = "./tests/$name";
        $tmpName = $_FILES['test']['tmp_name'];
        /*$regExpJson = '/\.json$/';
        if(preg_match($regExpJson, $tmpName)[0] == ".json") {*/
            if(move_uploaded_file($_FILES['test']['tmp_name'], $dest)){
                echo "Тест успешно загружен</br>";
                echo $_FILES['test']['tmp_name'];
                writeTest($name, $dest);
                echo "Тест успешно внесен в список</br> ";
                header("Location: /list.php");
            }
        /* } else {
        echo "прикрепите файл json формата";
        }*/
    }    
}

function writeTest ($nameTest, $destTest) {
    $handle = fopen("./tests/list.csv", "ab");
    $row = [$nameTest, $destTest];
    fputcsv($handle, $row);
    fclose($handle);    
}
?>