<?php 
// Подключаем полезную функцию dumper() 
require_once "dumper.php";

function makerSqlQuery ($tmpPdo, $sql, $prePar=[""]) {
    $sth = $tmpPdo->prepare($sql);
    $sth->execute($prePar);
    $res = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $res;
}
?>