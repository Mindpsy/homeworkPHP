<?php 
if(isset($_GET['pathDel'])) {
    $path = $_GET['pathDel'];
    if(unlink($path)) {
        header("location: list.php");
    } else {
        echo "Ошибка при удалении";
    }
}

?>